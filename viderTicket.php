<?php
$file = fopen('ticket.txt', 'w');
if ($file) {
    $ticketData = "___________\n";
    fwrite($file, $ticketData);
    fclose($file);
    echo json_encode(['message' => 'Le fichier ticket.txt a été vidé et mis à jour avec succès.']);
} else {
    echo json_encode(['message' => 'Erreur lors de l\'ouverture du fichier ticket.txt']);
}
?>
