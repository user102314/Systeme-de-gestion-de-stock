<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "cafe";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $productName = $conn->real_escape_string($data['productName']);
    $stockValue = $conn->real_escape_string($data['stockValue']);
    
    if ($productName == 'Gazouz') {
        $productName = 'Coca';
    }

    $sqlUpdateStock = "UPDATE stock SET quantityprod = ? WHERE nomprod = ?";
    $stmtUpdateStock = $conn->prepare($sqlUpdateStock);
    $stmtUpdateStock->bind_param("is", $stockValue, $productName);

    if (!$stmtUpdateStock->execute()) {
        echo json_encode([
            'success' => false,
            'error' => 'Failed to update stock: ' . $stmtUpdateStock->error
        ]);
        exit;
    }

    echo json_encode(['success' => true]);
    $stmtUpdateStock->close();
    $conn->close();
}
?>
