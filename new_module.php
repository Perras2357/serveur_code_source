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
    if (!in_array($_SESSION["id_operateur"],$_GET) || !in_array($_GET["id_projet"],$_SESSION["tab_id_projet"])) 
    {
        header('Location:deconnexion.php');
    }

    //session id_module 
    $_SESSION["id_projet"] = $_GET["id_projet"];

    if(isset($_POST['creer'])) //vérifie si la variable creer existe
    {
        extract($_POST);
        $controle = [$module, $mdp]; //tableau à controler
        if (tab_vide($controle)==true) // Vérifie si tous les éléments du tableau ont du contenu
        {
            if (mb_strlen($module)<4) 
            {
                $erreur["module"] = "Veillez entrer un nom de module valide SVP";//Erreur si le nom ne correspond pas
            }
            else 
            {
               //On vérifie si le nom entré ne correspond pas à un nom de module existant
                $requet_nom_module = "select * from module where nom_module=?";
                $tab_nom_module = [$module];
                $contenu_nom_module = requet($requet_nom_module,$tab_nom_module);
                if (!empty($contenu_nom_module)) 
                {
                    $erreur["module"] = "Veillez entrer un nom de module qui n'existe pas SVP";//Erreur si le nom ne correspond pas

                }
            }
            if ($_SESSION["mdp_operateur"]!=$mdp) 
            {
                $erreur["mdp"] = "Veillez entrer un password valide SVP";//Erreur si le password ne correspond pas
            }  
            if (empty($erreur)) 
            {
                $requet_module = "select * from module order by date_create desc limit 1";
                $contenu_module = requet($requet_module); //Appel de la fonction qui génère les requetes
                if (!empty($contenu_module)) //Vérifie si la requete renvoie du contenu
                {
                    foreach ($contenu_module as $element) 
                    {
                        $id0 = $element -> id_module ;
                    }
                    //génération de id_module   
                    $taille = strlen($id0) - 1; 
                    $id_module = (int) substr($id0, 1);
                    $id_module = $id_module + 1 ;
                    $id_module = substr(str_repeat(0,$taille).$id_module,-$taille);
                    $id_module = 'M'.$id_module;
                }
                else
                {
                    $id_module = 'M0001';
                } 
                //fin de id_module
                //insertion dans la bd
                $requet_insert_module = 'INSERT INTO module (id_module,id_projet,nom_module,date_create) VALUES(?,?,?,NOW())';
                $tab = [$id_module,$_SESSION["id_projet"],$module] ;
                $insert=requet($requet_insert_module,$tab);
                
                //---------------------création du dossier module ---------------------------
                //$chemin = "Bureau/".$module."";//chemin d'accès au repertoire ou se trouvera le module
                $nom_modossier = $_SESSION["nom_projet"].'/'.$module;
                if (is_dir($nom_modossier)) //vérification de l'existence du repertoire
                {
                    $erreur1 = 'Ce dossier module existe déja!';
                }
                else
                {
                    if (mkdir($nom_modossier)) 
                    {
                        //redirection vers la page liste module
                        header('Location:liste_module.php?id_operateur='.$_SESSION["id_operateur"].'&id_projet='.$_GET["id_projet"].'');
                
                    }
                }


                
                
            }

        }
        else
        {
            $erreur1 = "Veillez remplir tous les champs SVP"; //Erreur si aumoins un élément du tableau est vide
        }
    }




    require("view/new_module.view.php");

?>