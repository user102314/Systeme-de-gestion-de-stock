<?php
// Paramètres de configuration PHP pour l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// En-tête de type JSON
header('Content-Type: application/json');

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";  
$dbname = "cafe";
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// Récupération des données JSON
$data = json_decode(file_get_contents('php://input'), true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'error' => 'Invalid JSON']);
    exit;
}

// Données de base
$startTime = $conn->real_escape_string($data['startTime'] ?? '');
$endTime = $conn->real_escape_string($data['endTime'] ?? '');
$total = $conn->real_escape_string($data['total'] ?? 0);
$serverName = $conn->real_escape_string($data['serverName'] ?? ''); 
$details = json_encode($data['details'] ?? []);

// Tableau des produits à gérer
$produits = [
    'Canette', 'Gateau', 'Paket Legere', 'Paket MontiCarlo','MontiCarlo', 'Paket Danhit', 'Paket Kamel', 'Oris Double Fusion','Cristal',
    'Paket Oris / Karillia / قوافل', 'Paket Safir', 'Kamel Slims', 'Paket Cristal', 'Karillia Slimse', 'Oris / Karillia / قوافل',
    'Paket Mars Legere', 'Paket Mirit/Malboro', 'Paket Kamel Slims', 'Paket Calillia Slims','Mars Legere','Danhit','Kamel','Legere',
    'Mirit / Malboro','Safir','Paket Oris Double Fusion'
];

// Mise à jour des recettes si l'ID est défini
if (isset($data['recipeId'])) {
    $recipeId = $conn->real_escape_string($data['recipeId']);
    $sql = "UPDATE recetes SET datesortie = '$endTime', prixtotale = '$total' WHERE idrecetes = '$recipeId'";

    // Exécution de la requête SQL
    if (!$conn->query($sql)) {
        echo json_encode(['success' => false, 'error' => 'Failed to update recetes: ' . $conn->error]);
        exit;
    }

    // Calcul de la quantité de stock
    $sqlStockInitial = "SELECT nomproduitstock, quantite FROM stockinitial WHERE idrecetes = '$recipeId'";
    $resultStockInitial = $conn->query($sqlStockInitial);
$test = 0;
    if ($resultStockInitial) {
        while ($row = $resultStockInitial->fetch_assoc()) {
            $nomProduitStock = $row['nomproduitstock'];
            $quantiteStockInitial = $row['quantite'];
            $quantiteFinale = $quantiteStockInitial;

            if ($nomProduitStock === 'Bonn') {
                $sommeProduits = ($data['details']['Express'] ?? 0)+ ($data['details']['Cappuccino
'] ?? 0)  + ($data['details']['Americaine'] ?? 0)+ ($data['details']['Capucin'] ?? 0)  + ($data['details']['Cafe Creme'] ?? 0);
                $test = $sommeProduits;
                $quantiteFinale = $quantiteStockInitial - ($sommeProduits * 9);

                $tableaubon = "INSERT INTO bonn (ididrecetes, quantite, stockinitial) VALUES (?, ?, ?)";
                $stmtBonn = $conn->prepare($tableaubon);
                $stmtBonn->bind_param("iis", $recipeId, $sommeProduits, $quantiteStockInitial);
        
                if (!$stmtBonn->execute()) {
                    echo json_encode(['success' => false, 'error' => 'Failed to insert into bonn: ' . $stmtBonn->error]);
                    exit;
                }
            }elseif ($nomProduitStock === 'Mars Legere') {
                $quantiteProduit = $data['details'][$nomProduitStock] ?? 0;
                $quantiteFinale = $quantiteStockInitial - $quantiteProduit;
            }elseif ($nomProduitStock === 'Paket Mars Legere') {
                $quantiteProduit = $data['details'][$nomProduitStock] ?? 0;
                $quantiteFinale = $quantiteStockInitial - $quantiteProduit;
            }
             elseif (in_array($nomProduitStock, $produits)) {
                $quantiteProduit = $data['details'][$nomProduitStock] ?? 0;
                $quantiteFinale = $quantiteStockInitial - $quantiteProduit;
            }

            // Insertion des résultats finaux
            $sqlInsertStockFinal = "INSERT INTO stockfinale (nomproduitstock, quantite, idrecetes) VALUES (?, ?, ?)";
            $stmtStockFinal = $conn->prepare($sqlInsertStockFinal);
            $stmtStockFinal->bind_param("sii", $nomProduitStock, $quantiteFinale, $recipeId);

            if (!$stmtStockFinal->execute()) {
                echo json_encode(['success' => false, 'error' => 'Failed to insert into stockfinal: ' . $stmtStockFinal->error]);
                exit;
            }

            // Mise à jour du stock
            $sqlUpdateStock = "UPDATE stock SET quantityprod = ? WHERE nomprod = ?";
            $stmtUpdateStock = $conn->prepare($sqlUpdateStock);
            $stmtUpdateStock->bind_param("is", $quantiteFinale, $nomProduitStock);

            if (!$stmtUpdateStock->execute()) {
                echo json_encode(['success' => false, 'error' => 'Failed to update stock: ' . $stmtUpdateStock->error]);
                exit;
            }
        }

        // Insertion de la quantité totale dans la table "bonn"
        

        echo json_encode(['success' => true, 'message' => 'Service terminé et stockfinal mis à jour avec succès.']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to retrieve stockinitial data: ' . $conn->error]);
    }
} else {
    // Création de l'enregistrement si le serveur n'est pas défini
    if (empty($serverName)) {
        echo json_encode(['success' => false, 'error' => 'Server name is missing.']);
        exit;
    }

    $sql = "INSERT INTO recetes (dateentree, nomserveur) VALUES (NOW(), '$serverName')";
    if ($conn->query($sql)) {
        $recipeId = $conn->insert_id;

        // Récupération des produits en stock
        $sqlProduits = "SELECT idprod, nomprod, quantityprod FROM stock";
        $resultProduits = $conn->query($sqlProduits);

        if ($resultProduits && $resultProduits->num_rows > 0) {
            while ($row = $resultProduits->fetch_assoc()) {
                $nomproduitstock = $row['nomprod'];
                $quantite = $row['quantityprod'];
                
                // Insertion dans le stock initial
                $sqlStockInitial = "INSERT INTO stockinitial (nomproduitstock, quantite, idrecetes) VALUES (?, ?, ?)";
                $stmtStock = $conn->prepare($sqlStockInitial);
                $stmtStock->bind_param("sii", $nomproduitstock, $quantite, $recipeId);

                if (!$stmtStock->execute()) {
                    echo json_encode(['success' => false, 'error' => 'Failed to insert into stockinitial: ' . $stmtStock->error]);
                    exit;
                }
            }
            echo json_encode(['success' => true, 'recipeId' => $recipeId]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No products found in stock table.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to create service: ' . $conn->error]);
    }
}

// Fermeture de la connexion
$conn->close();
?>
