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
 
    if(isset($_POST['connexion'])) //vérifie si la variable validé existe
    {
        extract($_POST);
        $controle = [$login, $mdp]; //tableau à controler

        if (tab_vide($controle)==true) // Vérifie si tous les éléments du tableau ont du contenu
        {
            if (mb_strlen($login)<3) 
            {
                $erreur["login"] = "Veillez entrer un login valide SVP";//Erreur si le login ne correspond pas
            }
            if (mb_strlen($mdp)<4) 
            {
                $erreur["mdp"] = "Veillez entrer un password valide SVP";//Erreur si le password ne correspond pas
            }
            if (empty($erreur)) 
            {
                //requette qui va me permettre de vérifier si c'est un operateur qui zessaie de se connecter
                $requet1 = "select * from operateur where pseudo =?";
                $tab_inconnu = [$login];
                $contenu_user1 = requet($requet1,$tab_inconnu); 

                if (!empty($contenu_user1)) 
                {
                    //controle de mdp
                    $mdp_operateur = $contenu_user1 -> mdp_operateur;
                    if ($mdp_operateur == $mdp) 
                    {
                        $id_operateur = $contenu_user1 -> id_operateur;
                        
                        //creation de la session id_operateur
                        $_SESSION["id_operateur"] = $id_operateur;
                        //session id_type_user
                        $_SESSION["id_type_user"] = $contenu_user1 -> id_type_user;

                        //on vérifie le type d'utilisateur
                        if (($contenu_user1 -> id_type_user)=="T0001") 
                        {
                            //redirection vers la page dasboard
                            header('Location:dashboard.php?id_operateur='.$id_operateur.'');
                        }
                        else
                        {
                            //projet par user
                            echo "noooooooooooooooooooooonnn";
                        }
                       
                    }
                    else 
                    {
                        $erreur1= 'Ce mot de passe ne correspond pas au login';
                    }     
                }
                else 
                {
                    $erreur1= 'Ce Login n\'existe pas';
                }
            }                 
        }
        else
        {
            $erreur1 = "Veillez remplir tous les champs SVP"; //Erreur si aumoins un élément du tableau est vide
        }
    }









require("view/index.view.php");
?>