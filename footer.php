<!DOCTYPE html>
<html>
<head>
    <style>
        .star {
            font-size: 30px;
            color: gray;
            cursor: pointer;
        }

        .star.clicked {
            color: yellow;
        }
        body {
           
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .site-footer {
           
            padding: 20px;
            text-align: center;
            height: 100px;
        }
        main {
            flex: 1;
        }
        footer {
            background-color: beige;
            padding: 20px;
            text-align: center;
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
        }
        .contact{
            background-color:beige ;
        }
        .notification{
            background-color:beige;
        }
    </style>
</head>
<body>
<script>
  window.addEventListener('DOMContentLoaded', function() {
    var footer = document.querySelector('footer.site-footer');
    var body = document.querySelector('body');

    function adjustFooterPosition() {
      var bodyHeight = body.offsetHeight;
      var windowHeight = window.innerHeight;
      var footerHeight = footer.offsetHeight;

      if (bodyHeight < windowHeight) {
        footer.style.position = 'fixed';
        footer.style.bottom = '0';
      } else {
        footer.style.position = 'relative';
      }
    }

    window.addEventListener('resize', adjustFooterPosition);
    document.addEventListener('scroll', adjustFooterPosition);
    adjustFooterPosition();
  });
</script>
<script>
    // Variable pour stocker la note de chaque utilisateur
    var userNote = 0;

    // Fonction pour mettre à jour la note lorsqu'une étoile est cliquée
    function updateNoteStars(starsCount) {
        userNote = starsCount;
        updateStarColors(starsCount);

        // Envoi de la requête AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_stars.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log(xhr.responseText); // Affiche la réponse du serveur (pour le débogage)
            }
        };
        xhr.send('starsCount=' + starsCount);
    }

    // Fonction pour mettre à jour la couleur des étoiles
    function updateStarColors(starsCount) {
        var stars = document.querySelectorAll('.star');
        for (var i = 0; i < stars.length; i++) {
            if (i < starsCount) {
                stars[i].classList.add('clicked');
            } else {
                stars[i].classList.remove('clicked');
            }
        }
    }
</script>
<header>
    <!-- Code du header -->
</header>

<main>
    <!-- Code du contenu principal -->
</main>

<footer class="site-footer">
    <div class="contact">
        <h3>Contact et messagerie</h3>
        <p>Envoyez un mail au responsable de l’entreprise :</p>
        <a href="mailto:fatimazahra.marzaqui@gmail.com">fatimazahra.marzaqui@gmail.com</a>
        <p><h1>Coordonnées de l’entreprise :</h1></p>
        <p>Adresse postale : 75240 Paris, France</p>
        <p>Téléphone : +33131886590</p>
    </div>
    <div class="notification">
    <h3>Notification de l’entreprise</h3>
    <p>Note de satisfaction du site :</p>
    <!-- Étoiles pour recueillir la note -->
    <span class="star" onclick="updateNoteStars(1)">★</span>
    <span class="star" onclick="updateNoteStars(2)">★</span>
    <span class="star" onclick="updateNoteStars(3)">★</span>
    <span class="star" onclick="updateNoteStars(4)">★</span>
    <span class="star" onclick="updateNoteStars(5)">★</span>
    <br>
    <form id="starsForm" action="update_stars.php" method="post">
        <input type="hidden" name="starsCount" value="0" />
        <button type="button" onclick="submitStarsForm()">Envoyer la note</button>
    </form>
</div>

</footer>

<script>
    function submitStarsForm() {
    var starsCount = userNote;
    var form = document.getElementById('starsForm');
    var starsCountInput = form.querySelector('input[name="starsCount"]');
    starsCountInput.value = starsCount;
    form.submit();
}

    // Mettre à jour la couleur des étoiles au chargement de la page
    window.addEventListener('DOMContentLoaded', function() {
        updateStarColors(userNote);
    });
</script>
</body>
</html>