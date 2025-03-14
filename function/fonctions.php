<?php

//Fonction qui vérie si un champ est vide ou pas
    function champ_vide(string $nom_champ)
    {
        //$nom_inter = rtrim($nom_champ,' '); ici on supprime tous les espaces en les remplacant par RIEN
        if(!empty($nom_champ) && trim($nom_champ,' ' ) != '')
        {
            // echo "le champ ".$nom_champ." n'est pas vide";
            return 1 ;
        }
        else
        {
          // echo "le champ ".$nom_champ." est vide";
          return 0 ;
        }
        
    } 


    //Fonction qui permet de determiner le nombre de caracteres d'une chaine
    function nombre_carac(string $chaine, int $nbr_carac)
    {
        if ($nbr_carac>=1)
        {
            if(champ_vide($chaine))
            {
                if(mb_strlen($chaine)>$nbr_carac)
                {
                    echo " <br> le nombre de caractères de : ".$chaine." depasse ".$nbr_carac ;
                }
                else
                {
                    echo " <br> le nombre de caractères est règlementaire";
                }
                
            }
            else
            {
                echo ' <br> entrez du texte';
            }  
        }
        else
        {
            echo ' <br> entrez un nombre maximal de caractères strictement supérieure à 0';
        }
        
        
    }
  
//Fonction qui vérifie si un nom se trouve dans un tableau de noms 
    function etudiant (array $tab_etud , string $nom_recherche)
    {
        
            if(!empty($tab_etud)) 
            {
               if (champ_vide($nom_recherche))
                {
                    if (in_array($nom_recherche, $tab_etud)) 
                    {
                        echo "<br>".$nom_recherche."  se trouve dans le tableau";
                    }
                    else
                    {
                        echo "<br>".$nom_recherche."   ne se trouve pas dans le tableau";
                    }
                }
                else
                {
                    echo ' <br> entrez un nom à rechercher';
                } 
            }
            else 
            {
                echo " <br> entrez un tableau ayant du comptenu";
            }   
             
    }   
        
                        


//Fonction qui vérifie si un élément appartenant à d'un tatbleau se trouve dans un tableau de reference
    function comp_table(array $tab, array $tab_ref)
    {
        if (!empty($tab)&&!empty($tab_ref)) 
        {
            $tab_diff = array_diff($tab, $tab_ref);
            if (empty($tab_diff)) 
            {
                echo "Les deux tableaux sont identiques";
            }
            else
            {
                echo "ce qui se trouve dans le premier tableau qui ne se trouve pas dans le tableau de reférence sont : <br>";
                foreach ($tab_diff as $val) 
                {
                    echo $val."<br>" ;   
                }
            }
        }
        else
        {
            echo "entrez des tableaux avec des éléments dans la fonction";
        }
        
    } 
    
    //-------------------Fonction qui vérifie si un nombre d'élément donné est vide ou pas ----------
    function table_empty(array $nom_table )
    {
        $c = true ;
        foreach($nom_table as $values)
        {
            if (champ_vide($values)==0) 
            {
                $c = false;
            }
        }
        return $c ;
    }

// Fonction qui vérifie si les éléments d'un tableaux sont tous non nuls

function tab_vide(array $tab)
{
    $resultat = true ;
    if(!empty($tab))
    {
        foreach($tab as $element)
        {
            if(champ_vide($element)==0)
            {
                $resultat = false ;
            }
        }
    }
    return $resultat ; 
}


//-------------------------connexion à la bd-------------------------------------------
 
    //Fonction qui permet de générer une requet
    function requet($requet , array $tab = null)
    {
        
       global $bd ; 
       

        if ($tab!=null) 
        {
            
            $contenu = $bd -> prepare($requet);
            $contenu -> execute($tab);
            $nbr = $contenu-> rowcount();
            if($nbr>1)
            {
                $resultat = $contenu->fetchAll();
            }
            else
            {
                $resultat = $contenu->fetch();
            }
        }
        else
        {
            
            $contenu = $bd->query($requet);
            $resultat = $contenu->fetchAll();
            
        }
        
        return $resultat ;
    }
    
    #-------- Activer les pages ----------------------
    function activation($nom_page)
    {
        $page = array_pop(explode('/',$_SERVER['SCRIPT_NAME']) );

        if($page == $nom_page.'.php')
        {
            return 'active bg-dark';
        }
        
    }

    #-------------- Nom du site variable -------------------------------
    function nom_activation()
    {
        // var_dump($_SERVER['SCRIPT_NAME']);
        $var1 = explode('/',$_SERVER['SCRIPT_NAME']);
        $page = array_pop($var1);
        

        if(champ_vide($page)==1)
        {   
            $file=pathinfo($page, PATHINFO_FILENAME);
            if($file == 'index')
            {
                $a = 'ESAR';
                return $a;
            }
            $a = 'ESAR'.'-'.$file ;
            return $a;
        }
    }

    //------------------- Fonction qui permet de vérifier si la connexion est établit ------------------------
    function control_connex($table_session , $contenu)
    {
        if(isset($table_session) && $contenu==$table_session && isset($contenu))
        {
            return 'enabled';
        }
        else
        {
            return 'disabled';
        }
    }
    


    //----------------------Fonction qui Déplace un fichier dans un autre repertoire-------------------------------------------
    /* La fonction return 1 si le transfert du fichier a bien eu lieu
            La fonction return -1 si le fichier n'existe pas dans le repertoire de départ
                La fonction return -2 si la copie du fichier dans le nouveau repertoire a échoué
                    La fonction return -3 si le fichier n'a pas été supprimé dans l'ancien repertoire
    */
    function moveFile($dossierSource,$dossierDestination)
    {
        $retour = 1;

        //on vérifie si le fichier exixte dans le repertoir
        if (!file_exists($dossierSource)) 
        {
            $retour = -1;
        }
        else 
        {
            //on vérifie si la copie a bien eu lieu
            if(!copy($dossierSource,$dossierDestination))
            {
                $retour = -2;  
            }else 
            {
                //on vérifie si le fichier a été supprimé dans l'ancien repertoire
                if(!unlink($dossierSource))
                {
                    $retour = -3;
                }
            }
        }

        return $retour;
    }




?>