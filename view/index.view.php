<?php
   require("partial/head.php"); 
?>


<div class="container">
        
        <div class="row align-items-center ">
  
          <h1 class="text-center">Connectez-vous</h1>
          <div class="col-lg-8 col-md-8 offset-lg-2 offset-md-2 shadow-none p-3 mb-5 bg-light rounded p-5">
            <form   method="post">
              <?php
                if(!empty($erreur1))
                {
                  echo '<p class="text-center"><mark>'.$erreur1.'<mark></p>';   
                }      
              ?>
              <!-- login -->
                <div class="row mb-3">
                  <label for="login" class="col-md-3 col-form-label">Login : </label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" id="login" name="login" required >
                    
                    <?php
                      if(!empty($erreur["login"]))
                      {
                        echo '<p class="text-center "><mark>'.$erreur["login"].'<mark></p>';   
                      }      
                    ?>
                  </div>
                </div>
                 

                <!-- password-->
                <div class="row mb-3">
                  <label for="login" class="col-md-3 col-form-label">Password : </label>
                  <div class="col-md-9">
                    <input type="password" class="form-control" id="mdp" name="mdp" required >
                    <?php
                      if(!empty($erreur["mdp"]))
                      {
                        echo '<p class="text-center"><mark>'.$erreur["mdp"].'<mark></p>';   
                      }      
                    ?> 
                  
                  </div>
                </div>
               
  
                  <div class="mb-3 py-2">
                    
                      <button type="submit" class="btn btn-primary  col-md-2 offset-md-5 " name="connexion">connexion</button>
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


