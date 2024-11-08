<?php
// Étape 1 : Connexion à la base de données
$servername = "localhost"; // Remplacez par votre serveur de base de données
$username = "root"; // Remplacez par votre nom d'utilisateur
$password = ""; // Remplacez par votre mot de passe
$dbname = "cafe"; // Remplacez par le nom de votre base de données

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Traitement de la suppression
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $sql = "DELETE FROM serveur WHERE id_serveur = ?"; // Utilisation du bon nom de colonne pour la clé primaire
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        echo "<div class='alert alert-success' role='alert'>Serveur supprimé avec succès.</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Erreur lors de la suppression : " . $conn->error . "</div>";
    }
    $stmt->close();
}

// Récupération de tous les serveurs dans la table
$sql = "SELECT id_serveur, nom, numtel , motdepasse FROM serveur"; // Sélection des colonnes pertinentes
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Serveurs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .delete-button {
            color: red;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="container mt-5">        
    <div style="width:99%;text-align:center;"><button class="btn btn-success mb-3" onclick="openAddModal()">Ajouter un serveur</button></div>
    <script>
        function openAddModal() {
            $('#addModal').modal('show');
        }
        function closeModal() {
            $('#addModal').modal('hide');
        }
    </script>
    <h2 class="text-center">Liste des Serveurs</h2>
    <table class="table table-bordered table-striped mt-4">
        <thead class="thead-dark">
            <tr>
                <th>Nom du Serveur</th>
                <th>Numéro de Téléphone</th>
                <th>
                    motdepasse
                </th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nom']); ?></td>
                        <td><?php echo htmlspecialchars($row['numtel']); ?></td>
                        <td><?php echo htmlspecialchars($row['motdepasse']); ?></td>

                        <td>
                            <a href="?delete_id=<?php echo $row['id_serveur']; ?>" class="delete-button" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce serveur ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center">Aucun serveur trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Ajouter un serveur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="nomserveur">Nom du serveur</label>
                <input type="text" class="form-control" id="nomserveur" required>
                <label for="numtlf">Numéro de téléphone</label>
                <input type="number" class="form-control" id="numtlf" required>
                <button type="button" class="btn btn-success mt-3" onclick="addserveur()">Ajouter</button>
            </div>
        </div>
    </div>
</div>


    <script>
        async function addserveur() {
        const nomserveur = document.getElementById('nomserveur').value;
        const numtlf = document.getElementById('numtlf').value;

        const response = await fetch('add_serveur.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `nomserveur=${encodeURIComponent(nomserveur)}&numtlf=${encodeURIComponent(numtlf)}`
        });

        if (response.ok) {
            location.reload(); 
        } else {
            alert('Erreur lors de l\'ajout du serveur');
        }
        }   

    </script>
<?php
$conn->close();
?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
