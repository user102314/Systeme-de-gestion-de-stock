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
    $id = $_POST['id'];

    $sql = "DELETE FROM produit WHERE id_produit = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Produit supprimé avec succès";
    } else {
        echo "Erreur : " . $conn->error;
    }
}

$conn->close();
?>
