<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_log('php_errors.log'); 

ob_clean(); 
flush();    
header('Content-Type: application/json');
echo json_encode(['success' => true]);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';  

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';          
    $mail->SMTPAuth   = true;
    $mail->Username   = 'bro188411@gmail.com';  
    $mail->Password   = 'oussama0101#';     
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('bro188411@gmail.com', 'Nom du Café');
    $mail->addAddress('bro188411@gmail.com');  

    $mail->isHTML(true);
    $mail->Subject = 'Détails de la Recette';
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['details'])) {
        echo json_encode(['success' => false, 'error' => 'Données non valides reçues.']);
        exit;
    }
    $message = "<h3>Détails de la Recette</h3><table border='1' cellpadding='5' cellspacing='0'>";
    $message .= "<tr><th>Nom du Produit</th><th>Quantité</th><th>Prix Total</th><th>Stock Initial</th><th>Stock Final</th><th>Manque</th></tr>";
    foreach ($data['details'] as $detail) {
        $message .= "<tr><td>" . htmlspecialchars($detail['nomproduit']) . "</td>";
        $message .= "<td>" . htmlspecialchars($detail['quantity']) . "</td>";
        $message .= "<td>" . number_format($detail['prix_total'], 2, ',', ' ') . " Dt</td>";
        $message .= "<td>" . htmlspecialchars($detail['stock_initial']) . "</td>";
        $message .= "<td>" . htmlspecialchars($detail['stock_final']) . "</td>";
        $message .= "<td>" . htmlspecialchars($detail['manque']) . "</td></tr>";
    }
    $message .= "</table>";
    $mail->Body = $message;
    $mail->send();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Erreur lors de l\'envoi de l\'email : ' . $mail->ErrorInfo]);
}
?>
