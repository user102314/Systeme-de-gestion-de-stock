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

    if (!isset($data['productName']) || !isset($data['stockValue']) || empty($data['productName']) || !is_numeric($data['stockValue'])) {
        echo json_encode([
            'success' => false,
            'error' => 'Invalid input data'
        ]);
        exit;
    }

    $productName = $conn->real_escape_string($data['productName']);
    $stockValue = $conn->real_escape_string($data['stockValue']);
    
    // Convert 'Gazouz' to 'Coca' if needed
    if ($productName == 'Gazouz') {
        $productName = 'Coca';
    }
    $specialProducts = ['Express', 'Capucin', 'Direct', 'Cafe Creme', 'Cappuccino', 'Americaine'];
    if (in_array($productName, $specialProducts)) {
        $productName = 'Bonn';
    }

    // Update stock in the stock table
    
    if ($productName = 'Bonn') {
        $sqlUpdateStock = "UPDATE bonn SET stockdeadmine = ? WHERE ididrecetes = (SELECT MAX(ididrecetes) FROM bonn)";
        $stmtUpdateStock = $conn->prepare($sqlUpdateStock);
        $stmtUpdateStock->bind_param("i", $stockValue);
        
        if (!$stmtUpdateStock->execute()) {
            echo json_encode([
                'success' => false,
                'error' => 'Failed to update stock in bonn: ' . $stmtUpdateStock->error
            ]);
            exit;
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
    }else{
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
    }

    // Successful response
    echo json_encode(['success' => true]);

    // Close the prepared statement and connection
    $stmtUpdateStock->close();
    $conn->close();
}
?>
