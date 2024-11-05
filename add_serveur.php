<?php
// Étape 1 : Connexion à la base de données
$servername = "localhost"; 
$username = "root";
$password = "";
$dbname = "cafe"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de connexion : " . $conn->connect_error);
}

// Récupérer les données du produit
$nom = $_POST['nomserveur'];
$tlf = $_POST['numtelf'];

// Insertion du produit dans la base de données
$sql = "INSERT INTO serveur (nom, numtlf , motdepasse) VALUES ('$nom', '$tlf','$nom')";
if ($conn->query($sql) === TRUE) {
    echo "Serveur ajouté avec succès";
} else {
    echo "Erreur : " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
