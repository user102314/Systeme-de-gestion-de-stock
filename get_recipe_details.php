<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "cafe";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(['success' => false, 'error' => 'Recipe ID is missing.']);
    exit;
}

$recipeId = $conn->real_escape_string($_GET['id']);
$sql = "SELECT nomproduit, quantity, prix_totale_de_produit AS prix_unitaire, prix_totale_de_produit AS prix_total 
        FROM recete 
        WHERE ididrecetes = '$recipeId'";

$result = $conn->query($sql);

$response = ['success' => true, 'details' => []];

if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $productName = $row['nomproduit'];

            if (in_array($productName, ['Express', 'Capusin', 'Direct'])) {
                $productName = 'bonn';  
            }
            if ($productName == 'Gazouz') {
                $productName = 'Coca';  
            }
            

            $sql_initial_stock = "SELECT quantite FROM stockinitial WHERE idrecetes = '$recipeId' AND nomproduitstock = '$productName'";
            $result_initial_stock = $conn->query($sql_initial_stock);
            $initial_stock = $result_initial_stock->num_rows > 0 ? $result_initial_stock->fetch_assoc()['quantite'] : 0;

            $sql_final_stock = "SELECT quantite FROM stockfinale WHERE idrecetes = '$recipeId' AND nomproduitstock = '$productName'";
            $result_final_stock = $conn->query($sql_final_stock);
            $final_stock = $result_final_stock->num_rows > 0 ? $result_final_stock->fetch_assoc()['quantite'] : 0;
            
            $row['stock_initial'] = $initial_stock;
            if ($productName == 'bonn') {  
                $row['stock_final'] = 0; 
            } else {
                $row['stock_final'] = $final_stock;  
            }
            $row['manque'] = 0;  
            $row['stock'] = 0;   

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


// Traitement de la mise à jour du stock
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $recipeId = $conn->real_escape_string($data['recipeId']);
    $productName = $conn->real_escape_string($data['productName']);
    $stockValue = $conn->real_escape_string($data['stockValue']);
    if (in_array($productName, ['Express', 'Capusin', 'Direct'])) {
        $productName = 'bonn';  
    }
    if ($productName == 'Gazouz') {
        $productName = 'Coca';  
    }
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
