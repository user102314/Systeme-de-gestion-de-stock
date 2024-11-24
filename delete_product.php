<?php
$servername = "localhost"; 
$username = "root";
$password = "";
$dbname = "cafe"; 
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Échec de connexion : " . $conn->connect_error);
}
$id = $_POST['id'];
$sql = "DELETE FROM stock WHERE idprod='$id'";
if ($conn->query($sql) === TRUE) {
    echo "Produit supprimé avec succès";
} else {
    echo "Erreur lors de la suppression : " . $conn->error;
}
$conn->close();
?>
