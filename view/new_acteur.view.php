<?php
   require("partial/head.php"); 
?>

<div class="container">
        
        <div class="row align-items-center ">
  
          <h1 class="text-center">Créez un nouvel acteur</h1>
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
                      header('Location:dashboard.php?id_admin='.$_SESSION["id_admin"].'');   
                    }      
                ?>

              <!-- nom_acteur -->
                <div class="row mb-3">
                  <label for="nom_acteur" class="col-md-3 col-form-label offset-md-1">Nom acteur : </label>
                  <div class="col-md-8">
                    <input type="text" class="form-control" id="nom_acteur" name="nom_acteur" required >
                    <?php
                      if(!empty($erreur["nom_acteur"]))
                      {
                        echo '<p class="text-center "><mark>'.$erreur["nom_acteur"].'<mark></p>';   
                      }      
                    ?>
                  </div>
                </div>

                <!-- prenom_acteur -->
                <div class="row mb-3">
                  <label for="nom_acteur" class="col-md-3 col-form-label offset-md-1">Prenom acteur : </label>
                  <div class="col-md-8">
                    <input type="text" class="form-control" id="prenom_acteur" name="prenom_acteur" required >
                    <?php
                      if(!empty($erreur["prenom_acteur"]))
                      {
                        echo '<p class="text-center "><mark>'.$erreur["prenom_acteur"].'<mark></p>';   
                      }      
                    ?>
                  </div>
                </div>

                <!-- pseudo -->
                <div class="row mb-3">
                  <label for="nom_acteur" class="col-md-3 col-form-label offset-md-1">Pseudo : </label>
                  <div class="col-md-8">
                    <input type="text" class="form-control" id="pseudo" name="pseudo" required >
                    <?php
                      if(!empty($erreur["pseudo"]))
                      {
                        echo '<p class="text-center "><mark>'.$erreur["pseudo"].'<mark></p>';   
                      }      
                    ?>
                  </div>
                </div>
                 

                <!-- password-->
                <div class="row mb-3">
                  <label for="nom_acteur" class="col-md-4 col-form-label">Password acteur : </label>
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