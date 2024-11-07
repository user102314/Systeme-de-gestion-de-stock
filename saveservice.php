<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";  
$dbname = "cafe";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// Décodage des données JSON reçues
$data = json_decode(file_get_contents('php://input'), true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'error' => 'Invalid JSON']);
    exit;
}

// Récupération des données depuis le JSON
$startTime = $conn->real_escape_string($data['startTime'] ?? '');
$endTime = $conn->real_escape_string($data['endTime'] ?? '');
$total = $conn->real_escape_string($data['total'] ?? 0);
$serverName = $conn->real_escape_string($data['serverName'] ?? ''); 
$details = json_encode($data['details'] ?? []);

// Si un ID de recette est fourni, on met à jour une recette existante
if (isset($data['recipeId'])) {
    $recipeId = $conn->real_escape_string($data['recipeId']);
    $sql = "UPDATE recetes SET datesortie = '$endTime', prixtotale = '$total' WHERE idrecetes = '$recipeId'";
    
    if (!$conn->query($sql)) {
        echo json_encode([
            'success' => false,
            'error' => 'Failed to update recetes: ' . $conn->error,
            'sql' => $sql
        ]);
        exit;
    }

    foreach ($data['details'] as $productName => $quantity) {
        if ($quantity > 0) {
            $priceSql = "SELECT prix FROM produit WHERE item = '$productName'";
            $priceResult = $conn->query($priceSql);
            if ($priceResult && $priceResult->num_rows > 0) {
                $price = $priceResult->fetch_assoc()['prix'];
            } else {
                echo json_encode(['success' => false, 'error' => 'Product not found: ' . $productName]);
                exit;
            }
            $priceTotal = $price * $quantity;
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

    // Remplissage de stockfinal en fonction des conditions
    $sqlStockInitial = "SELECT nomproduitstock, quantite FROM stockinitial WHERE idrecetes = '$recipeId'";
    $resultStockInitial = $conn->query($sqlStockInitial);

    if ($resultStockInitial) {
        while ($row = $resultStockInitial->fetch_assoc()) {
            $nomProduitStock = $row['nomproduitstock'];
            $quantiteStockInitial = $row['quantite'];
            $quantiteFinale = $quantiteStockInitial; // Initialisation de la quantité finale par défaut

            if ($nomProduitStock === 'Bonn') {
                // Calcul de SommeStockResteBonn
                $sommeProduits = ($data['details']['Express'] ?? 0) + ($data['details']['Capusin'] ?? 0) + ($data['details']['Direct'] ?? 0);
                $sommeStockResteBonn = $quantiteStockInitial - ($sommeProduits * 9);
                $quantiteFinale = $sommeStockResteBonn;

            } elseif ($nomProduitStock === 'Coca') {
                // Calcul de la différence avec la quantité de gazouz
                $quantiteGazouz = $data['details']['Gazouz'] ?? 0;
                $quantiteFinale = $quantiteStockInitial - $quantiteGazouz;
            }

            // Préparation de la requête pour insérer les données finales dans stockfinal
            $sqlInsertStockFinal = "INSERT INTO stockfinale (nomproduitstock, quantite, idrecetes) VALUES (?, ?, ?)";
            $stmtStockFinal = $conn->prepare($sqlInsertStockFinal);
            $stmtStockFinal->bind_param("sii", $nomProduitStock, $quantiteFinale, $recipeId);

            if (!$stmtStockFinal->execute()) {
                echo json_encode([
                    'success' => false,
                    'error' => 'Failed to insert into stockfinal: ' . $stmtStockFinal->error,
                    'sql' => $sqlInsertStockFinal
                ]);
                exit;
            }
        }
        echo json_encode(['success' => true, 'message' => 'Service terminé et stockfinal mis à jour avec succès.']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to retrieve stockinitial data: ' . $conn->error]);
    }

} else {
    // Création d'une nouvelle recette (service)
    if (empty($serverName)) {
        echo json_encode(['success' => false, 'error' => 'Server name is missing.']);
        exit;
    }

    $sql = "INSERT INTO recetes (dateentree, nomserveur) VALUES (NOW(), '$serverName')";
    if ($conn->query($sql)) {
        $recipeId = $conn->insert_id;  // Get the ID of the newly inserted recipe

        // Retrieve products from stock and insert into stockinitial
        $sqlProduits = "SELECT idprod, nomprod, quantityprod FROM stock";
        $resultProduits = $conn->query($sqlProduits);
        if (!$resultProduits) {
            echo json_encode(['success' => false, 'error' => 'Failed to retrieve products from stock: ' . $conn->error]);
            exit;
        }

        if ($resultProduits->num_rows > 0) {
            while ($row = $resultProduits->fetch_assoc()) {
                $nomproduitstock = $row['nomprod'];
                $quantite = $row['quantityprod'];

                // Insert into stockinitial
                $sqlStockInitial = "INSERT INTO stockinitial (nomproduitstock, quantite, idrecetes) VALUES (?, ?, ?)";
                $stmtStock = $conn->prepare($sqlStockInitial);
                $stmtStock->bind_param("sii", $nomproduitstock, $quantite, $recipeId);
                if (!$stmtStock->execute()) {
                    echo json_encode([
                        'success' => false,
                        'error' => 'Failed to insert into stockinitial: ' . $stmtStock->error,
                        'sql' => $sqlStockInitial
                    ]);
                    exit;
                }
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'No products found in stock table.']);
            exit;
        }

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
