<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "cafe";

// Establish connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// Decode incoming JSON data
$data = json_decode(file_get_contents('php://input'), true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'error' => 'Invalid JSON']);
    exit;
}

// Extract data from request
$startTime = $conn->real_escape_string($data['startTime'] ?? '');
$endTime = $conn->real_escape_string($data['endTime'] ?? '');
$total = $conn->real_escape_string($data['total'] ?? 0);
$serverName = $conn->real_escape_string($data['serverName'] ?? ''); 
$details = json_encode($data['details'] ?? []); // JSON-encoded details

if (isset($data['recipeId'])) {
    // Updating an existing recipe
    $recipeId = $conn->real_escape_string($data['recipeId']);
    $sql = "UPDATE recetes SET datesortie = '$endTime', prixtotale = '$total' WHERE idrecetes = '$recipeId'";

    if (!$conn->query($sql)) {
        // Return detailed error information
        echo json_encode([
            'success' => false,
            'error' => 'Failed to update recetes: ' . $conn->error,
            'sql' => $sql
        ]);
        exit;
    }

    // Insert each product in the order details into recete table
    foreach ($data['details'] as $productName => $quantity) {
        if ($quantity > 0) {
            // Fetch product price
            $priceSql = "SELECT prix FROM produit WHERE item = '$productName'";
            $priceResult = $conn->query($priceSql);
            if ($priceResult && $priceResult->num_rows > 0) {
                $price = $priceResult->fetch_assoc()['prix'];
            } else {
                echo json_encode(['success' => false, 'error' => 'Product not found: ' . $productName]);
                exit;
            }

            // Calculate total price for the quantity of this product
            $priceTotal = $price * $quantity;

            // Insert the product into recete table
            $insertProductSql = "INSERT INTO recete (nomproduit, quantity, prix_totale_de_produit, ididrecetes) 
                                 VALUES ('$productName', '$quantity', '$priceTotal', '$recipeId')";
            if (!$conn->query($insertProductSql)) {
                echo json_encode([
                    'success' => false,
                    'error' => 'Failed to insert product into recete: ' . $conn->error,
                    'sql' => $insertProductSql
                ]);
                exit;
            }
        }
    }
    echo json_encode(['success' => true]);
} else {
    // Creating a new recipe
    if (empty($serverName)) {
        echo json_encode(['success' => false, 'error' => 'Server name is missing.']);
        exit;
    }

    $sql = "INSERT INTO recetes (dateentree, nomserveur) VALUES (NOW(), '$serverName')";

    if ($conn->query($sql) === TRUE) {
        $recipeId = $conn->insert_id;
        echo json_encode(['success' => true, 'recipeId' => $recipeId]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Failed to create service: ' . $conn->error,
            'sql' => $sql
        ]);
    }
}

$conn->close();
?>
