<?php
    //----- création de la session ----------------------
    session_start();

    //elements de connexion à la base de données
    $host = 'localhost' ;
    $dbname = 'serveur_code_source' ;
    $client = 'perras' ;
    $mdp = 'Mdp*2357' ;

    //Appel de fichiers
    require("function/fonctions.php");
    require_once("config/dbconnexion.php");

    //---------------- Appel de la fonction de connexion à la base de données-------------------------------
    $bd = connexion($host,$dbname,$client,$mdp);

    $erreur = array();  //Variable qui récupère les erreurs

    //on vérifie si c'est bien l'utilisateur qui s"est connecté qui est connecté
    if (!in_array($_SESSION["id_operateur"],$_GET)) 
    {
        header('Location:deconnexion.php');
    }

    if(isset($_POST['creer'])) //vérifie si la variable creer existe
    {
        extract($_POST);
        $controle = [$projet, $mdp]; //tableau à controler
        if (tab_vide($controle)==true) // Vérifie si tous les éléments du tableau ont du contenu
        {
            if (mb_strlen($projet)<4) 
            {
                $erreur["projet"] = "Veillez entrer un nom de projet valide SVP";//Erreur si le nom ne correspond pas
            }
            else 
            {
               //On vérifie si le nom entré ne correspond pas à un nom de projet existant
                $requet_nom_projet = "select * from projet where nom_projet=?";
                $tab_nom_projet = [$projet];
                $contenu_nom_projet = requet($requet_nom_projet,$tab_nom_projet);
                if (!empty($contenu_nom_projet)) 
                {
                    $erreur["projet"] = "Veillez entrer un nom de projet qui n'existe pas SVP";//Erreur si le nom ne correspond pas

                }
            }
            if ($_SESSION["mdp_operateur"]!=$mdp) 
            {
                $erreur["mdp"] = "Veillez entrer un password valide SVP";//Erreur si le password ne correspond pas
            }  
            if (empty($erreur)) 
            {
                $requet_projet = "select * from projet order by date_create desc limit 1";
                $contenu_projet = requet($requet_projet); //Appel de la fonction qui génère les requetes
                if (!empty($contenu_projet)) //Vérifie si la requete renvoie du contenu
                {
                    foreach ($contenu_projet as $element) 
                    {
                        $id0 = $element -> id_projet ;
                    }
                    //génération de id_projet   
                    $taille = strlen($id0) - 1; 
                    $id_projet = (int) substr($id0, 1);
                    $id_projet = $id_projet + 1 ;
                    $id_projet = substr(str_repeat(0,$taille).$id_projet,-$taille);
                    $id_projet = 'P'.$id_projet;
                }
                else
                {
                    $id_projet = 'P0001';
                } 
                //fin de id_projet
                //insertion dans la bd
                $requet_insert_projet = 'INSERT INTO projet (id_projet,nom_projet,date_create) VALUES(?,?,NOW())';
                $tab = [$id_projet,$projet] ;
                $insert=requet($requet_insert_projet,$tab);
                
                //---------------------création du dossier projet ---------------------------
                //$chemin = "Bureau/".$projet."";//chemin d'accès au repertoire ou se trouvera le projet
                
                if (is_dir($projet)) //vérification de l'existence du repertoire
                {
                    $erreur1 = 'Ce dossier projet existe déja!';
                }
                else
                {
                   // mkdir($projet);
                    if (mkdir($projet)) 
                    {
                        mkdir($projet.'/'.'ARCHIVE');
                        $success ='Le projet a été crée avec succès!';
                    }
                    //echo 'Le projet a été crée avec succès!';
                }


                
                
            }

        }
        else
        {
            $erreur1 = "Veillez remplir tous les champs SVP"; //Erreur si aumoins un élément du tableau est vide
        }
    }





    require("view/new_projet.view.php");

?>