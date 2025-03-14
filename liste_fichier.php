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
    if (!in_array($_SESSION["id_operateur"],$_GET)|| !in_array($_GET["id_projet"],$_SESSION["tab_id_projet"]) || !in_array($_GET["id_module"],$_SESSION["tab_id_module"]) ) 
    {
        header('Location:deconnexion.php');
    }

    //récupération du nom du module
    //requette pour relever le nom de ce module 
    $requet_nom_module = "select * from module where id_module=?";
    $tab = [$_GET["id_module"]];
    $contenu_nom_module = requet($requet_nom_module,$tab);
    
    //session qui contiendra le nom du module et session id_module
    $_SESSION["nom_module"] = $contenu_nom_module -> nom_module;
    $_SESSION["id_module"] = $contenu_nom_module -> id_module;



    //requette pour relever tous les fichiers de ce module
    $requet_liste_fichier = "select * from fichier where id_module='".$_GET["id_module"]."' order by date_create";
    $contenu_liste_fichier = requet($requet_liste_fichier);
    
    //on vérifie si la requette renvoie quelque chose
    if (!empty($contenu_liste_fichier)) 
    {
        //récupération des id_fichier
        $tab_id_fichier = array();
        if (gettype($contenu_liste_fichier)=='object') 
        {
            $tab_id_fichier[] = $contenu_liste_fichier->id_fichier;
        }
        else
        {
            foreach ($contenu_liste_fichier as $cont) 
            {
                $tab_id_fichier[] = $cont -> id_fichier;
            }
        }
        
        //Création de la session qui contiendra l'id_fichier
        $_SESSION["tab_id_fichier"] = $tab_id_fichier ;
    }
    
    //Ici on gérer la suppression d'un acteur
    if(isset($_POST['delete'])) //vérifie si la variable validé existe
    {
        extract($_POST);
        $contenu_delete = [$delete]; //tableau à controler pour la requette
        $requet_delete = "delete from fichier where id_fichier=? ";
        $contenu_delete = requet($requet_delete,$contenu_delete);
        header("Location:liste_acteur.php?id_fichier=".$_SESSION["id_fichier"]."");
    }
    
    




    require("view/liste_fichier.view.php");

?>
