<?php
   require("partial/head.php"); 
?>

    <div class="container">
            
        <div class="row align-items-center ">
      
            <h1 class="text-center">Upload un fichier</h1>
            <div class="col-md-8 offset-md-2 shadow-none p-3 mb-5 bg-light rounded p-5">
                <form method="post" enctype="multipart/form-data">

                        <?php
                           if(!empty($erreur))
                           {
                                foreach ($erreur as $key ) 
                                {
                                    echo '<p class="text-center"><mark>'.$key.'<mark></p><br>';
                                }
                                 
                           }      
                        ?>
                    <!-- logo ajout fichier -->
                    <div class="col-lg-4 col-md-4 offset-lg-4 offset-md-4">
                        <div class="shadow-none">        
                            <img src="img/ajouter_fichier.png" alt="ajouter_fichier" class="img_nav  col-lg-12 col-md-12">
                                <div class="parag py-1">
                                    <input type="hidden" name="MAX_FILE_SIZE" value="100000">
                                    <input type="file" name="fichier"><br>
                                    <input type="submit" name="upload" value="Upload" class="col-lg-4 col-md-8 bg-success mt-1">
                                </div>
                        </div>
                    </div> <!--end_col -->


                </form>
            </div>
        </div>
            
    </div>









<?php
   require("partial/footer.php");  
?>-
