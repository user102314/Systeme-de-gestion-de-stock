<?php
$servername = "localhost"; 
$username = "root";
$password = "";
$dbname = "cafe"; 
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Échec de connexion : " . $conn->connect_error);
}
$idproduit = $_POST['idproduit'];
$nomproduit = $_POST['nomproduit'];
$quantite = $_POST['quantite'];
$sql = "UPDATE stock SET nomprod='$nomproduit', quantityprod='$quantite' WHERE idprod='$idproduit'";
if ($conn->query($sql) === TRUE) {
    echo "Produit mis à jour avec succès";
} else {
    echo "Erreur lors de la mise à jour : " . $conn->error;
}

$conn->close();
?>
