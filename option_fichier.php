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
    if (!in_array($_SESSION["id_operateur"],$_GET)|| !in_array($_GET["id_projet"],$_SESSION["tab_id_projet"]) || !in_array($_GET["id_module"],$_SESSION["tab_id_module"]) || !in_array($_GET["id_fichier"],$_SESSION["tab_id_fichier"]) ) 
    {
        header('Location:deconnexion.php');
    }

    //récupération du nom du fichier
    //requette pour relever le nom de ce fichier 
    $requet_nom_fichier = "select * from fichier where id_fichier=?";
    $tab = [$_GET["id_fichier"]];
    $contenu_nom_fichier = requet($requet_nom_fichier,$tab);
    
    //session qui contiendra le nom du fichier
    $_SESSION["nom_fichier"] = $contenu_nom_fichier -> nom_fichier;
    //session id_fichier
    $_SESSION["id_fichier"] = $contenu_nom_fichier -> id_fichier;

    //requette pour relever tous les operateurs actifs sur ce fichier
    $requet_operateur_fichier = "select * from operateur_fichier where id_fichier='".$_SESSION["id_fichier"]."' order by date_create";
    $contenu_operateur_fichier = requet($requet_operateur_fichier);

    if (!empty($contenu_operateur_fichier)) //on vérifie si la requette renvoie quelque chose
    {
        //récupération des id_operateur_fichier
        $tab_id_operateur_fichier = array();
        if (gettype($contenu_operateur_fichier)=='object') 
        {
            $tab_id_operateur_fichier[] = $contenu_operateur_fichier->id_operateur_fichier;
        }
        else
        {
            foreach ($contenu_operateur_fichier as $cont) 
            {
                $tab_id_operateur_fichier[] = $cont -> id_operateur_fichier;
            }
        }
        
        //Création de la session qui contiendra l'id_fichier
        $_SESSION["tab_id_operateur_fichier"] = $tab_id_operateur_fichier ;
    }
    //ici on gère l'ajout d'un opérateur au traitement d'un fichier
    if (isset($_POST['ajouter'])) 
    {
        extract($_POST);
        var_dump($op);

        // //Insertion dans la table operateur_fichier
        // $requet_operateur_fichier = "select * from operateur_fichier order by date_create desc limit 1";
        // $contenu_operateur_fichier = requet($requet_operateur_fichier); //Appel de la fonction qui génère les requetes
        // if (!empty($contenu_operateur_fichier)) //Vérifie si la requete renvoie du contenu
        // {
        //     foreach ($contenu_operateur_fichier as $element) 
        //     {
        //         $id0 = $element -> id_operateur_fichier ;
        //     }
        //     //génération de id_module   
        //     $taille = strlen($id0) - 1; 
        //     $id_operateur_fichier = (int) substr($id0, 1);
        //     $id_operateur_fichier = $id_operateur_fichier + 1 ;
        //     $id_operateur_fichier = substr(str_repeat(0,$taille).$id_operateur_fichier,-$taille);
        //     $id_operateur_fichier = 'O'.$id_operateur_fichier;
        // }
        // else
        // {
        //     $id_operateur_fichier = 'O0001';
        // }

        // //insertion dans la table fichier
        // $requet_insert_operateur_fichier = 'INSERT INTO operateur_fichier (id_operateur_fichier,id_fichier,id_operateur,date_create) VALUES(?,?,?,NOW())';
        // $tab = [$id_operateur_fichier,$id_fichier,$ajouter] ;
        // $insert=requet($requet_insert_operateur_fichier,$tab);

    }


    //Ici on gérer le retrait d'un operateur d'un fichier
    if(isset($_POST['retirer'])) //vérifie si la variable validé existe
    {
        extract($_POST);
        $contenu_retirer = [$retirer]; //tableau à controler pour la requette
        $requet_retirer = "delete from operateur_fichier where id_operateur_fichier=?";
        $contenu_retirer = requet($requet_retirer,$contenu_retirer);
        header("Location:option_fichier.php?id_operateur=".$_SESSION["id_operateur"]."&id_projet=".$_SESSION["id_projet"]."&id_module=".$_SESSION["id_module"]."&id_fichier=".$_SESSION["id_fichier"]."");
    }
    
    




    require("view/option_fichier.view.php");

?>
