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
                                    <th scope="col">Status</th>
                                    <th scope="col">Nombre de Projet</th>
                                    <th scope="col">Supprimer</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if (!empty($contenu_liste_operateur)) //on vérifie s'il y'a un acteur
                                    {
                                        foreach($contenu_liste_operateur as $element_liste_operateur):
                                            //requette qui permettra de de retourner le type d'utilisateur
                                            $requet_statut = "select user.nom_type_user from user inner join operateur on operateur.id_type_user=user.id_type_user where operateur.id_operateur=?";
                                            $tab_statut = [$element_liste_operateur->id_operateur];
                                            $contenu_statut = requet($requet_statut,$tab_statut);
                                ?>
                                        <tr>
                                            <th><h6 class="mt-5"><?=$element_liste_operateur->nom_operateur;?></h6></th> 
                                            <?php
                                                if(!empty($contenu_liste_operateur))
                                                {
                                            ?>
                                                <th><h6 class="mt-5"><?=$contenu_statut->nom_type_user;?></h6></th>
                                            <?php
                                                }
                                                else
                                                {
                                            ?>
                                                    <th><h6 class="mt-5"></h6></th>
                                            <?php
                                                }
                                            ?>

                                            <th><h6 class="mt-5">5</h6></th>
                                            <?php
                                                if($element_liste_operateur->id_type_user!="T0001")
                                                {
                                            ?>
                                                    <th><h6 class="mt-5"><button type="submit" class="btn btn-success col-lg-7 col-md-6" name="delete" value="<?=$element_liste_operateur->id_operateur;?>">Supprimer</button></h6></th>
                                            <?php
                                                }
                                                else
                                                {
                                            ?>
                                                    <th><h6 class="mt-5">/</h6></th>
                                                    <?php
                                                }
                                            ?>

                                        </tr>
                                <?php 
                                        endforeach;
                                    }
                                    else 
                                    {
                                        //s'il n'y'a pas d'autre operateur on propose l'ajout d'acteur
                                ?>
                                        <div class="col-lg-6 col-md-8 offset-lg-3 offset-md-2">
                                            <h6 class="text-center bg-success">Il n'y a pas d'acteur</h6>
                                        </div>

                                        <!-- logo ajout operateur -->
                                        <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
                                            <div class="shadow-none">        
                                                <a id="operateur" href="new_acteur.php?id_operateur=<?=$_SESSION["id_operateur"];?>">
                                                    <img src="img/ajouter_acteur.jpeg" alt="ajouter_acteur" class="img_nav  col-lg-12 col-md-12">
                                                    <div class="parag py-1">
                                                        <h6 class="text-center">Ajouter un acteur </h6>
                                                    </div>
                                                </a>
                                            </div>
                                        </div> <!--end_col -->
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