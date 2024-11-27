<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "cafe"; 
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT * FROM serveur WHERE nom = ? AND motdepasse = ?");
    $stmt->bind_param("ss", $name, $password); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $insertStmt = $conn->prepare("INSERT INTO lastlogin (nom) VALUES (?)");
        $insertStmt->bind_param("s", $name); 
        $insertStmt->execute();
        $insertStmt->close();

        header("Location: serveur.php"); 
        exit();
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
    }

    $stmt->close();
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
            <h2>تسجيل الدخول كموظف</h2>
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
            <a href="login.php" class="btn btn-link mt-3">الوصول كمدير</a>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</body>
</html>
