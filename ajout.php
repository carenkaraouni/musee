<!DOCTYPE html>
<html>
<head>
  <title>Interface administrateur</title>
</head>
<body>
  <h1>Espace administrateur</h1>
  
  <!-- Formulaire pour proposer un nouveau produit -->
  <h2>Proposer un nouveau produit</h2>
  <form action="ajout.php" method="post">
    <label for="nom">Nom du produit:</label>
    <input type="text" id="nom" name="nom" required><br>
    <label for="description">Description:</label>
    <textarea id="description" name="description" required></textarea><br>
    <label for="prix">Prix:</label>
    <input type="number" id="prix" name="prix" required><br>
    <label for="categorie">Catégorie:</label>
    <select id="categorie" name="categorie" required>
      <option value="tableaux/peintures">Tableaux/Peintures</option>
      <option value="sculpture">Sculture</option>
      <option value="bijoux ancestraux">Bijoux ancestraux</option>
      <option value="technologie et innovation">Technoligie et innovation</option>
    </select><br>
    <input type="submit" name="ajouter_produit" value="Ajouter">
  </form>
</body>
</html>

<?php
// Connexion à la base de données


$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Ajouter un nouveau produit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ajouter_produit"])) {
    $nom = $_POST["nom"];
    $description = $_POST["description"];
    $prix = $_POST["prix"];
    $categorie = $_POST["categorie"];
    
    // Récupérer l'ID de la catégorie
    $categorie_id = getCategorieId($conn, $categorie);
    
    if ($categorie_id !== null) {
        // Requête d'insertion
        $sql = "INSERT INTO Produits (Nom, Description, Prix, CategorieID) VALUES ('$nom', '$description', '$prix', '$categorie_id')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Le nouveau produit a été ajouté avec succès.";
        } else {
            echo "Erreur lors de l'ajout du produit : " . $conn->error;
        }
    } else {
        echo "La catégorie sélectionnée n'existe pas.";
    }
}

// Fonction pour récupérer l'ID de la catégorie
function getCategorieId($conn, $categorie) {
    $categorie = mysqli_real_escape_string($conn, $categorie);
    
    $sql = "SELECT ID FROM Categories WHERE Nom = '$categorie'";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["ID"];
    }
    
    return null;
}

$conn->close();
?>
