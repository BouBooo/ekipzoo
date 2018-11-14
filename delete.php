<?php 

//Connexion bdd
$conn_string = "host=127.0.0.1 port=5432 dbname=appli_web user=appli_web password=root";
$conn = pg_connect($conn_string);


  function checkInput($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }


  // check et verif de l'id
  if(!empty($_GET['id']))
  {
    $id = checkInput($_GET['id']);
  }



  
  //delete de l'élément

  if(!empty($_POST))
  {
    $id = checkInput($_POST['id']);
    $query3 = "DELETE FROM animals WHERE id = '$id'";
    echo $query3;
    $request = pg_query($conn, $query3);
    
    /*if($query3)
       echo "succes";
    else{
       echo "error".pg_last_error();
    }*/
    header('Location: index.php');
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
 
                  <h1><strong>Supprimer un animal</strong></h1>
                  <br>

                  <!-- Système de vérif de suppression -->
                  
                <form class="form" action="delete.php" role="form" method="post">
                   <input type="hidden" name="id" value="<?php echo $id; ?>">

                   <p class="alert alert-warning">Etes vous sûr de vouloir supprimer? </p>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-warning">Oui</button>
                        <a class="btn btn-default" href="index.php">Non</a>
                   </div>
                </form>
                 
              
              
            </div>
        </div>   
    </body>
</html>

