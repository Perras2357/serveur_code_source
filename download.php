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
    if (!in_array($_SESSION["id_operateur"],$_GET)|| !in_array($_GET["id_projet"],$_SESSION["tab_id_projet"]) || !in_array($_GET["id_module"],$_SESSION["tab_id_module"]) || !in_array($_SESSION["id_fichier"],$_GET) ) 
    {
        header('Location:deconnexion.php');
    }
    
    // Vérifier si le formulaire a été soumis
    if(isset($_POST["download"]))
    {
       //requet pour vérifier que le fichier existe vraiment dans la bd
       $requet_file = "select * from fichier where id_fichier=?";
       $tab_file = [$_SESSION["id_fichier"]];
       $contenu_file = requet($requet_file,$tab_file);
       $nom_fichier = $contenu_file->nom_fichier;

       if (!empty($contenu_file)) 
       {
            //var_dump($_SESSION["nom_module"]);
            //chemin complet du fichier

            //on vérifie si le fichier existe dans le repertoire 
            $path = $_SESSION["nom_projet"].'/'.$_SESSION["nom_module"].'/'.$nom_fichier;
            if (file_exists($path)) 
            {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octect-stream');
                header('Content-Disposition: attachment; filename="'.$nom_fichier.'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: '.filesize($path));
                readfile($path);
            }
       }
       else 
       {
            $erreur[] = "Ce fichier n'existe pas dans la base de donnée ";
       }

    }   





    require("view/download.view.php");

?>-
