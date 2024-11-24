<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "cafe";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $idRecete = $conn->real_escape_string($data['idRecete']); 

    $sql = "SELECT stockdeadmine, quantite, stockinitial FROM bonn 
            WHERE ididrecetes = '$idRecete'";

    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stockDeadMine = $row['stockdeadmine'];
        $quantite = $row['quantite'];
        $stockInitial = $row['stockinitial'];

        $manque = ($stockInitial - $stockDeadMine ) / $quantite;

        echo json_encode(['success' => true, 'manque' => $manque]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Aucune donnée trouvée pour cette recette']);
    }
}

$conn->close();
?>
