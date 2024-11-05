<?php
// Étape 1 : Connexion à la base de données
$servername = "localhost"; // Assurez-vous que le serveur est correctement défini
$username = "root"; // Remplacez par votre nom d'utilisateur
$password = ""; // Remplacez par votre mot de passe de base de données
$dbname = "cafe"; // Remplacez par le nom de votre base de données

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $password = $_POST['password'];
    
    // Vérification uniquement pour l'admin
    if ($name === "ADMIN" && $password === "admin") {
        header("Location: Admin.php");
        exit();
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5 loginn">
        <h2>Login</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="loginName">Nom</label>
                <input type="text" class="form-control" id="loginName" name="name" required>
            </div>
            <div class="form-group">
                <label for="loginPassword">Mot de passe</label>
                <input type="password" class="form-control" id="loginPassword" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
        
        <!-- Lien direct vers la page serveur pour les utilisateurs non-admin -->
        <a href="serveur.php" class="btn btn-link mt-3">Accéder en tant que serveur</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</body>
</html>
