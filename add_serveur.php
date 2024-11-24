<?php
$servername = "localhost"; 
$username = "root";
$password = "";
$dbname = "cafe"; 
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Échec de connexion : " . $conn->connect_error);
}
$nom = $_POST['nomserveur'];
$tlf = $_POST['numtlf'];
$sql = "INSERT INTO serveur (nom, numtel, motdepasse) VALUES ('$nom', '$tlf','$nom')";
if ($conn->query($sql) === TRUE) {
    echo "Serveur ajouté avec succès";
} else {
    echo "Erreur : " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
