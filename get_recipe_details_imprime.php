<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "cafe";
$conn = new mysqli($servername, $username, $password, $dbname);

// Helper function to handle product name transformations
$productMap = [
    'Express' => 'Bonn',
    'Capucin' => 'Bonn',
    'Cafe Creme' => 'Bonn',
    'Cappuccino'=> 'Bonn',
    'Americaine'=> 'Bonn',
    'Paket MontiCarlo' => 'Paket MontiCarlo',
    'Mars Legere' => 'Mars Legere',
    'Paket Mirit / Malboro' => 'Paket Mirit/Malboro'
];

// Vérifier la connexion à la base de données
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Vérifier si l'identifiant de la recette est fourni dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Erreur : identifiant de la recette manquant.");
}

$recipeId = $conn->real_escape_string($_GET['id']);

// Exécuter la requête pour récupérer les détails de la recette
$sql = "SELECT nomproduit, quantity, prix_totale_de_produit AS prix_unitaire, prix_totale_de_produit AS prix_total 
        FROM recete WHERE ididrecetes = '$recipeId'";
$result = $conn->query($sql);

// Vérifier que la requête a fonctionné
if (!$result) {
    die("Erreur lors de l'exécution de la requête : " . $conn->error);
}

// Vérifier s'il y a des résultats pour cet ID de recette
if ($result->num_rows === 0) {
    die("Erreur : aucune recette trouvée pour l'ID fourni ($recipeId).");
}

// Préparer le contenu du fichier texte sous forme de tableau
$fileContent = "Détails de la Recette (ID: $recipeId)\n";
$fileContent .= str_repeat("-", 80) . "\n"; // Ligne de séparation
$fileContent .= "| Nom du Produit       | Quantité | Prix Unitaire (Dt) | Prix Total (Dt) | Stock Initial | Stock Final |\n";
$fileContent .= str_repeat("-", 80) . "\n"; // Ligne de séparation

while ($row = $result->fetch_assoc()) {
    $productName = $row['nomproduit'];
    $quantity = $row['quantity'];
    $prixUnitaire = $row['prix_unitaire'];
    $prixTotal = $row['prix_total'];

    // Récupérer le stock initial pour ce produit
    $sql_initial_stock = "SELECT quantite FROM stockinitial WHERE idrecetes = '$recipeId' AND nomproduitstock = '$productName'";
    $result_initial_stock = $conn->query($sql_initial_stock);
    $initial_stock = $result_initial_stock->num_rows > 0 ? $result_initial_stock->fetch_assoc()['quantite'] : 0;

    // Vérifier si le produit est dans le tableau de transformation
    if (array_key_exists($productName, $productMap)) {
        $originalProductName = $productName; // Sauvegarder le nom initial du produit
        $productName = $productMap[$productName]; // Remplacer par le nom transformé

        // Récupérer le stock final pour ce produit
        $sql_final_stock = "SELECT quantite FROM stockfinale WHERE idrecetes = '$recipeId' AND nomproduitstock = '$productName'";
        $result_final_stock = $conn->query($sql_final_stock);
        $final_stock = $result_final_stock->num_rows > 0 ? $result_final_stock->fetch_assoc()['quantite'] : 0;

        // Si le produit est 'Bonn', récupérer la quantité de stock dans la table 'bonn'
        if ($productName == 'Bonn') {
            $sql_initial_stock = "SELECT quantite FROM stockinitial WHERE idrecetes = '$recipeId' AND nomproduitstock = 'Bonn'";
            $result_initial_stock = $conn->query($sql_initial_stock);
            $initial_stock = $result_initial_stock->num_rows > 0 ? $result_initial_stock->fetch_assoc()['quantite'] : 0;

            $sql_final_stock = "SELECT quantityprod FROM stock WHERE nomprod = 'Bonn'";
            $result_final_stock = $conn->query($sql_final_stock);
            $final_stock = $result_final_stock->num_rows > 0 ? $result_final_stock->fetch_assoc()['quantityprod'] : 0;
        }

        $productName = $originalProductName;  // Restauration du nom original du produit
    } else {
        // Récupérer le stock final pour ce produit non transformé
        $sql_final_stock = "SELECT quantite FROM stockfinale WHERE idrecetes = '$recipeId' AND nomproduitstock = '$productName'";
        $result_final_stock = $conn->query($sql_final_stock);
        $final_stock = $result_final_stock->num_rows > 0 ? $result_final_stock->fetch_assoc()['quantite'] : 0;
    }

    // Ajouter les détails au contenu du fichier sous forme de tableau
    $fileContent .= sprintf("| %-19s | %-8d | %-18s | %-16s | %-13d | %-10d |\n", 
        $productName, $quantity, $prixUnitaire, $prixTotal, $initial_stock, $final_stock);
}

$fileContent .= str_repeat("-", 80) . "\n"; // Ligne de séparation

// Nom du fichier à télécharger
$fileName = "Recette_Details_$recipeId.txt";

// Envoyer les en-têtes HTTP pour télécharger le fichier
header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="' . $fileName . '"');
header('Content-Length: ' . strlen($fileContent));

// Afficher le contenu du fichier
echo $fileContent;

$conn->close();
exit();
?>
