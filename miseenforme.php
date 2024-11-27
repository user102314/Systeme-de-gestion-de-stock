<?php
// Ouvrir le fichier en mode lecture et écriture
$file = fopen('ticket.txt', 'r+');

if ($file) {
    // Lire tout le contenu du fichier
    $contents = fread($file, filesize('ticket.txt'));
    fclose($file);

    // Séparer les lignes par produit
    $lines = explode("\n", $contents);

    // Tableau pour stocker les produits et leurs informations
    $productCounts = [];

    // Analyser chaque ligne pour extraire le produit et son prix
    foreach ($lines as $line) {
        // Chercher si la ligne correspond au format "Produit: nom, Prix: prix"
        if (preg_match('/Produit:\s*(.*),\s*Prix:\s*(\d+)\s*DT/', $line, $matches)) {
            $productName = trim($matches[1]);
            $productPrice = (int)$matches[2];

            // Ajouter le produit au tableau avec son prix
            if (isset($productCounts[$productName])) {
                // Si le produit existe déjà, on incrémente sa quantité et on calcule le prix total
                $productCounts[$productName]['quantity'] += 1;
                $productCounts[$productName]['totalPrice'] += $productPrice;
            } else {
                // Sinon, on initialise le produit avec sa quantité et son prix total
                $productCounts[$productName] = [
                    'quantity' => 1,
                    'totalPrice' => $productPrice
                ];
            }
        }
    }

    // Ouvrir de nouveau le fichier en mode écriture
    $file = fopen('ticket.txt', 'w');

    if ($file) {
        // Format de la date actuelle
        $currentDate = date('H:i:s d/m/Y');

        // Construire le ticket avec les informations formatées
        $ticketData = "____ BIENVENU ___\n";
        $ticketData .= "*** Cafe Zone ***\n";
        $ticketData .= "Date :\n $currentDate\n\n";
        $ticketData .="Le(s) Produit : ";

        // Ajouter les produits, leur quantité et le prix total
        foreach ($productCounts as $product => $data) {
            $ticketData .= ucfirst($product) . " * " . $data['quantity'] . " " . $data['totalPrice'] . " مليم\n";
        }

        // Ajouter la ligne de séparation à la fin
        $ticketData .= "---- BAY ----\n";

        // Réécrire les données formatées dans le fichier
        fwrite($file, $ticketData);

        // Fermer le fichier
        fclose($file);

        echo json_encode(['message' => 'Fichier ticket.txt mis à jour avec succès.']);
    } else {
        echo json_encode(['message' => 'Erreur lors de l\'ouverture du fichier ticket.txt pour écriture.']);
    }
} else {
    echo json_encode(['message' => 'Erreur lors de l\'ouverture du fichier ticket.txt pour lecture.']);
}
?>
