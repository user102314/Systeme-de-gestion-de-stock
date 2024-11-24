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
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="loginn" style="width: 35%; text-align: center;">
            <h2> تسجيل الدخول  كمدير</h2>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-group">
                    <label for="loginName">اسم</label>
                    <input type="text" class="form-control align-items-center" id="loginName" name="name" required>
                </div>
                <div class="form-group">
                    <label for="loginPassword">كلمة المرور</label>
                    <input type="password" class="form-control align-items-center" id="loginPassword" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">تسجيل الدخول</button>
            </form>
            <a href="loginserveur.php" class="btn btn-link mt-3">موظف</a>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</body>
</html>
