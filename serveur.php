<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "cafe"; 
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Requête pour obtenir les produits
$sqlProduits = "SELECT id_produit, item, prix, type FROM produit";
$resultProduits = $conn->query($sqlProduits);

// Vérification des produits dans la base de données
if ($resultProduits->num_rows == 0) {
    echo "Aucun produit trouvé.";
}

$sqlServeurs = "SELECT nom FROM serveur";
$resultServeurs = $conn->query($sqlServeurs);


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قائمة المنتجات</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="ser.css">
</head>
<body onload="view1()">
    <div class="img">
        <img src="img/logo.png" alt="Logo">
    </div>
    <div class="container mt-5 text-center">        
        <div class="d-flex justify-content-center mt-3 flex-wrap">
            <button class="btn btn-success mx-2" onclick="demarrerService()">ابدأ الخدمة</button>
            <button class="btn btn-danger mx-2" onclick="finirService()">نهاية الخدمة</button>
        </div>
    </div>
    
    <div class="container mt-5 text-center">
        <h2 class="text-center">قائمة المنتجات</h2>

        <div class="choi">
            <button onclick="view1()">مشروبات</button>
            <button onclick="view2()">دخان</button>
            <button onclick="view3()">مأكولات</button>
        </div>
    </div>
    <script>
        function view1() {
            document.getElementById('aboir').style.display = 'block';
            document.getElementById('dokhan').style.display = 'none';
            document.getElementById('manger').style.display = 'none';
        }

        function view2() {
            document.getElementById('aboir').style.display = 'none';
            document.getElementById('dokhan').style.display = 'block';
            document.getElementById('manger').style.display = 'none';
        }

        function view3() {
            document.getElementById('aboir').style.display = 'none';
            document.getElementById('dokhan').style.display = 'none';
            document.getElementById('manger').style.display = 'block';
        }
    </script>
    <div class="container mt-4">
    <div id="aboir" class="product-category">
        <center><h4>مشروبات</h4></center>
        <div class="row">
            <?php
            $resultProduits->data_seek(0);
            while ($row = $resultProduits->fetch_assoc()) {
                if ($row['type'] === 'aboir'): ?>
                    <div class="col-md-2 mb-3"> 
                        <div class="card">
                            <div class="card-body" style="color:black;">
                                <h6 class="card-title"><?php echo htmlspecialchars($row['item']); ?></h6>
                                <p class="card-text"><?php echo htmlspecialchars($row['prix']); ?> مليم</p>
                                <a href="#" class="btn btn-primary btn-sm" onclick="acheter('<?php echo htmlspecialchars($row['item']); ?>', <?php echo htmlspecialchars($row['prix']); ?>)">يشتري</a>
                                <a href="#" class="btn btn-danger btn-sm" onclick="anulecommende('<?php echo htmlspecialchars($row['item']); ?>')">حذف</a>
                                <div class="quantity-display" id="<?php echo htmlspecialchars($row['item']); ?>-quantity">كمية: 0</div>
                            </div>
                        </div>
                    </div>
                <?php endif;
            }
            ?>
        </div>
    </div>

    <div id="dokhan" class="product-category">
        <center><h4>دخان</h4></center>

        <div class="row">
            <?php
            $resultProduits->data_seek(0);
            while ($row = $resultProduits->fetch_assoc()) {
                if ($row['type'] === 'dokhan'): ?>
                    <div class="col-md-2 mb-3">
                        <div class="card">
                            <div class="card-body" style="color:black;">
                                <h6 class="card-title"><?php echo htmlspecialchars($row['item']); ?></h6>
                                <p class="card-text"><?php echo htmlspecialchars($row['prix']); ?> مليم</p>
                                <a href="#" class="btn btn-primary btn-sm" onclick="acheter('<?php echo htmlspecialchars($row['item']); ?>', <?php echo htmlspecialchars($row['prix']); ?>)">يشتري</a>
                                <a href="#" class="btn btn-danger btn-sm" onclick="anulecommende('<?php echo htmlspecialchars($row['item']); ?>')">حذف</a>
                                <div class="quantity-display" id="<?php echo htmlspecialchars($row['item']); ?>-quantity">كمية: 0</div>
                            </div>
                        </div>
                    </div>
                <?php endif;
            }
            ?>
        </div>
    </div>

    <div id="manger" class="product-category">
        <center><h4>مأكولات</h4></center>
        <div class="row">
            <?php
            $resultProduits->data_seek(0); 
            while ($row = $resultProduits->fetch_assoc()) {
                if ($row['type'] === 'manger'): ?>
                    <div class="col-md-2 mb-3">
                        <div class="card">
                            <div class="card-body" style="color:black;">
                                <h6 class="card-title"><?php echo htmlspecialchars($row['item']); ?></h6>
                                <p class="card-text"><?php echo htmlspecialchars($row['prix']); ?> مليم</p>
                                <a href="#" class="btn btn-primary btn-sm" onclick="acheter('<?php echo htmlspecialchars($row['item']); ?>', <?php echo htmlspecialchars($row['prix']); ?>)">يشتري</a>
                                <a href="#" class="btn btn-danger btn-sm" onclick="anulecommende('<?php echo htmlspecialchars($row['item']); ?>')">حذف</a>
                                <div class="quantity-display" id="<?php echo htmlspecialchars($row['item']); ?>-quantity">كمية: 0</div>
                            </div>
                        </div>
                    </div>
                <?php endif;
            }
            ?>
        </div>
    </div>
