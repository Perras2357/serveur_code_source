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
        $controle = [$nom_acteur,$prenom_acteur,$pseudo,$mdp]; //tableau à controler
        if (tab_vide($controle)==true) // Vérifie si tous les éléments du tableau ont du contenu
        {
            if (mb_strlen($nom_acteur)<3) 
            {
                $erreur["nom_acteur"] = "Veillez entrer un nom d'acteur valide SVP";//Erreur si le nom ne correspond pas
            }
            if (mb_strlen($prenom_acteur)<3) 
            {
                $erreur["prenom_acteur"] = "Veillez entrer un prenom d'acteur' valide SVP";//Erreur si le nom ne correspond pas
            }
            if (mb_strlen($pseudo)<3) 
            {
                $erreur["pseudo"] = "Veillez entrer un pseudo valide SVP";//Erreur si le nom ne correspond pas
            }
            if (mb_strlen($mdp)<4) 
            {
                $erreur["mdp"] = "Veillez entrer un mot de passe valide SVP";//Erreur si le nom ne correspond pas
            }
           
            if (empty($erreur)) 
            {
                //on vérifie si l'utilisateur existe deja 
                $requet_verif = "select * from operateur where pseudo='$pseudo' or mdp_operateur='$mdp' ";
                $contenu_verif = requet($requet_verif);
                if (empty($contenu_verif)) //création de l'id_operateur s'il n'existe pas
                {
                    $requet_operateur = "select * from operateur order by date_create desc limit 1";
                    $contenu_operateur = requet($requet_operateur); //Appel de la fonction qui génère les requetes
                    if (!empty($contenu_operateur)) //Vérifie si la requete renvoie du contenu
                    {
                        foreach ($contenu_operateur as $element) 
                        {
                            $id0 = $element -> id_operateur ;
                        }
                        //génération de id_operateur   
                        $taille = strlen($id0) - 1; 
                        $id_operateur = (int) substr($id0, 1);
                        $id_operateur = $id_operateur + 1 ;
                        $id_operateur = substr(str_repeat(0,$taille).$id_operateur,-$taille);
                        $id_operateur = 'A'.$id_operateur;
                    }
                    else
                    {
                        $id_operateur = 'A0001';
                    } 
                    //fin de id_operateur
                    //insertion dans la bd
                    $id_type_user='T0002';  //id_type_user (on insert un acteur)
                    $requet_insert_operateur = 'INSERT INTO operateur (id_operateur,id_type_user,nom_operateur,Prenom_operateur,pseudo,mdp_operateur,date_create) VALUES(?,?,?,?,?,?,NOW())';
                    $tab = [$id_operateur,$id_type_user,$nom_acteur,$prenom_acteur,$pseudo,$mdp] ;
                    $insert=requet($requet_insert_operateur,$tab);
                    header("Location:liste_acteur.php?id_operateur=".$_SESSION["id_operateur"]."");

                
                }
                else
                {
                    $erreur1 = "ce compte existe deja";//Erreur si le nom ne correspond pas
                }
   
            }

        }
        else
        {
            $erreur1 = "Veillez remplir tous les champs SVP"; //Erreur si aumoins un élément du tableau est vide
        }
    }





    require("view/new_acteur.view.php");

?>