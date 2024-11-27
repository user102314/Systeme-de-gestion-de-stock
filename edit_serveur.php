<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cafe";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nom = $_POST['nom'];
    $num = $_POST['num'];
    $motdepasse = $_POST['password'];

    $sql = "UPDATE serveur SET nom = ?, numtel = ?, motdepasse = ? WHERE id_serveur = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nom, $num, $motdepasse, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
    $stmt->close();
}

$conn->close();
?>
