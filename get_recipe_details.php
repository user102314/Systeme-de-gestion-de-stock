<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "cafe";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// Helper function to handle product name transformations
function getTransformedProductName($productName) {
    $productMap = [
        'Express' => 'Bonn',
        'Capucin' => 'Bonn',
        'Cafe Creme' => 'Bonn',
        'Cappuccino'=> 'Bonn',
    'Americaine'=> 'Bonn',
        'Gazouz' => 'Coca',
        'Paket MontiCarlo' => 'Paket MontiCarlo',
        'Mars Legere' => 'Mars Legere',
        'Paket Mirit / Malboro' => 'Paket Mirit / Malboro'
    ];
    return $productMap[$productName] ?? $productName;
}

// Fetch recipe details
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(['success' => false, 'error' => 'Recipe ID is missing.']);
    exit;
}

$recipeId = $conn->real_escape_string($_GET['id']);
$sql = "SELECT nomproduit, quantity, prix_totale_de_produit AS prix_unitaire, prix_totale_de_produit AS prix_total 
        FROM recete WHERE ididrecetes = '$recipeId'";

$result = $conn->query($sql);
$response = ['success' => true, 'details' => []];

if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $productName = getTransformedProductName($row['nomproduit']);

            // Get initial stock
            $sql_initial_stock = "SELECT quantite FROM stockinitial WHERE idrecetes = '$recipeId' AND nomproduitstock = '$productName'";
            $result_initial_stock = $conn->query($sql_initial_stock);
            $initial_stock = $result_initial_stock->num_rows > 0 ? $result_initial_stock->fetch_assoc()['quantite'] : 0;

            // Get final stock
            $sql_final_stock = "SELECT quantite FROM stockfinale WHERE idrecetes = '$recipeId' AND nomproduitstock = '$productName'";
            $result_final_stock = $conn->query($sql_final_stock);
            $final_stock = $result_final_stock->num_rows > 0 ? $result_final_stock->fetch_assoc()['quantite'] : 0;

            // Check if product is 'bonn'
            if ($productName == 'bonn') {
                $sql_final_stock = "SELECT stockdeadmine FROM bonn WHERE ididrecetes = '$recipeId'";
                $result_final_stock = $conn->query($sql_final_stock);
                $final_stock = $result_final_stock->num_rows > 0 ? $result_final_stock->fetch_assoc()['stockdeadmine'] : 0;
                $row['stock_final'] = $final_stock;
            } else {
                $row['stock_final'] = $final_stock;
            }

            $row['stock_initial'] = $initial_stock;
            $row['manque'] = 0; // Placeholder for missing stock or adjustments

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

// Handle POST request for stock update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $recipeId = $conn->real_escape_string($data['recipeId']);
    $productName = getTransformedProductName($data['productName']);
    $stockValue = $conn->real_escape_string($data['stockValue']);

    $sql = "UPDATE stockfinale SET quantite = ? WHERE idrecetes = ? AND nomproduitstock = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $stockValue, $recipeId, $productName);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Erreur lors de la mise à jour du stock.']);
    }

    $stmt->close();
    $conn->close();
    exit;
}

$conn->close();
?>
