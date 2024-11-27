<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "cafe"; 
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $sql = "DELETE FROM serveur WHERE id_serveur = ?"; 
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        echo "<div class='alert alert-success' role='alert'>Serveur supprimé avec succès.</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Erreur lors de la suppression : " . $conn->error . "</div>";
    }
    $stmt->close();
}

$sql = "SELECT id_serveur, nom, numtel , motdepasse FROM serveur";
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
<h2 class="text-center">الموظفين</h2>
    
<button class="btn btn-success mb-3 text-align:center;" onclick="openAddModal()" style="width:99%;text-align:center;">Ajouter un serveur</button>
<script>
        function openAddModal() {
            $('#addModal').modal('show');
        }
        function closeModal() {
            $('#addModal').modal('hide');
        }
    </script>
    <table class="table table-bordered table-striped mt-4">
        <thead class="thead-dark">
            <tr>
                <th>اسم موظف</th>
                <th>رقم التليفون</th>
                <th>
                كلمة المرور
                </th>
                <th>فعل</th>
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
                    <button class="btn btn-primary btn-sm" 
        onclick="openEditModal(
            <?php echo $row['id_serveur']; ?>, 
            '<?php echo htmlspecialchars($row['nom']); ?>', 
            '<?php echo htmlspecialchars($row['numtel']); ?>',
            '<?php echo htmlspecialchars($row['motdepasse']); ?>'
        )">Modifier</button>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="4" class="text-center">لم يتم العثور على خوادم.</td>
        </tr>
    <?php endif; ?>
</tbody>

    </table>
</div>
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">تعديل الخادم</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeEditModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editId">
                <label for="editNom">اسم الخادم</label>
                <input type="text" class="form-control" id="editNom" required>
                <label for="editNum">رقم التليفون</label>
                <input type="number" class="form-control" id="editNum" required>
                <label for="editPassword">كلمة المرور</label>
                <input type="password" class="form-control" id="editPassword" required>
                <button type="button" class="btn btn-primary mt-3" onclick="editServeur()">Enregistrer</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">إضافة خادم</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="nomserveur">اسم الخادم</label>
                <input type="text" class="form-control" id="nomserveur" required>
                <label for="numtlf">رقم التليفون</label>
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

        function openEditModal(id, nom, num) {
    document.getElementById('editId').value = id;
    document.getElementById('editNom').value = nom;
    document.getElementById('editNum').value = num;
    $('#editModal').modal('show');
}

function closeEditModal() {
    $('#editModal').modal('hide');
}
function openEditModal(id, nom, num, password) {
    document.getElementById('editId').value = id;
    document.getElementById('editNom').value = nom;
    document.getElementById('editNum').value = num;
    document.getElementById('editPassword').value = password;
    $('#editModal').modal('show');
}

async function editServeur() {
    const id = document.getElementById('editId').value;
    const nom = document.getElementById('editNom').value;
    const num = document.getElementById('editNum').value;
    const password = document.getElementById('editPassword').value;

    const response = await fetch('edit_serveur.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${encodeURIComponent(id)}&nom=${encodeURIComponent(nom)}&num=${encodeURIComponent(num)}&password=${encodeURIComponent(password)}`
    });

    if (response.ok) {
        location.reload();
    } else {
        alert('Erreur lors de la modification du serveur');
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
