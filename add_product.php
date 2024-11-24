<?php
$servername = "localhost"; 
$username = "root";
$password = "";
$dbname = "cafe"; 

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Échec de connexion : " . $conn->connect_error);
}

// Récupération des données du formulaire en sécurisant les valeurs
$nomproduit = $_POST['nomproduit'];
$quantite = filter_var($_POST['quantite'], FILTER_VALIDATE_INT);
if ($quantite === false) {
    die("Quantité invalide");
}

// Préparation de la requête pour éviter les injections SQL
$sql = "INSERT INTO stock (nomprod, quantityprod) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Erreur de préparation de la requête : " . $conn->error);
}
$stmt->bind_param("si", $nomproduit, $quantite);

if ($stmt->execute()) {
    echo "Produit ajouté avec succès";
} else {
    echo "Erreur : " . $stmt->error;
}

// Fermeture de la connexion
$stmt->close();
$conn->close();
?>
