<?php
   require("partial/head.php"); 
?>

      <div class="container">
            
         <div class="row align-items-center ">
      
            <h1 class="text-center">Créez un nouveau module</h1>
               <div class="col-md-8 offset-md-2 shadow-none p-3 mb-5 bg-light rounded p-5">
                  <form   method="post">
                     <?php
                        if(!empty($erreur1))
                        {
                           echo '<p class="text-center"><mark>'.$erreur1.'<mark></p>';   
                        }
                        if(isset($success))
                        {
                           echo '<p class="text-center"><mark>'.$success.'<mark></p>';
                           header('Location:dashboard.php?id_operateur='.$_SESSION["id_operateur"].'');   
                        }      
                     ?>

                  <!-- module -->
                     <div class="row mb-3">
                        <label for="module" class="col-md-4 col-form-label ">Nom du module : </label>
                        <div class="col-md-8">
                        <input type="text" class="form-control" id="module" name="module" required >
                        <?php
                           if(!empty($erreur["module"]))
                           {
                              echo '<p class="text-center "><mark>'.$erreur["module"].'<mark></p>';   
                           }      
                        ?>
                        </div>
                     </div>
                     

                     <!-- password-->
                     <div class="row mb-3">
                        <label for="module" class="col-md-4 col-form-label">Entrez votre Password : </label>
                        <div class="col-md-8">
                        <input type="password" class="form-control" id="mdp" name="mdp" required >
                        <?php
                           if(!empty($erreur["mdp"]))
                           {
                              echo '<p class="text-center "><mark>'.$erreur["mdp"].'<mark></p>';   
                           }      
                        ?>
                        </div>
                     </div>
                     
      
                        <div class="mb-3 py-2">
                        
                           <button type="submit" class="btn btn-primary  col-md-2 offset-md-7 " name="creer">Créer</button>
                        </div>

                  </form>
                  <div class="mb-3">
                  </div>
                  
               </div>
            </div>
            
      </div>









<?php
   require("partial/footer.php");  
?>