<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "cafe"; 






$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}



header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

// Vérifiez si les données sont reçues
if (empty($data['nomproduit'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Le nom du produit n'est pas reçu dans la requête."
    ]);
    exit;
}

// Log des données reçues pour debug
file_put_contents('php_error_log.txt', "Nom produit: " . $data['nomproduit'] . PHP_EOL, FILE_APPEND);

$nomproduit = $data['nomproduit'];









// Select the latest entry for the product
$sql = "SELECT idrecete, quantity FROM recete WHERE nomproduit = ? ORDER BY idrecete DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nomproduit);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($idrecete, $quantity);
    $stmt->fetch();
    
    if ($quantity == 1) {
        // Delete the row if quantity is 1
        $deleteSql = "DELETE FROM recete WHERE idrecete = ? LIMIT 1";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bind_param("i", $idrecete);
        
        if ($deleteStmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Order successfully canceled."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error while deleting: " . $deleteStmt->error]);
        }
        $deleteStmt->close();
    } else {
        // Decrement the quantity if greater than 1
        $updateSql = "UPDATE recete SET quantity = quantity - 1 WHERE idrecete = ? LIMIT 1";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("i", $idrecete);
        
        if ($updateStmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Quantity updated successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error while updating: " . $updateStmt->error]);
        }
        $updateStmt->close();
    }
} else {
    echo json_encode(["status" => "error", "message" => "Record not found."]);
}

$stmt->close();
$conn->close();
?>
