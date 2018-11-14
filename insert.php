<?php

// Connexion bdd

$conn_string = "host=127.0.0.1 port=5432 dbname=appli_web user=appli_web password=root";
$conn = pg_connect($conn_string);


//Function de vérification basique

  function checkInput($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }


// Init variables
  $nameError = $imageError = $descriptionError = $typeError = $sexeError = $name = $image = $description = $type = $sexe = "";



  if(!empty($_POST))
  {
    $name =         checkInput($_POST['name']);
    $type =         checkInput($_POST['type']);
    $description =  checkInput($_POST['description']);
    $sexe =  checkInput($_POST['sexe']);
    $image =        checkInput($_FILES['image']['name']);
    $imagePath = 'img/animals/' . basename($image);
    $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);



    // Vérif si les champs sont remplis

    if(empty($type))
    {
      $typeError = "Ce champs ne peut pas être vide";
      $isSuccess = false;
    }

    if(empty($name))
    {
      $nameError = "Ce champs ne peut pas être vide";
      $isSuccess = false;
    }

    if(empty($sexe))
    {
      $sexeError = "Ce champs ne peut pas être vide";
      $isSuccess = false;
    }


    if(empty($description))
    {
      $descriptionError = "Ce champs ne peut pas être vide";
      $isSuccess = false;
    }

    if(empty($image))
    {
      $imageError = "Ce champs ne peut pas être vide";
      $isSuccess = false;
    }
   

   if(!empty($name) && !empty($description) && !empty($sexe) && !empty($type) && !(empty($image)))
   {
      $isSuccess = true;
   }


    //Si c'est bon, on insert l'élément dans la bdd, et on redirige vers l'index.php
    if($isSuccess)
    {
      $query1 = "INSERT INTO animals (name, type, description, sexe, image) VALUES ('$name', '$type', '$description', '$sexe', '$image')";
      $result = pg_query($conn, $query1);
      /*if($query1)
         echo "yes";
      else{
         echo "pas ouf".pg_last_error();
      }*/
      header('Location: index.php');
    } 




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
        <link rel="stylesheet" href="css/background.css">
    </head>
    
    <body style="background-image: url(img/background/back_5.jpg); background-size: 100%;">
        <h1 class="text-logo"><span class="glyphicon glyphicon-wrench"></span> Ekipzoo <span class="glyphicon glyphicon-wrench"></span></h1>
         <div class="container admin">
            <div class="row">
 
                  <h1><strong>Ajouter un animal</strong></h1>
                  <br>
                <form class="form" action="insert.php" role="form" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Nom:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?php echo $name;?>">
                        <span class="help-inline"><?php echo $nameError;?></span>
                    </div>

                     <div class="form-group">
                        <label for="type">Type:</label>
                        <input type="text" class="form-control" id="type" name="type" placeholder="Type" value="<?php echo $type;?>">
                        <span class="help-inline"><?php echo $typeError;?></span>
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="<?php echo $description;?>">
                        <span class="help-inline"><?php echo $descriptionError;?></span>
                    </div>

                    <div class="form-group">
                        <label for="sexe">Sexe (f ou m):</label>
                        <select name="sexe" id="sexe" value="<?= $sexe; ?>">
                          <option value="Male">Mâle</option>
                          <option value="Femelle">Femelle</option>
                        </select>
                        <span class="help-inline"><?php echo $sexeError;?></span>
                    </div>

                    <div class="form-group">
                        <label for="image">Sélectionner une image:</label>
                        <input type="file" id="image" name="image"> 
                        <span class="help-inline"><?php echo $imageError;?></span>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Ajouter</button>
                        <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                   </div>

                                    
                </form>
                 
              
              
            </div>
        </div>   
    </body>
</html>