</div>
</div>
<link rel="stylesheet" href="popup.css">
    <div id="popup" class="popup">
        <div class="popup-content">
            <p>برا ربي معاك إخدم علي روحك</p>
            <button id="closePopup">OK</button>
        </div>
    </div>
    <div id="popup1" class="popup">
        <div class="popup-content">
            <p>يرجى التحقق من الخدمة أولا.</p>
            <button id="closePopup1">OK</button>
        </div>
    </div>
    <div id="popup2" class="popup">
        <div class="popup-content">
            <p>الرجاء تحديد الخادم قبل بدء الخدمة.</p>
            <button id="closePopup2">OK</button>
        </div>
    </div>
    <div id="popup3" class="popup">
        <div class="popup-content">
            <p>اكتملت الخدمة Bayyy </p>
            <button id="closePopup3">OK</button>
        </div>
    </div>
</div>
<?php $conn->close(); ?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
  function anulecommende(nomproduit) {
    console.log("Product name passed:", nomproduit); 
    if (!nomproduit || nomproduit.trim() === "") {
        alert("Product name is required."); 
        return;
    }

        const data = { nomproduit: nomproduit };
        console.log(data)
        fetch('delete_recipe.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ nomproduit: nomproduit }),
})
.then(response => response.json())
.then(data => {
    if (data.status === 'success') {
        console.log(data.message); 
        const quantityElement = document.getElementById(nomproduit + '-quantity');
        const currentQuantity = parseInt(quantityElement.innerText.replace('كمية: ', ''), 10);
        if (!isNaN(currentQuantity) && currentQuantity > 0) {
            quantityElement.innerText = 'كمية: ' + (currentQuantity - 1);
        }
        alert('تم إلغاء الطلب بنجاح');
    } else {
        console.error('Erreur:', data.message);
        alert(data.message); 
    }
})
.catch(error => {
    console.error('Erreur:', error);
    alert("Une erreur est survenue.");
});   
}
</script>

<script>

