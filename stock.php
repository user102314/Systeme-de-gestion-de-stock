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
    <title>Gestion de Stock</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container mt-5 text-align:center;">
        <h1 class="mb-4 text-align:center;" style="width:99%;text-align:center;">جرد المخزون</h1>
        <button class="btn btn-success mb-3 text-align:center;" onclick="openAddModal()" style="width:99%;text-align:center;">Ajouter un produit</button>
        <table class="table table-striped table-bordered text-align:center;" id="stockTable" style="width:99%;text-align:center;">
            <thead class="thead-dark">
                <tr>
                    <th>اسم المنتج</th>
                    <th>كمية</th>
                    <th>فعل</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql = "SELECT idprod, nomprod, quantityprod FROM stock";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['nomprod']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['quantityprod']) . '</td>';
                    echo '<td>
                            <button class="btn btn-primary btn-sm" onclick="openEditModal(' . $row['idprod'] . ', \'' . addslashes($row['nomprod']) . '\', ' . $row['quantityprod'] . ')">Éditer</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteItem(' . $row['idprod'] . ')">Supprimer</button>
                          </td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="3">Aucun produit trouvé</td></tr>';
            }
            ?>
            </tbody>
        </table>
    </div>

    <!-- Modale pour modifier un produit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">تحرير المنتج</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="idproduit">
                    <label for="editProductName">اسم المنتج</label>
                    <input type="text" class="form-control" id="editProductName" required>
                    <label for="editProductQuantity">كمية</label>
                    <input type="number" class="form-control" id="editProductQuantity" required>
                    <button type="button" class="btn btn-primary mt-3" onclick="saveChanges()">مسجل</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modale pour ajouter un produit -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">إضافة منتج</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="addProductName">اسم المنتج</label>
                    <input type="text" class="form-control" id="addProductName" required>
                    <label for="addProductQuantity">كمية</label>
                    <input type="number" class="form-control" id="addProductQuantity" required>
                    
                    <button type="button" class="btn btn-success mt-3" onclick="addProduct()">يضيف</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openEditModal(id, name, quantity) {
            document.getElementById('idproduit').value = id;
            document.getElementById('editProductName').value = name;
            document.getElementById('editProductQuantity').value = quantity;
            $('#editModal').modal('show');
        }

        async function saveChanges() {
            const id = document.getElementById('idproduit').value;
            const updatedName = document.getElementById('editProductName').value;
            const updatedQuantity = document.getElementById('editProductQuantity').value;

            const response = await fetch('update_product.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `idproduit=${id}&nomproduit=${encodeURIComponent(updatedName)}&quantite=${updatedQuantity}`
            });

            if (response.ok) {
                location.reload();
            } else {
                alert('Erreur lors de la mise à jour du produit');
            }
        }
        async function deleteItem(id) {
            const response = await fetch('delete_product.php', {
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
    const quantity = parseInt(document.getElementById('addProductQuantity').value, 10);

    // Validation of input fields
    if (!name || isNaN(quantity)) {
        alert('Veuillez remplir tous les champs avec des valeurs valides');
        return;
    }

    try {
        const response = await fetch('add_product.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `nomproduit=${encodeURIComponent(name)}&quantite=${quantity}`
        });

        if (response.ok) {
            location.reload();
        } else {
            const errorText = await response.text();
            console.error('Erreur du serveur:', errorText); // Log server error message for debugging
            alert('Erreur lors de l\'ajout du produit');
        }
    } catch (error) {
        console.error('Erreur réseau:', error); // Log network error
        alert('Erreur réseau. Veuillez vérifier votre connexion.');
    }
}

function closeModal() {
    $('#editModal').modal('hide');
    $('#addModal').modal('hide');
}

    </script>
</body>
</html>
