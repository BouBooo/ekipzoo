<?php 

$conn_string = "host=127.0.0.1 port=5432 dbname=appli_web user=appli_web password=root";
$conn = pg_connect($conn_string);


/*if(!isset($_SESSION['id'])){
  header("Location: connexion.php");
}  */


  function checkInput($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }


if(!empty($_GET['id'])) 
    {
        $id = checkInput($_GET['id']);
    }



$query2 = "SELECT id, name, type, description, sexe, image FROM animals WHERE id = '$id'";
$results = pg_query($conn, $query2);

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Ekipzoo</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/background.css">
    </head>
    
    <body style="background-image: url(img/background/back_5.jpg); background-size: 100%;">
        <h1 class="text-logo"><span class="glyphicon glyphicon-wrench"></span> Ekipzoo <span class="glyphicon glyphicon-wrench"></span></h1>
         <div class="container admin">
            <div class="row">
                <div class="col-sm-6">
                    <h1><strong>Voir un animal</strong></h1>
                    <br>
                    <form>
                        <?php
                    while($row = pg_fetch_array($results)){
                        ?>

                        
                      <div class="form-group">
                        <label>Nom : </label><?= $row['name'];?>
                      </div>
                      <div class="form-group">
                        <label>Type : </label><?= $row['type'];?>
                      </div>
                      <div class="form-group">
                        <label>Description : </label><?= $row['description'];?>
                      </div>
                      <div class="form-group">
                        <label>Sexe : </label><?= $row['sexe'];?>
                      </div>
                       <div class="form-group">
                        <label>Image:</label><?= $row['image'];?>
                      </div>
                      <div class="span6">
                        <div class="thumbnail">
                            <img src="<?= 'img/animals/'.$row['image'];?>" alt="...">
                        </div>
                      </div>
                    </form>
                     
                    <br>
                    <div class="form-actions">
                      <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                    </div>
                 
                    <?php

                          }

                    ?>
                </div>                 
            </div>
        </div>   
       
    </body>
</html>