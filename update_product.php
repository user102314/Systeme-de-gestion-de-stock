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
$idproduit = $_POST['idproduit'];
$nomproduit = $_POST['nomproduit'];
$quantite = $_POST['quantite'];

// Mettre à jour le produit dans la base de données
$sql = "UPDATE stock SET nomprod='$nomproduit', quantityprod='$quantite' WHERE idprod='$idproduit'";
if ($conn->query($sql) === TRUE) {
    echo "Produit mis à jour avec succès";
} else {
    echo "Erreur lors de la mise à jour : " . $conn->error;
}

$conn->close();
?>
