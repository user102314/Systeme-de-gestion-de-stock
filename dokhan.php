<?php
header('Content-Type: application/json'); // Indique que la réponse sera en JSON
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cafe";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['error' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(['error' => 'Invalid JSON data received']);
    exit;
}

$requiredKeys = ['produit', 'quantite', 'recetteId'];
foreach ($requiredKeys as $key) {
    if (!isset($data[$key])) {
        echo json_encode(['error' => "Missing key: $key"]);
        exit;
    }
}

$produit = $data['produit'];
$quantite = $data['quantite'];
$recetteId = $data['recetteId'];

// Liste des produits valides
$produits = [
    'MontiCarlo', 'Oris Double Fusion', 'Cristal',
    'Kamel Slims', 'Karillia Slimse', 'Oris / Karillia / قوافل',
    'Mars Legere', 'Danhit', 'Kamel', 'Legere',
    'Mirit / Malboro', 'Safir'
];

// Vérifie si le produit est valide
if (!in_array($produit, $produits)) {
    echo json_encode(['error' => 'Produit non valide']);
    exit;
}

try {
    $sqlCheckStock = "SELECT quantite FROM stockinitial WHERE nomproduitstock = ? AND idrecetes = ?";
    $stmtCheckStock = $conn->prepare($sqlCheckStock);
    $stmtCheckStock->bind_param("si", $produit, $recetteId);
    $stmtCheckStock->execute();
    $stmtCheckStock->bind_result($quantityprod);
    $stmtCheckStock->fetch();
    $stmtCheckStock->close();

    if (!$quantityprod) {
        echo json_encode(['error' => 'Produit non trouvé dans le stock']);
        exit;
    }

    if ($quantite > $quantityprod) {
        // Mise à jour du stock
        $newQuantityStock = $quantityprod + 20;
        $sqlUpdateStock = "UPDATE stockinitial SET quantite = ? WHERE nomproduitstock = ?";
        $stmtUpdateStock = $conn->prepare($sqlUpdateStock);
        $stmtUpdateStock->bind_param("is", $newQuantityStock, $produit);
        $stmtUpdateStock->execute();
        $stmtUpdateStock->close();
        $nvproduit = 'Paket '.$produit;
        // Mise à jour de la recette
        $sqlUpdateRemaining = "UPDATE stockinitial SET quantite = quantite - 1 WHERE idrecetes = ? AND nomproduitstock = ?";
        $stmtRemaining = $conn->prepare($sqlUpdateRemaining);
        $stmtRemaining->bind_param("is", $recetteId, $nvproduit);
        $stmtRemaining->execute();
        $stmtRemaining->close();

        echo json_encode(['message' => "Stock updated and recipe quantity adjusted successfully."]);
    } else {
        echo json_encode(['message' => 'Aucune mise à jour nécessaire. Quantité suffisante dans le stock.']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

$conn->close();
?>
