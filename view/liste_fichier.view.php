<?php
   require("partial/head.php"); 
?>


    <div class="album py-5 bg-light"> 
        <div class="container">
            
            <div class="row align-items-center ">
                <div class="col-md-12 shadow-none p-3 mb-5 bg-light rounded p-5">
                    <form method="post"> <!-- formulaire qui va permettre de gerer l'importation d'un fichier -->
                        <!-- logo ajout fichier -->
                        <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4 mb-5">
                            <div class="shadow-none">        
                                <a id="fichier" href="upload_fichier.php?id_operateur=<?=$_SESSION["id_operateur"];?>&id_projet=<?=$_GET["id_projet"];?>&id_module=<?=$_GET["id_module"];?>">
                                    <img src="img/ajouter_fichier.png" alt="ajouter_fichier" class="img_nav  col-lg-12 col-md-12">
                                    <div class="parag py-1">
                                        <h6 class="text-center">Ajouter fichier</h6>
                                    </div>
                                </a>
                            </div>
                        </div> <!--end_col -->

                    
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col-lg-1 col-md-1">Nom</th>
                                    <th scope="col-lg-2 col-md-2">Date_create</th>
                                    <th scope="col-lg-2 col-md-2">Date Modification</th>
                                    <th scope="col-lg-2 col-md-2">Acteur Modif</th>
                                    <th scope="col-lg-1 col-md-1">Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if (!empty($contenu_liste_fichier)) //on vérifie s'il y'a un fichier
                                    {
                                        foreach($contenu_liste_fichier as $element_liste_fichier):
                                            $requet_nom_modif = "select * from operateur where id_operateur=?";
                                            $tab_nom = [$element_liste_fichier->id_operateur_modif];
                                            $contenu_nom_modif = requet($requet_nom_modif,$tab_nom);
                                ?>
                                        <tr>
                                            <th><h6 class="mt-5"><?=$element_liste_fichier->nom_fichier;?></h6></th> 
                                            <th><h6 class="mt-5"><?=$element_liste_fichier->date_create;?></h6></th>
                                            <th><h6 class="mt-5"><?=$element_liste_fichier->date_modif;?></h6></th>
                                            <th><h6 class="mt-5"><?=$contenu_nom_modif->nom_operateur;?></h6></th>
                                            <th><h6 class="mt-5"><a type="submit" class="btn btn-success col-lg-12 col-md-10" href="option_fichier.php?id_operateur=<?=$_SESSION["id_operateur"];?>&id_projet=<?=$_SESSION["id_projet"];?>&id_module=<?=$_SESSION["id_module"];?>&id_fichier=<?=$element_liste_fichier->id_fichier;?>">Options</a></h6></th>
                                        </tr>
                                <?php 
                                        endforeach;
                                    }
                                    else 
                                    {
                                ?>
                                        <div class="col-lg-6 col-md-8 offset-lg-3 offset-md-2">
                                            <h6 class="text-center bg-success">Il n'y a pas de fichier</h6>
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