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

    //requette pour relever tous les operateurs crée
    $requet_liste_operateur = "select * from operateur order by date_create";
    $contenu_liste_operateur = requet($requet_liste_operateur);

    if (!empty($contenu_liste_operateur)) //on vérifie si la requette renvoie quelque chose
    {
        //récupération des id_operateur
        $tab_id_operateur = array();
        if (gettype($contenu_liste_operateur)=='object') 
        {
            $tab_id_operateur[] = $contenu_liste_operateur->id_operateur;
        }
        else
        {
            foreach ($contenu_liste_operateur as $cont) 
            {
                $tab_id_operateur[] = $cont -> id_operateur;
            }
        }
        
        //Création de la session qui contiendra l'id_operateur
        $_SESSION["tab_id_operateur"] = $tab_id_operateur ;
    }
    
    //Ici on gérer la suppression d'un acteur
    if(isset($_POST['delete'])) //vérifie si la variable validé existe
    {
        extract($_POST);
        $contenu_delete = [$delete]; //tableau à controler pour la requette
        $requet_delete = "delete from operateur where id_operateur=? ";
        $contenu_delete = requet($requet_delete,$contenu_delete);
        header("Location:liste_acteur.php?id_operateur=".$_SESSION["id_operateur"]."");
    }
    
    




    require("view/liste_acteur.view.php");

?>