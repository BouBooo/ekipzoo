<?php 

$conn_string = "host=127.0.0.1 port=5432 dbname=appli_web user=appli_web password=root";
$conn = pg_connect($conn_string);


/*if(!isset($_SESSION['id'])){
  header("Location: connexion.php");
}  */

if(!empty($_GET['id']))
  {
    $id = checkInput($_GET['id']);
  }

        

$nameError = $descriptionError = $typeError = $sexeError = $imageError = $name = $description = $type = $sexe = $image = "";    

function checkInput($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

    
  if(!empty($_POST))
  {
    $name =         checkInput($_POST['name']);
    $description =  checkInput($_POST['description']);
    $type =        checkInput($_POST['type']);
    $sexe =        checkInput($_POST['sexe']);
    $image =        checkInput($_FILES['image']['name']);
    $imagePath = 'img/animals/' . basename($image);
    $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);
    $isSuccess = true;

    if(empty($name))
    {
      $nameError = "Ce champs ne peut pas être vide";
      $isSuccess = false;
    }


    if(empty($description))
    {
      $descriptionError = "Ce champs ne peut pas être vide";
      $isSuccess = false;
    }

    if(empty($type))
    {
      $priceError = "Ce champs ne peut pas être vide";
      $isSuccess = false;
    }

    if(empty($sexe))
    {
      $categoryError = "Ce champs ne peut pas être vide";
      $isSuccess = false;
    }

    if(empty($image))
    {
      $isImageUpdated = false;
    }
    else
    {
      $isImageUpdated = true;
      $isUploadSuccess = true;
      if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif")
      {
        $imageError = "Le format d'image n'est pas valide";
        $isUploadSuccess = false;
      }
      if(file_exists($imagePath))
      {
        $imageError = "";
        $isUploadSuccess = true;
      }  
      if($_FILES['image']['size'] > 500000)
      {
        $imageError = "Le fichier ne doit pas dépasser les 500KB";
        $isUploadSuccess = false;

      }
      if($isUploadSuccess)
      {
        if(!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath))
        {
            $imageError = "Une erreur est survenue durant l'upload";
            $isUploadSuccess = false;
        }
      }
    }

    if(($isSuccess && $isImageUpdated && $isUploadSuccess) || ($isSuccess && !$isImageUpdated))
    {
      if($isImageUpdated)
      {
          $query2 = ("UPDATE animals set name = '$name', description = '$description', type = '$type', sexe = '$sexe', image = '$image' WHERE id = '$id' ");
          $result = pg_query($conn, $query2);
      }
      else
      {
          $query2 = ("UPDATE animals set name = '$name', description = '$description', type = '$type', sexe = '$sexe' WHERE id = '$id' ");
          $result = pg_query($conn, $query2);  
      }

      header('Location: index.php');
    }
    else if($isImageUpdated && !$isUploadSuccess)
    {
        $query2 = ("SELECT image FROM animals WHERE id = '$id'");
        $result = pg_query($conn, $query2);  
        /*$image =        $animals['image'];  */  
    }
  }

  else
  {
      $query2 = ("SELECT * FROM animals WHERE id = '$id'");
      $result = pg_query($conn, $query2);  
      /*$name =         $row['name'];
      $description =  $row['description'];
      $type =     $row['type'];
      $image =        $row['image'];*/
  }









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
    </head>
    
    <body style="background-image: url(img/background/back_5.jpg); background-size: 100%;">
        <h1 class="text-logo"><span class="glyphicon glyphicon-wrench"></span> Ekipzoo <span class="glyphicon glyphicon-wrench"></span></h1>
         <div class="container admin">
            <div class="row">


                <div class="col-sm-6">


                
                  <h1><strong>Modifier un animal</strong></h1>
                  <br>
                  <?php
                    while($row = pg_fetch_array($result)){
  
                  ?>
                <form class="form" action="<?php echo 'update.php?id=' . $id; ?>" role="form" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Nom:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?= $row['name'];?>">
                        <span class="help-inline"><?php echo $nameError;?></span>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="<?= $row['description'];?>">
                        <span class="help-inline"><?php echo $descriptionError;?></span>
                    </div>
                    <div class="form-group">
                        <label for="type">Type: </label>
                        <input type="text" class="form-control" id="type" name="type" placeholder="Type" value="<?= $row['type'];?>">
                        <span class="help-inline"><?php echo $typeError;?></span>
                    </div>
                    <div class="form-group">
                        <label for="sexe">Sexe (f ou m):</label>
                        <select name="sexe" id="sexe">
                          <option <?= ($row['sexe'] == "Male") ? 'selected' : '' ?> value="Male">Mâle</option>
                          <option <?= ($row['sexe'] == "Femelle") ? 'selected' : '' ?> value="Femelle">Femelle</option>
                        </select>
                        <p>(Default sexe <strong><?= $row['sexe'];?></strong>)</p>
                        <span class="help-inline"><?php echo $sexeError;?></span>
                    </div>
                     <div class="form-group">
                        <label for="image">Sélectionner une image:</label>
                        <input type="file" id="image" name="image"> 
                        <span class="help-inline"><?php echo $imageError;?></span>
                    </div>
                    <div class="span6">
                        <div class="thumbnail">
                            <img src="<?= 'img/animals/'.$row['image'];?>" alt="...">
                        </div>
                      </div>
              
                    <br>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Modifier</button>
                        <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                   </div>

                    <?php

                          }

                    ?>

                </form>

              </div>                             
            </div>
        </div>   
    </body>
</html>