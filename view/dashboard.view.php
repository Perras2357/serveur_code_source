<?php
   require("partial/head.php"); 
?>

    <div class="container">

        <!-- logo de l'operateur et son nom -->
        <div class="row align-items-center ">
            <h1 class="text-center mb-3">DASHBOARD</h1>
            <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4 shadow-none">
                <img src="img/admin1.png" alt="admin" class="img_nav col-lg-12 col-md-12">
                <div class="parag py-1">
                    <p class=" offset-md-3"><?= $prenom_operateur.' '.$nom_operateur;?></p>
                </div>
            </div> <!--end_col -->
        </div> <!--end_row -->

        
        <div class="row  g-3 mb-2">
            <!-- logo du nouveau projet -->
                <div class="col-lg-2 col-md-4 offset-lg-1 offset-md-1 h-100 shadow">
                    <a id="projet" href="new_projet.php?id_operateur=<?=$id_operateur;?>">
                        <img  src="img/ajouter_projet.jpeg" alt="ajouter_projet" class="img_nav col-lg-12 col-md-12" >
                        <div class="card-body">
                            <h6 class="text-center">Ajouter un projet</h6>
                        </div><!-- card-body -->
                    </a>
                </div><!-- card -->
            <!-- logo de tous les projets -->
                <div class="col-lg-2 col-md-4 offset-lg-1 offset-md-1 h-100 shadow">
                    <a id="projet" href="liste_projet.php?id_operateur=<?=$id_operateur;?>">
                        <img  src="img/liste_projet.png" alt="liste_projet" class="img_nav col-lg-12 col-md-12" >
                        <div class="card-body">
                            <h6 class="text-center">Projets</h6>
                        </div><!-- card-body -->
                    </a>
                </div><!-- card -->
            <!-- logo du nouvel acteur-->
                <div class="col-lg-2 col-md-4 offset-lg-1 offset-md-1 h-100 shadow">
                    <a id="acteur" href="new_acteur.php?id_operateur=<?=$id_operateur;?>">
                        <img  src="img/ajouter_acteur.jpeg" alt="ajouter_acteur" class="img_nav col-lg-12 col-md-12" >
                        <div class="card-body">
                            <h6 class="text-center">Ajouter un acteur</h6>
                        </div><!-- card-body -->
                    </a>
                </div><!-- card -->

                <!-- logo liste des nouveaux acteurs -->
                <div class="col-lg-2 col-md-4 offset-lg-1 offset-md-1 h-100 shadow">
                    <a id="acteur" href="liste_acteur.php?id_operateur=<?=$id_operateur;?>">
                        <img  src="img/liste_acteur.png" alt="liste_acteur" class="img_nav col-lg-12 col-md-12" >
                        <div class="card-body">
                            <h6 class="text-center">Acteurs</h6>
                        </div><!-- card-body -->
                    </a>
                </div><!-- card -->









        </div>











    </div>


<?php
   require("partial/footer.php");  
?>