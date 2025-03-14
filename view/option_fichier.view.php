<?php
   require("partial/head.php"); 
?>


    <div class="album py-5 bg-light"> 
        <div class="container">
            
            <div class="row align-items-center ">

                <form method="post">
                    <div class="row align-items-center ">
                        <!-- logo fichier -->
                        <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4 h-100 shadow mb-4">
                                <img  src="img/liste_projet.png" alt="fichier" class="img_nav col-lg-12 col-md-12" >
                        </div>
                        <div class="card-body">
                            <h6 class="col-lg-2 col-md-4 offset-lg-5 offset-md-4"><?=$_SESSION["nom_fichier"];?></h6>
                        </div><!-- card-body -->

                        <!-- Download -->
                        <div class="col-lg-2 col-md-4 offset-lg-4 offset-md-5 h-100 shadow mb-4">
                            <a id="fichier" href="download.php?id_operateur=<?=$_SESSION["id_operateur"];?>&id_projet=<?=$_GET["id_projet"];?>&id_module=<?=$_GET["id_module"];?>&id_fichier=<?=$_SESSION["id_fichier"];?>">
                                <h6 class="text-center bg-success">Download</h6>
                            </a>
                        </div><!-- end_col -->

                        <!-- Upload -->
                        <div class="col-lg-2 col-md-4  h-100 shadow mb-4">
                            <a id="fichier" href="upload_fichier.php?id_operateur=<?=$_SESSION["id_operateur"];?>&id_projet=<?=$_GET["id_projet"];?>&id_module=<?=$_GET["id_module"];?>">
                                <h6 class="text-center bg-success">Upload</h6>
                            </a>
                        </div><!-- end_col -->
                            
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col-lg-2 col-md-2">Nom Acteur</th>
                                    <th scope="col-lg-2 col-md-2 ">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if (!empty($contenu_operateur_fichier)) //on vérifie s'il y'a un fichier
                                    {
                                        foreach($contenu_operateur_fichier as $element_operateur_fichier):
                                            $requet_nom_operateur = "select * from operateur where id_operateur=?";
                                            $tab_nom = [$element_operateur_fichier->id_operateur];
                                            $contenu_op_fic = requet($requet_nom_operateur,$tab_nom);
                                ?>
                                        <tr>
                                            <th><h6 class="mt-5"><?=$contenu_op_fic->nom_operateur;?></h6></th> 
                                            <?php
                                                if ($contenu_op_fic->id_type_user=="T0002") 
                                                {
                                            ?>
                                                    <th><h6 class="mt-5"><button type="submit" class="btn btn-success col-lg-5 col-md-4" name="retirer" value="<?=$element_operateur_fichier->id_operateur_fichier;?>">Retirer</button></h6></th>
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
                                        header("Location:liste_fichier.php?id_operateur=".$_SESSION["id_operateur"]."&id_projet=".$_SESSION["id_projet"]."&id_module=".$_SESSION["id_module"]."");
                                    }
                                ?>
                            </tbody>
                        </table>

                        <!-- Ajouter un acteur au traitement d'un fichier -->
                        <div class="col-lg-2 col-md-4 offset-lg-4 offset-md-5 h-100 shadow mb-4">
                            <a id="ajout" href="operateur_fichier.php?id_operateur=<?=$_SESSION["id_operateur"];?>&id_projet=<?=$_GET["id_projet"];?>&id_module=<?=$_GET["id_module"];?>&id_fichier=<?=$_SESSION["id_fichier"];?>">
                                <h6 class="text-center bg-success">Ajouter un opérateur</h6>
                            </a>
                        </div><!-- end_col -->

                    </div>
                </form>
            </div>
        </div>













        
    </div><!--***************album************************-->

















<?php
   require("partial/footer.php");  
?>