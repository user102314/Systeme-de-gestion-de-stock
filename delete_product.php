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

// Récupérer l'ID du produit à supprimer
$id = $_POST['id'];

// Supprimer le produit de la base de données
$sql = "DELETE FROM stock WHERE idprod='$id'";
if ($conn->query($sql) === TRUE) {
    echo "Produit supprimé avec succès";
} else {
    echo "Erreur lors de la suppression : " . $conn->error;
}

$conn->close();
?>
