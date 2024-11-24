<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container mt-5 loginn">
        <h2 class="mt-5">Sign Up</h2>
        <form id="signupForm">
            <div class="form-group">
                <label for="signupName">Nom</label>
                <input type="text" class="form-control" id="signupName" name="nom" required>
            </div>
            <div class="form-group">
                <label for="signupPassword">Mot de passe</label>
                <input type="password" class="form-control" id="signupPassword" name="motdepasse" required>
            </div>
            <div class="form-group">
                <label for="signupPhone">Numéro de téléphone</label>
                <input type="text" class="form-control" id="signupPhone" name="numtlf" required>
            </div>
            <button type="submit" class="btn btn-success">Signup</button>
        </form>
        <div id="message" class="mt-3"></div>
    </div>

    <script>
        document.getElementById('signupForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            try {
                const response = await fetch('signup.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();
                
                const messageDiv = document.getElementById('message');
                if (result.success) {
                    messageDiv.innerHTML = '<div class="alert alert-success">Inscription réussie !</div>';
                    document.getElementById('signupForm').reset();
                } else {
                    messageDiv.innerHTML = '<div class="alert alert-danger">' + result.message + '</div>';
                }
            } catch (error) {
                console.error("Erreur:", error);
                alert("Erreur lors de l'inscription. Veuillez réessayer plus tard.");
            }
        });
    </script>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servername = "localhost";
    $username = "root";
    $password = ""; 
    $dbname = "cafe";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die(json_encode(['success' => false, 'message' => 'Erreur de connexion à la base de données.']));
    }
    $nom = $conn->real_escape_string($_POST['nom']);
    $motdepasse = password_hash($_POST['motdepasse'], PASSWORD_DEFAULT); 
    $numtlf = $conn->real_escape_string($_POST['numtlf']);
    $checkQuery = "SELECT * FROM serveur WHERE nom = '$nom'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Nom déjà utilisé!']);
    } else {
        $insertQuery = "INSERT INTO serveur (nom, motdepasse, numtlf) VALUES ('$nom', '$motdepasse', '$numtlf')";

        if ($conn->query($insertQuery) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Inscription réussie!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'inscription.']);
        }
    }
    $conn->close();
    exit;
}
?>
