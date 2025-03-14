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
    if (!in_array($_SESSION["id_operateur"],$_GET)) 
    {
        header('Location:deconnexion.php');
    }

    //requette pour relever tous les projets crée 
    $requet_liste_projet = "select * from projet order by date_create";
    $contenu_liste_projet = requet($requet_liste_projet);

    if (!empty($contenu_liste_projet)) //on vérifie si la requette renvoie quelque chose
    {
        //récupération des id_projet
        $tab_id_projet = array();
        if (gettype($contenu_liste_projet)=='object') 
        {
            $tab_id_projet[] = $contenu_liste_projet->id_projet;
        }
        else
        {
            foreach ($contenu_liste_projet as $cont) 
            {
                $tab_id_projet[] = $cont -> id_projet;
            }
        }
        
        //Création de la session qui contiendra l'id_projet
        $_SESSION["tab_id_projet"] = $tab_id_projet ;
    }
    
    




    require("view/liste_projet.view.php");

?>