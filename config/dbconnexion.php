<?php 
    
    function connexion($host , $dbname , $user , $mdp)
    {

        try 
        {
            $connbd = new PDO ("mysql:host=".$host. ";dbname=".$dbname,$user,$mdp);
            $connbd -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);// active le déclenchement d’exceptions
            $connbd -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
            $connbd -> setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND,'SET NAMES utf8');
            
        }
        catch(PDOException $pdo)
        {
            echo $pdo -> getCode();
            die("Error!: " .$pdo -> getMessage()."<br/>");
            
        }
        return $connbd ;
    }

    
    
?>