<?php
    //----- création de la session ----------------------
    session_start();

    //elements de connexion à la base de données
    $host = 'localhost' ;
    $dbname = 'serveur_code_source' ;
    $client = 'root' ;
    $mdp = '' ;

    //Appel de fichiers
    require("function/fonctions.php");
    require_once("config/dbconnexion.php");

    //---------------- Appel de la fonction de connexion à la base de données-------------------------------
    $bd = connexion($host,$dbname,$client,$mdp);

    $erreur = array();  //Variable qui récupère les erreurs

    //on vérifie si c'est bien l'utilisateur qui s"est connecté qui est connecté
    if (!in_array($_SESSION["id_operateur"],$_GET)|| !in_array($_GET["id_projet"],$_SESSION["tab_id_projet"]) || !in_array($_GET["id_module"],$_SESSION["tab_id_module"]) ) 
    {
        header('Location:deconnexion.php');
    }

    //session id_module
    $_SESSION["id_module"] = $_GET["id_module"];

    
    // Vérifier si le formulaire a été soumis
    if(isset($_FILES["fichier"]))
    {
        //var_dump(pathinfo($_FILES["fichier"]["name"], PATHINFO_EXTENSION));
            
        //on vérifie les erreurs qui peuvent survenir lors du transfert du fichier
        if ($_FILES['fichier']['error']) 
        {
            switch ($_FILES['fichier']['error'])
            {
            case 1: // UPLOAD_ERR_INI_SIZE -> si le fichier dépasse la valeur autorisé par le serveur
                $erreur[] = "Le fichier dépasse la limite autorisée par le serveur!";
                break;
            case 2: // UPLOAD_ERR_FORM_SIZE -> si le fichier dépasse  la valeur autorisé par le formulaire
                $erreur[] = "Le fichier dépasse la limite autorisée dans le formulaire !";
                break;
            case 3: // UPLOAD_ERR_PARTIAL -> si le transfert du fichier a été interrompu
                $erreur[] = "L'envoi du fichier a été interrompu pendant le transfert !";
                break;
            case 4: // UPLOAD_ERR_NO_FILE -> si le fichier a une taille nulle
                $erreur[] = "Le fichier que vous avez envoyé a une taille nulle !";
                break;
            }
        }

        //ici on vérifie s'il n'y'a pas d'erreur 
        if (empty($erreur)) 
        {
            
            //on vérifie si le nom de fichier existe deja dans la bd
            $requet_nom_fichier = "select * from fichier where nom_fichier='".$_FILES["fichier"]["name"]."'";
            $tab_nom_fichier = [];
            $contenu_nom_fichier = requet($requet_nom_fichier);

            //si le fichier existe dans la bd
            if (!empty($contenu_nom_fichier)) 
            {
                //relève d'information qui servirons à l'archivage
                foreach ($contenu_nom_fichier as $value)
                {
                    $ancien_operateur_modif = $value->id_operateur_modif;
                    $date_derniere_modif = $value->date_modif;
                    $id_fichier = $value->id_fichier;
                }
                
                //ici on sépare le nom du fichier de son extension
                $name_extension = explode('.',$_FILES["fichier"]["name"]);
                //var_dump();

                //je fais les mises à jour de la bd 
                //Mise à jour de la table fichier
                $requet_update_fichier = "update fichier set id_operateur_modif=?,date_modif= CURRENT_TIME() where id_fichier=?";
                $tab_update = [$_SESSION["id_operateur"],$id_fichier];
                $contenu = requet($requet_update_fichier,$tab_update);

                /*  on déplace l'ancien fichier vers les archives avec un nouveau nom
                    composé du nom du fichier du nom de l'opérateur qui a supprimé et de la date de derniere motification
                */
                if (rename($_SESSION["nom_projet"].'/'.$_SESSION["nom_module"].'/'.$_FILES["fichier"]["name"],$_SESSION["nom_projet"].'/'."ARCHIVE/".$name_extension[0].'_'.$ancien_operateur_modif.date('d-m-y').'.'.$name_extension[1]))
                {
                    // on retire le fichier de son emplacement temporaire (tmp_name) pour l'envoyer dans son module correspondant
                    move_uploaded_file($_FILES["fichier"]["tmp_name"], $_SESSION["nom_projet"].'/'.$_SESSION["nom_module"].'/'.$_FILES["fichier"]["name"]);
                }


            }
            //le fichier n'existe pas dans la bd alors on l'ajoute
            else
            {
                $nom_fichier=$_SESSION["nom_module"].'_'.$_FILES["fichier"]["name"];    //ici on concataine le nom du fichier au nom de module pour avoir une nomenclature correcte
                
                
                //inscription du fichier dans la bd
                $requet_fichier = "select * from fichier order by date_create desc limit 1";
                $contenu_fichier = requet($requet_fichier); //Appel de la fonction qui génère les requetes
                if (!empty($contenu_fichier)) //Vérifie si la requete renvoie du contenu
                {
                    foreach ($contenu_fichier as $element) 
                    {
                        $id0 = $element -> id_fichier ;
                    }
                    //génération de id_module   
                    $taille = strlen($id0) - 1; 
                    $id_fichier = (int) substr($id0, 1);
                    $id_fichier = $id_fichier + 1 ;
                    $id_fichier = substr(str_repeat(0,$taille).$id_fichier,-$taille);
                    $id_fichier = 'F'.$id_fichier;
                }
                else
                {
                    $id_fichier = 'F0001';
                }

                //insertion dans la table fichier
                $requet_insert_fichier = 'INSERT INTO fichier (id_fichier,id_module,id_operateur_modif,nom_fichier,date_create,date_modif) VALUES(?,?,?,?,NOW(),NOW())';
                $tab = [$id_fichier,$_SESSION["id_module"],$_SESSION["id_operateur"],$nom_fichier] ;
                $insert=requet($requet_insert_fichier,$tab);

                //Insertion dans la table operateur_fichier
                $requet_operateur_fichier = "select * from operateur_fichier order by date_create desc limit 1";
                $contenu_operateur_fichier = requet($requet_operateur_fichier); //Appel de la fonction qui génère les requetes
                if (!empty($contenu_operateur_fichier)) //Vérifie si la requete renvoie du contenu
                {
                    foreach ($contenu_operateur_fichier as $element) 
                    {
                        $id0 = $element -> id_operateur_fichier ;
                    }
                    //génération de id_module   
                    $taille = strlen($id0) - 1; 
                    $id_operateur_fichier = (int) substr($id0, 1);
                    $id_operateur_fichier = $id_operateur_fichier + 1 ;
                    $id_operateur_fichier = substr(str_repeat(0,$taille).$id_operateur_fichier,-$taille);
                    $id_operateur_fichier = 'O'.$id_operateur_fichier;
                }
                else
                {
                    $id_operateur_fichier = 'O0001';
                }

                //insertion dans la table fichier
                $requet_insert_operateur_fichier = 'INSERT INTO operateur_fichier (id_operateur_fichier,id_fichier,id_operateur,date_create) VALUES(?,?,?,NOW())';
                $tab = [$id_operateur_fichier,$id_fichier,$_SESSION["id_operateur"]] ;
                $insert=requet($requet_insert_operateur_fichier,$tab);

                //transfert du fichier dans le dossier
                move_uploaded_file($_FILES["fichier"]["tmp_name"], $_SESSION["nom_projet"].'/'.$_SESSION["nom_module"].'/'.$nom_fichier);

            }
           //header('Location:liste_fichier.php?id_operateur='.$_SESSION["id_operateur"].'&id_projet='.$_GET["id_projet"].'&id_module='.$_GET["id_module"].'');

        }


    }   





    require("view/upload_fichier.view.php");

?>-
