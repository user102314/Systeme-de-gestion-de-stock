<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cafe";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Échec de connexion : " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idproduit = $_POST['idproduit'];
    $nomproduit = $_POST['nomproduit'];
    $prix = $_POST['prix'];
    $type = $_POST['type'];

    $sql = "UPDATE produit SET item = '$nomproduit', prix = '$prix', type = '$type' WHERE id_produit = '$idproduit'";
    if ($conn->query($sql) === TRUE) {
        echo "Produit mis à jour avec succès";
    } else {
        echo "Erreur : " . $conn->error;
    }
}

$conn->close();
?>
