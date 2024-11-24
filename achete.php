<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "cafe"; 
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);
$produit = $data['produit'];
$prix = $data['prix'];
$quantite = $data['quantite'];
$recetteId = $data['recetteId'];

// Vérifier si le produit est déjà dans la table recete pour cet ID de recette
$sqlCheck = "SELECT quantity FROM recete WHERE nomproduit = ? AND ididrecetes = ?";
$stmt = $conn->prepare($sqlCheck);
$stmt->bind_param("si", $produit, $recetteId);
$stmt->execute();
$stmt->bind_result($existingQuantite);
$stmt->fetch();
$stmt->close();

if ($existingQuantite !== null) {
    // Si le produit existe déjà, mettre à jour la quantité et le prix total
    $newQuantite = $existingQuantite + 1;
    $newPrixTotal = $newQuantite * $prix;

    $sqlUpdate = "UPDATE recete SET quantity = ?, prix_totale_de_produit = ? WHERE nomproduit = ? AND ididrecetes = ?";
    $stmt = $conn->prepare($sqlUpdate);
    $stmt->bind_param("idsi", $newQuantite, $newPrixTotal, $produit, $recetteId);
    $stmt->execute();
    $stmt->close();

    // Enregistrer dans ticket.txt
    $file = fopen('ticket.txt', 'a');
    if ($file) {
        $ticketData = "Produit: " . $produit . ", Prix: " . $prix . " DT\n";
        fwrite($file, $ticketData);
        fclose($file);
    } else {
        echo json_encode(['message' => 'Erreur lors de l\'ouverture du fichier ticket.txt']);
    }

    echo json_encode(['message' => "Produit mis à jour et données enregistrées dans ticket.txt avec succès."]);
} else {
    // Si le produit n'existe pas, insérer une nouvelle ligne dans la table recete
    $prixTotalProduit = $quantite * $prix;
    $sqlInsert = "INSERT INTO recete (nomproduit, quantity, prix_totale_de_produit, ididrecetes) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sqlInsert);
    $stmt->bind_param("sidi", $produit, $quantite, $prixTotalProduit, $recetteId);
    $stmt->execute();
    $stmt->close();

    // Enregistrer dans ticket.txt
    $file = fopen('ticket.txt', 'a');
    if ($file) {
        $ticketData = "Produit: " . $produit . ", Prix: " . $prix . " DT\n";
        fwrite($file, $ticketData);
        fclose($file);
    } else {
        echo json_encode(['message' => 'Erreur lors de l\'ouverture du fichier ticket.txt']);
    }

    echo json_encode(['message' => "Produit ajouté dans la recette et données enregistrées dans ticket.txt."]);
}

$conn->close();
?>
