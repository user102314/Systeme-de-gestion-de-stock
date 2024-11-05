<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "cafe";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// Ensure the 'id' parameter is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(['success' => false, 'error' => 'Recipe ID is missing.']);
    exit;
}

$recipeId = $conn->real_escape_string($_GET['id']);

// Query to fetch the details of the recipe
$sql = "SELECT nomproduit, quantity, prix_totale_de_produit AS prix_unitaire,prix_totale_de_produit AS prix_total 
        FROM recete 
        WHERE ididrecetes = '$recipeId'";
$result = $conn->query($sql);

$response = ['success' => true, 'details' => []];

if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $response['details'][] = $row;
        }
    } else {
        $response['success'] = false;
        $response['error'] = "No details found for recipe ID $recipeId.";
    }
} else {
    $response['success'] = false;
    $response['error'] = 'Database query error: ' . $conn->error;
}

echo json_encode($response);

$conn->close();
?>
