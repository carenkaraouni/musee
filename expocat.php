<?php
require_once('functions.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

// Vérifier si l'ID de catégorie est passé en paramètre
if (!isset($_GET['id'])) {
    header('Location: expo.php');
    exit();
}

// Établir la connexion à la base de données
$bdd = connect();


// Récupérer l'ID de catégorie depuis le paramètre GET
$categoryID = $_GET['id'];

// Requête pour récupérer les œuvres de la catégorie spécifiée
$sql = "SELECT * FROM oeuvre WHERE categories_id = :categoryID";
$sth = $bdd->prepare($sql);
$sth->bindParam(':categoryID', $categoryID, PDO::PARAM_INT);
$sth->execute();

// Récupérer toutes les œuvres de la catégorie
$oeuvres = $sth->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* ... votre code CSS personnalisé ... */
    </style>
    <title>Oeuvres de la catégorie</title>
    <style>
        /* Ajoutez ici votre CSS personnalisé */
    </style>
</head>
<body>
<?php require_once('_nav.php'); ?>
<?php require_once('barre.php'); ?>
    
    <h1>Oeuvres </h1>
    
    <div class="container">
    <ul class="oeuvres-liste">
        <?php
        foreach ($oeuvres as $oeuvre) {
            // Récupérer le nombre de likes depuis la base de données
            $sql = "SELECT `like` FROM oeuvre WHERE id = :oeuvreID";
            $sth = $bdd->prepare($sql);
            $sth->bindParam(':oeuvreID', $oeuvre['id'], PDO::PARAM_INT);
            $sth->execute();
            $likes = $sth->fetchColumn();
        
            $nomOeuvre = $oeuvre['name'];
            // Vérifier si l'utilisateur actuel a aimé l'œuvre
            $isLiked = ($oeuvre['user_id'] === $_SESSION['user']['id']);
            $likeButtonClass = ($isLiked) ? 'liked' : 'not-liked';
        ?>
        <li class="oeuvre">
            <h2><?php echo $oeuvre['name']; ?></h2>
            <div class="oeuvre-img-container">
                <img src="<?php echo $oeuvre['pic']; ?>" alt="" data-description="<?php echo $oeuvre['description']; ?>" data-prix="<?php echo $oeuvre['prix']; ?>" data-taille="<?php echo $oeuvre['taille']; ?>" data-artiste="<?php echo $oeuvre['artiste']; ?>" data-date="<?php echo $oeuvre['date']; ?>">
            </div>
            <form action="update_like.php" method="post">
    <input type="hidden" name="oeuvreID" value="<?php echo $oeuvre['id']; ?>">
    <button type="submit" name="like" class="like-button <?php echo ($isLiked) ? 'liked' : 'not-liked'; ?>">
        <i class="fas fa-heart"></i>
    </button>
</form>


            <p><?php echo $likes; ?> likes</p>
            <!-- Ajoutez ici d'autres informations sur l'œuvre -->
        </li>
        <?php } ?>
    </ul>
    </div>

    <!-- Boîte modale -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <img id="modal-img" src="" alt="">
            <div class="modal-info">
                <h2 id="modal-title"></h2>
                <h2 id="modal-name"></h2>

                <p id="modal-prix"></p>
                <p id="modal-taille"></p>
                <p id="modal-artiste"></p>
                <p id="modal-date"></p>
                <p id="modal-description"></p>
            </div>
        </div>
    </div>

    <?php require_once('footer.php');?>
</body>

</html>

<script>
    // Sélectionnez tous les éléments d'image
    var images = document.querySelectorAll('.oeuvre-img-container img');

    // Sélectionnez la boîte modale
    var modal = document.getElementById('modal');

    // Sélectionnez les éléments de la boîte modale
    var modalImg = document.getElementById('modal-img');
    var modalTitle = document.getElementById('modal-title');
    var modalDescription = document.getElementById('modal-description');
    var modalPrix = document.getElementById('modal-prix');
    var modalTaille = document.getElementById('modal-taille');
    var modalArtiste = document.getElementById('modal-artiste');
    var modalDate = document.getElementById('modal-date');
    var modalName = document.getElementById('modal-name');
    // Bouclez à travers toutes les images et ajoutez un gestionnaire d'événement de clic
    images.forEach(function(img) {
        img.addEventListener('click', function() {
            // Récupérez les informations de l'image cliquée
            var description = img.getAttribute('data-description');
            var prix = img.getAttribute('data-prix');
            var taille = img.getAttribute('data-taille');
            var artiste = img.getAttribute('data-artiste');
            var date = img.getAttribute('data-date');

            // Mettez à jour les éléments de la boîte modale avec les informations de l'image
            modalImg.src = img.src;
            modalTitle.textContent = img.alt;
            modalDescription.textContent = 'Description: ' + description;
            modalPrix.textContent = 'Prix: ' + prix;
            modalTaille.textContent = 'Taille: ' + taille;
            modalArtiste.textContent = 'Artiste: ' + artiste;
            modalDate.textContent = 'Date: ' + date;

            // Affichez la boîte modale
            modal.style.display = 'block';
        });
    });

    // Sélectionnez l'élément de fermeture de la boîte modale et ajoutez un gestionnaire d'événement de clic
    var closeBtn = document.getElementsByClassName('close')[0];
    closeBtn.addEventListener('click', function() {
        // Masquez la boîte modale
        modal.style.display = 'none';
    });
</script>

<style>
   .like-button {
    background-color: transparent;
    border: none;
    cursor: pointer;
    font-size: 24px;
    transition: color 0.3s;
}

.like-button.liked {
    color: blue;
}

.like-button.not-liked {
    color: red;
}


    /* Ajoutez ici votre CSS personnalisé */

    /* Affichage en grille */
    .container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); /* Colonnes de taille minimale de 300px, s'adaptant à la largeur disponible */
        grid-gap: 20px; /* Espacement entre les éléments */
    }

    /* Style des éléments d'œuvre */
    .oeuvre {
        list-style-type: none;
        background-color: #f5f5f5;
        padding: 20px;
        border-radius: 5px;
    }
    h1 {
            text-align: center;
        }
    /* Style des images d'œuvre */
    .oeuvre-img-container {
        text-align: center;
        margin-bottom: 10px;
    }

    .oeuvre-img-container img {
        width: 100%;
        height: auto;
        border-radius: 5px;
        cursor: pointer;
    }

    /* Style des informations de l'œuvre dans la boîte modale */
    .modal-info {
        text-align: left;
    }
    /* Style de la boîte modale */
.modal {
    display: none; /* Par défaut, la boîte modale est masquée */
    position: fixed; /* Position fixe pour rester au-dessus du contenu */
    z-index: 999; /* Une valeur élevée pour s'assurer que la boîte modale est au-dessus des autres éléments */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto; /* Permet le défilement si le contenu dépasse la taille de la fenêtre */
    background-color: rgba(0, 0, 0, 0.5); /* Fond semi-transparent */
}

/* Style de la boîte modale - contenu */
.modal-content {
    background-color: #fefefe;
    margin: auto; /* Centrez la boîte modale horizontalement et verticalement */
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 600px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    text-align: center;
    position: relative;
}

/* Style du bouton de fermeture */
.close {
    position: absolute;
    top: 10px;
    right: 20px;
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

/* Style de l'image de l'œuvre dans la boîte modale */
#modal-img {
    width: 100%;
    height: auto;
    max-height: 400px;
    object-fit: contain; /* Ajuste l'image à l'intérieur du conteneur sans déformation */
    margin-bottom: 20px;
}

/* Style du titre, de la description et du prix dans la boîte modale */
#modal-title {
    font-size: 24px;
    margin-bottom: 10px;
}

#modal-description,
#modal-prix {
    margin-bottom: 10px;
}

</style>