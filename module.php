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
    if (!in_array($_SESSION["id_operateur"],$_GET) || !in_array($_GET["id_projet"],$_SESSION["tab_id_projet"]) ) 
    {
        header('Location:deconnexion.php');
    }

    //récupération du nom du projet
    //requette pour relever le nom de ce projet 
    $requet_nom_projet = "select nom_projet from projet where id_projet=?";
    $tab = [$_GET["id_projet"]];
    $contenu_nom_projet = requet($requet_nom_projet,$tab);
    //session qui contiendra le nom du projet
    $_SESSION["nom_projet"] = $contenu_nom_projet -> nom_projet;

    //requette pour relever tous les modules de ce projet 
    $requet_liste_module = "select * from module where id_projet=? order by date_create";
    $tab = [$_GET["id_projet"]];
    $contenu_liste_module = requet($requet_liste_module,$tab);

    if (!empty($contenu_liste_module)) //on vérifie si la requette renvoie quelque chose
    {
        //récupération des id_module
        $tab_id_module = array();
        if (gettype($contenu_liste_module)=='object') 
        {
            $tab_id_module[] = $contenu_liste_module->id_module;
        }
        else
        {
            foreach ($contenu_liste_module as $cont) 
            {
                $tab_id_module[] = $cont -> id_module;
            }
        }
        
        //Création de la session qui contiendra l'id_module
        $_SESSION["tab_id_module"] = $tab_id_module ;
    }


    require("view/module.view.php");

?>