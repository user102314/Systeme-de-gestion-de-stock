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
    $nomproduit = $_POST['nomproduit'];
    $prix = $_POST['prix'];
    $type = $_POST['type'];

    $sql = "INSERT INTO produit (item, prix, type) VALUES ('$nomproduit', '$prix', '$type')";
    if ($conn->query($sql) === TRUE) {
        echo "Produit ajouté avec succès";
    } else {
        echo "Erreur : " . $conn->error;
    }
}

$conn->close();
?>
