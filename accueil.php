<?php
require_once('functions.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$bdd = connect();

$sql = "SELECT * FROM oeuvre WHERE categories_id = :categories_id";

$sth = $bdd->prepare($sql);

$sth->execute([
    'categories_id' => $_SESSION['user']['id']
]);

$persos = $sth->fetchAll();

?>

<?php require_once('_nav.php'); ?>
<?php require_once('barre.php'); ?>





<!-- Fermez les balises HTML manquantes -->
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    



<video autoplay muted loop class="video">
  <source src="img/videomusee.mp4" type="video/mp4">
</video>
<div style="background: rgba(255,255,255, 0.5); text-align: center; font-size: 24px; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);  border-radius: 30px;
;"><h3>Bienvenue au Musée des Merveilles Artistiques</h3><h5>Le Musée des Merveilles Artistiques est un lieu emblématique dédié à la présentation et à la célébration de chefs-d'œuvre artistiques provenant de différentes époques et cultures. Situé au cœur de la ville, ce musée offre une expérience captivante pour les amateurs d'art du monde entier.</h5><a class="btn btn-red" href="voirplus.php">Voir plus</a>


<style>
.btn-red {
    background: rgb(175, 96, 26);
    color: rgb(253, 254, 254);
    margin-top: -40px;
    margin-left: 10px;
}

.btn-red:hover {
    background-color: rgb(240, 178, 122);
}

</style>

</body>

</html>
<style>
    body {
        margin: 0;
        padding: 0;
    }

    .video {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: -1;
    }
</style>



    