<?php
   require("partial/head.php"); 
?>

<div class="album py-5 bg-light">
        <div class="container">
            <h1 class="text-center mb-5">Modules</h1> 

            <div class="row g-3 mb-2">
                <!-- logo ajout module -->
                <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
                    <div class="shadow-none">        
                        <a id="module" href="new_module.php?id_operateur=<?=$_SESSION["id_operateur"];?>&id_projet=<?=$_GET["id_projet"];?>">
                            <img src="img/ajouter_module.jpg" alt="ajouter_module" class="img_nav col-lg-12 col-md-12">
                            <div class="parag py-1">
                                <h6 class="text-center">Ajouter un module</h6>
                            </div>
                        </a>
                    </div>
                </div> <!--end_col -->
            </div><!--end_row -->

            <div class="row g-3 mb-5 ">

                <?php
                    if (!empty($contenu_liste_module))
                    {
                        foreach($contenu_liste_module as $element_liste_module):
                            //var_dump($element_liste_module -> id_module);
                ?> 
                            <div class="col-lg-2 col-md-4 offset-lg-1 offset-md-1">
                                <div class="card shadow-lg contenu h-100">
                                    <a id="module" href="liste_fichier.php?id_operateur=<?=$_SESSION["id_operateur"];?>&id_projet=<?=$_SESSION["id_projet"];?>&id_module=<?=$element_liste_module -> id_module;?>">
                                        <img  src="img/module.jpeg" alt="module" class="img_nav col-lg-12 col-md-12" >
                                        <div class="card-body">
                                            <div class="parag py-3">
                                                <h6 class="text-center"><?=$element_liste_module->nom_module;?></h6>
                                            </div>
                                        </div><!-- card-body -->
                                    </a>
                                </div><!-- card -->
                            </div><!-- col -->
                <?php
                        endforeach ; 
                ?>
                <?php
                    }
                    else
                    {
                ?>

                <div class="col-lg-6 col-md-8 offset-lg-3 offset-md-2">
                    <h6 class="text-center bg-success">Vous n'avez pas de module</h6>
                </div>
                <?php
                    }
                ?>
            </div><!-- row -->
        </div><!--container--> 
        
    </div><!--***************album************************-->












<?php
   require("partial/footer.php");  
?>