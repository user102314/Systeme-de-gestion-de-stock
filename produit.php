<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cafe";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Échec de connexion : " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Produits</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Liste des Produits</h1>
        <button class="btn btn-success mb-3" onclick="openAddModal()" style="width:99%;text-align:center;">Ajouter un produit</button>
        <table class="table table-striped table-bordered" id="productTable" style="width:99%;text-align:center;">
            <thead class="thead-dark">
                <tr>
                    <th>Nom du Produit</th>
                    <th>Prix</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql = "SELECT id_produit, item, prix, type FROM produit";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['item']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['prix']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['type']) . '</td>';
                    echo '<td>
                            <button class="btn btn-primary btn-sm" onclick="openEditModal(' . $row['id_produit'] . ', \'' . addslashes($row['item']) . '\', ' . $row['prix'] . ', \'' . addslashes($row['type']) . '\')">Éditer</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteItem(' . $row['id_produit'] . ')">Supprimer</button>
                          </td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="4">Aucun produit trouvé</td></tr>';
            }
            ?>
            </tbody>
        </table>
    </div>

    <!-- Modal for editing a product -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Éditer le produit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="idproduit">
                    <label for="editProductName">Nom du Produit</label>
                    <input type="text" class="form-control" id="editProductName" required>
                    <label for="editProductPrice">Prix</label>
                    <input type="number" class="form-control" id="editProductPrice" required>
                    <label for="editProductType">Type</label>
                    <input type="text" class="form-control" id="editProductType" required>
                    <button type="button" class="btn btn-primary mt-3" onclick="saveChanges()">Sauvegarder</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for adding a product -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Ajouter un produit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="addProductName">Nom du Produit</label>
                    <input type="text" class="form-control" id="addProductName" required>
                    <label for="addProductPrice">Prix</label>
                    <input type="number" class="form-control" id="addProductPrice" required>
                    <label for="addProductType">Type</label>
                    <input type="text" class="form-control" id="addProductType" required>
                    <button type="button" class="btn btn-success mt-3" onclick="addProduct()">Ajouter</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openEditModal(id, name, price, type) {
            document.getElementById('idproduit').value = id;
            document.getElementById('editProductName').value = name;
            document.getElementById('editProductPrice').value = price;
            document.getElementById('editProductType').value = type;
            $('#editModal').modal('show');
        }

        async function saveChanges() {
            const id = document.getElementById('idproduit').value;
            const updatedName = document.getElementById('editProductName').value;
            const updatedPrice = document.getElementById('editProductPrice').value;
            const updatedType = document.getElementById('editProductType').value;

            const response = await fetch('update_productt.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `idproduit=${id}&nomproduit=${encodeURIComponent(updatedName)}&prix=${updatedPrice}&type=${encodeURIComponent(updatedType)}`
            });

            if (response.ok) {
                location.reload();
            } else {
                alert('Erreur lors de la mise à jour du produit');
            }
        }

        async function deleteItem(id) {
            const response = await fetch('delete_productt.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id=${id}`
            });

            if (response.ok) {
                location.reload();
            } else {
                alert('Erreur lors de la suppression du produit');
            }
        }

        function openAddModal() {
            $('#addModal').modal('show');
        }

        async function addProduct() {
            const name = document.getElementById('addProductName').value;
            const price = document.getElementById('addProductPrice').value;
            const type = document.getElementById('addProductType').value;

            const response = await fetch('add_productt.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `nomproduit=${encodeURIComponent(name)}&prix=${price}&type=${encodeURIComponent(type)}`
            });

            if (response.ok) {
                location.reload();
            } else {
                alert('Erreur lors de l\'ajout du produit');
            }
        }

        function closeModal() {
            $('#editModal').modal('hide');
            $('#addModal').modal('hide');
        }
    </script>
</body>
</html>
