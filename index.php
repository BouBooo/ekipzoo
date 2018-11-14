<?php

//Connexion bdd

$conn_string = "host=127.0.0.1 port=5432 dbname=appli_web user=appli_web password=root";
$conn = pg_connect($conn_string);

//Requête d'affichage des éléments de la bdd

$query2 = "SELECT id, name, type, description, sexe FROM animals  ORDER BY id DESC";
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
        <h1 class="text-logo"><span class="glyphicon glyphicon-wrench
            "></span> Ekipzoo <span class="glyphicon glyphicon-wrench
            "></span></h1>
        <div class="container admin">
            <div class="row">
                <h1><strong> Liste des animaux   </strong><a href="insert.php" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-plus"></span> Ajouter</a></h1>
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Nom</th>
                      <th>Type</th>
                      <th>Description</th>
                      <th>Sexe</th>
                      <!---<th>Catégorie</th>-->
                      <th>Actions</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                    // Affichage des éléments dans un tableau
                    while($row = pg_fetch_array($results)){
                          ?>
                    <tr><td><?= $row['name']?></td><td><?= $row['type']?></td><td><?= $row['description']?></td><td><?= $row['sexe']?></td>
                      <td width="400">
                        <a class="btn btn-default" href="view.php?id=<?= $row['id'] ?>"><span class="glyphicon glyphicon-eye-open"></span> Voir</a> 
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-primary" href="update.php?id=<?= $row['id'] ?>"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-danger" href="delete.php?id=<?= $row['id'] ?>"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>
                      </td>
                    </tr>

                          <?php

                          }
                      ?>
                  </tbody>

                  </table>


    </body>

</html>
    