function acheter(produit, prix) {
    if (!totalQuantities[produit]) {
        totalQuantities[produit] = 0;
    }
    totalQuantities[produit] += 1;
    totalPrice += prix;

    document.getElementById(produit + '-quantity').innerText = 'كمية: ' + totalQuantities[produit];
    console.log(`Total pour ${produit}: ${totalQuantities[produit]} unités, Prix total: ${totalPrice} DT`);
    sendRequest('achete.php', {
        produit: produit,
        prix: prix,
        quantite: totalQuantities[produit],
        recetteId: recipeId
    }).then(data => {
        if (data) console.log(data.message);
    });

    sendRequest('dokhan.php', {
        produit: produit,
        quantite: totalQuantities[produit],
        recetteId: recipeId
    }).then(data => {
        if (data) console.log(data.message);
    });
}
function sendRequest(url, data) {
    return fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur HTTP ' + response.status);
        }
        return response.json();
    })
    .catch(error => {
        console.error(`Erreur lors de l'appel à ${url}:`, error);
    });
}
document.addEventListener('keydown', function(event) {
    if (event.key === " " || event.code === "Space") {  
        console.log("Touche Espace pressée !");
        miseenforme();
        imprimerTicket(); 
                setTimeout(function() {
            viderTicket();
        }, 2000); 
    }
});

function imprimerTicket() {
    fetch('imprimerTicket.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur HTTP ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log(data.message); 
    })
    .catch(error => {
        console.error('Erreur lors de l\'impression du ticket:', error);
    });
    
}

function viderTicket() {
    fetch('viderTicket.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur HTTP ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log(data.message); // Affiche le message après avoir vidé le fichier
    })
    .catch(error => {
        console.error('Erreur lors du vidage du fichier:', error);
    });
}

function miseenforme() {
    fetch('miseenforme.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur HTTP ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log(data.message); 
    })
    .catch(error => {
        console.error('Erreur lors du miseenforme du fichier:', error);
    });
}
let serviceStartTime;
let recipeId;
let totalPrice = 0;  // Assuming this is defined somewhere
let totalQuantities = {};  // Assuming this is defined somewhere

function demarrerService() {
    // Ensure the popup closes when the user clicks the close button
    document.getElementById("closePopup").onclick = function() {
        document.getElementById("popup").style.display = "none";
    };

    // Initialize the start time
    serviceStartTime = new Date();
    console.log("Service démarré à : " + serviceStartTime);

    // Display the popup
    document.getElementById("popup").style.display = "flex";

    // Make the request to save service start time
    fetch('saveservice.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'startService',
            startTime: serviceStartTime,
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur HTTP ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log("Données reçues:", data); 
        if (data.success) {
            recipeId = data.recipeId; // Store recipeId from the response
            console.log("ID de la recette:", recipeId);
        } else {
            console.error("Erreur de réponse du serveur:", data.message || "Erreur inconnue");
            alert("Erreur lors de la création du service.");
        }
    })
    .catch(error => {
        console.error("Erreur de requête:", error);
        alert("Erreur: " + error);
    });
}
function finirService() {
    if (serviceStartTime && recipeId) {  // Check if service is started
        const serviceEndTime = new Date();
        console.log("Service terminé à : " + serviceEndTime);
        console.log("Total à payer : " + totalPrice + " DT");

        fetch('saveservice.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                startTime: serviceStartTime,
                endTime: serviceEndTime,
                total: totalPrice,
                details: totalQuantities,
                recipeId: recipeId
            })
        })
        .then(response => {
            if (response.ok) {
                document.getElementById("popup3").style.display = "flex";
                resetService();  // Reset the service data
            } else {
                alert("Erreur lors de l'enregistrement du service.");
            }
        })
        .catch(error => {
            alert("Erreur: " + error);
        });
    } else {
        // Service was not started yet, show the error popup
        document.getElementById("popup1").style.display = "flex";
    }
}

document.getElementById("closePopup1").onclick = function() {
    document.getElementById("popup1").style.display = "none";
};
document.getElementById("closePopup2").onclick = function() {
    document.getElementById("popup2").style.display = "none";
};
document.getElementById("closePopup3").onclick = function() {
    document.getElementById("popup3").style.display = "none";
};
function resetService() {
    totalQuantities = {};
    totalPrice = 0;
    serviceStartTime = null;
    recipeId = null;
    document.querySelectorAll('.quantity-display').forEach(element => {
        element.innerText = 'Quantité: 0';
    });
}
</script>
</body>
</html>

