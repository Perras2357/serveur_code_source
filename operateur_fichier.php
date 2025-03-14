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
    if (!in_array($_SESSION["id_operateur"],$_GET)|| !in_array($_GET["id_projet"],$_SESSION["tab_id_projet"]) || !in_array($_GET["id_module"],$_SESSION["tab_id_module"]) || !in_array($_SESSION["id_fichier"],$_GET) ) 
    {
        header('Location:deconnexion.php');
    }

    //requette pour relever tous les operateurs crée
    $requet_liste_operateur = "select * from operateur";
    $contenu_liste_operateur = requet($requet_liste_operateur);
 
    if (!empty($contenu_liste_operateur)) //on vérifie si la requette renvoie quelque chose
    {
        //récupération des id_operateur
        $tab_id_operateur1 = array();
        if (gettype($contenu_liste_operateur)=='object') 
        {
            $tab_id_operateur1[] = $contenu_liste_operateur->id_operateur;
        }
        else
        {
            foreach ($contenu_liste_operateur as $cont) 
            {
                $tab_id_operateur1[] = $cont -> id_operateur;
            }
        }
    }

    //requet qui permet de récupérer les id_operateur qui travail dans ce fichier
    $requet_operateur_fichier = "select id_operateur from operateur_fichier where id_fichier=?";
    $tab = [$_SESSION["id_fichier"]];
    $contenu_operateur_fichier = requet($requet_operateur_fichier,$tab);

    //on vérifie si le resultat de la requette est nul
    if (!empty($contenu_operateur_fichier)) 
    {
        //récupération les id_operateur
        $tab_id_operateur = array();
        if (gettype($contenu_operateur_fichier)=='object') 
        {
            $tab_id_operateur[] = $contenu_operateur_fichier->id_operateur;
        }
        else
        {
            foreach ($contenu_operateur_fichier as $cont) 
            {
                $tab_id_operateur[] = $cont -> id_operateur;
            }
        }

        //on recupère les id_operateur des operateurs qui ne travail pas sur ce fichier
        $tab_id_valide=array_diff($tab_id_operateur1,$tab_id_operateur);
    }
    
    
    //Ici on gérer l'ajout d'un operateur sur un projet
    if(isset($_POST['ajouter'])) //vérifie si la variable validé existe
    {
        extract($_POST);

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
            $tab = [$id_operateur_fichier,$_SESSION["id_fichier"],$ajouter] ;
            $insert=requet($requet_insert_operateur_fichier,$tab);
            //header("Location:option_fichier.php?id_operateur=".$_SESSION["id_operateur"]."&id_module=".$_SESSION["id_module"]."&id_fichier=".$_SESSION["id_fichier"]);
    }
    
    




    require("view/operateur_fichier.view.php");

?>