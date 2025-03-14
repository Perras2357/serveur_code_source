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

    //on vérifie si c'est bien l'utilisateur qui s"est connecté qui est connecté
    if (!in_array($_SESSION["id_operateur"],$_GET)) 
    {
        header('Location:deconnexion.php');
    }
    
    //requette pour récupérer les informations sur l'operateur connecté
    $requet_id = "select * from operateur where id_operateur=?";
    $tab_inconnu_id = [$_SESSION["id_operateur"] ];
    $contenu_operateur = requet($requet_id,$tab_inconnu_id);
    $nom_operateur = $contenu_operateur -> nom_operateur;
    $prenom_operateur = $contenu_operateur -> Prenom_operateur;
    $mdp_operateur = $contenu_operateur -> mdp_operateur;
    $id_operateur = $contenu_operateur -> id_operateur;

    //création de la session mot de passe de l'operateur
    $_SESSION["mdp_operateur"] = $mdp_operateur;
    
    //var_dump($contenu_operateur);



    require("view/dashboard.view.php");

?>
