<?php
   require("partial/head.php"); 
?>


    <div class="album py-5 bg-light"> 
        <div class="container">
            
            <div class="row align-items-center ">
                <div class="col-md-12 shadow-none p-3 mb-5 bg-light rounded p-5">
                    <form   method="post"> <!-- formulaire qui va permettre de gerer la supression d'un acteur -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Ajouter</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    //on vérifie si le tableau qui doit contenir les operateur qui ne travail pas sur le projet est vide ou non
                                    if (!empty($tab_id_valide)) 
                                    {
                                        foreach($tab_id_valide as $element):
                                            //requette qui permettra de retourner les les informations des operateurs
                                            $requet_liste_operateur = "select * from operateur where id_operateur=? order by date_create";
                                            $tab_statut = [$element]; 
                                            $contenu_liste_operateur = requet($requet_liste_operateur,$tab_statut);
                                ?>
                                        <tr>
                                            <th><h6 class="mt-5"><?=$contenu_liste_operateur->nom_operateur;?></h6></th> 
                                            <th><h6 class="mt-5"><button type="submit" class="btn btn-success col-lg-7 col-md-6" name="ajouter" value="<?=$element;?>">Ajouter</button></h6></th>
                                        </tr>
                                <?php 
                                        endforeach;
                                    }
                                    else 
                                    {
                                        //s'il n'y'a pas d'operateur on est redirigé vers une page précédante
                                ?>
                                        <div class="col-lg-6 col-md-8 offset-lg-3 offset-md-2">
                                            <h6 class="text-center bg-success">Tous les opérateurs travaillent sur ce fichier</h6>
                                        </div>

                                       
                                <?php 
                                    }
                                ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>













        
    </div><!--***************album************************-->

















<?php
   require("partial/footer.php");  
?>