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
$nomproduit = $_POST['nomproduit'];
$quantite = $_POST['quantite'];

// Insertion du produit dans la base de données
$sql = "INSERT INTO stock (nomprod, quantityprod) VALUES ('$nomproduit', '$quantite')";
if ($conn->query($sql) === TRUE) {
    echo "Produit ajouté avec succès";
} else {
    echo "Erreur : " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
