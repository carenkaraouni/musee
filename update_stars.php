<?php
require_once('functions.php');

if (isset($_POST['starsCount'])) {
    $starsCount = intval($_POST['starsCount']); // Convertit la valeur en entier

    // Connectez-vous à la base de données
    $bdd = connect();

    // Mettez à jour le nombre d'étoiles pour l'utilisateur actuel
    $userId = $_SESSION['user']['id'];/* Obtenir l'ID de l'utilisateur actuel (vous devez l'obtenir à partir de la session ou de toute autre méthode d'authentification) */;
    $sql = "UPDATE users SET stars_count = :starsCount WHERE id = :userId";
    $sth = $bdd->prepare($sql);
    $sth->execute([
        'starsCount' => $starsCount,
        'userId' => $userId
    ]);

    // Réponse du serveur (vous pouvez renvoyer des données supplémentaires si nécessaire)
    echo "Nombre d'étoiles mis à jour avec succès !";
}
?>
<?php require_once('_nav.php'); ?>
<?php require_once('barre.php'); ?>


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
;"><h3>merci </h3>
<a href="accueil.php" class="btn btn-blue btn-link">quitter</a>

<style>

 .btn-link {
        position: relative;
    display: inline-block;
    padding: 10px 20px;
    color: #b79726;
    font-size: 16px;
    text-decoration: none;
    text-transform: uppercase;
    overflow: hidden;
    transition: 0.5s;
    margin-top: 40px;
    letter-spacing: 4px;
    background: transparent;
    border: 1px solid #b79726;
    cursor: pointer;
}

.btn-link:hover {
    background: #f49803;
    color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 5px #f4c803, 0 0 25px #bd9d0b, 0 0 50px #f4e403, 0 0 100px #d5cf1e;
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



    