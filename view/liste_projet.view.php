<?php
   require("partial/head.php"); 
?>

    <div class="album py-5 bg-light">
        <div class="container">
            <h1 class="text-center mb-5">Vos Projets</h1> 
            <div class="row g-3 mb-5 ">
                <?php
                    if (!empty($contenu_liste_projet))
                    {
                        if (gettype($contenu_liste_projet)=='array')//si la requette renvoie un tableau d'élément (Plusieurs projet on été créée)
                        {
                            foreach($contenu_liste_projet as $element_liste_projet):
                                //var_dump($element_liste_projet -> id_projet);
                ?> 
                                <div class="col-lg-2 col-md-4 offset-lg-1 offset-md-1 ">
                                    <div class="card shadow-lg contenu h-100">
                                        <a id="projet" href="liste_module.php?id_operateur=<?=$_SESSION["id_operateur"];?>&id_projet=<?=$element_liste_projet -> id_projet;?>">
                                            <img  src="img/liste_projet.png" alt="projet" class="img_nav col-lg-12 col-md-12" >
                                            <div class="card-body">
                                                <div class="parag py-3">
                                                    <h6 class="text-center"><?=$element_liste_projet->nom_projet;?></h6>
                                                </div>
                                            </div><!-- card-body -->
                                        </a>
                                    </div><!-- card -->
                                </div><!-- col -->
                <?php
                            endforeach ; 
                        }
                        if(gettype($contenu_liste_projet)=='object')//si la quette renvoie un seul élément (objet) alors il y'a juste un projet dans la bd
                        {
                            //var_dump($contenu_liste_projet -> nom_projet);

                ?>
                            <div class="col-lg-2 col-md-4 offset-lg-1 offset-md-1">
                                <div class="card shadow-lg contenu h-100">
                                    <a id="projet" href="module.php?id_operateur=<?=$_SESSION["id_operateur"];?>&id_projet=<?=$contenu_liste_projet -> id_projet;?>">
                                        <img  src="img/projet.png" alt="projet" class="img_nav col-lg-12 col-md-12" >
                                        <div class="card-body">
                                            <div class="parag py-3">
                                                <h6 class="text-center"><?=$contenu_liste_projet->nom_projet;?></h6>
                                            </div>
                                        </div><!-- card-body -->
                                    </a>
                                </div><!-- card -->
                            </div><!-- col -->
                <?php
                        }
                    }
                    else
                    {
                ?>

                <div class="col-lg-6 col-md-8 offset-lg-3 offset-md-2">
                    <h6 class="text-center bg-success">Vous n'avez pas de projet</h6>
                </div>

                 <!-- logo ajout projet -->
                    <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
                        <div class="shadow-none">        
                            <a id="projet" href="new_projet.php?id_operateur=<?=$_SESSION["id_operateur"];?>">
                                <img src="img/ajouter_projet.jpeg" alt="ajouter_projet" class="img_nav  col-lg-12 col-md-12">
                                <div class="parag py-1">
                                    <h6 class="text-center">Ajouter un projet</h6>
                                </div>
                            </a>
                        </div>
                    </div> <!--end_col -->
                <?php
                    }
                ?>
            </div><!-- row -->
        </div><!--container--> 
        
    </div><!--***************album************************-->


<?php
   require("partial/footer.php");  
?>