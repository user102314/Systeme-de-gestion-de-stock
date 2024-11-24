<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h3 {
            font-size: 1.5em;
            text-align: center;
        }

        .container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }

        .card {
            min-height: 180px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            text-align: center;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            width: 200px;
            box-sizing: border-box;
        }

        .card img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .card a {
            text-decoration: none;
            color: black;
            font-size: 1.2em;
            margin-top: 10px;
        }

        /* Popup style */
        .popup {
            color: black;
        }

        .quantity-display {
            font-weight: bold;
            margin-top: 10px;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                align-items: center;
            }

            .card {
                width: 100%;
                max-width: 300px;
            }
        }

        @media (max-width: 480px) {
            h3 {
                font-size: 1.2em;
            }

            .card a {
                font-size: 1em;
            }
        }
    </style>
    <title>Admin Page</title>
</head>
<body>
    <h3>السلام عليكم</h3>
    <div class="container">
        <div class="card">
            <img src="img/1.jpg" alt="Stock"><br>
            <a href="stock.php">عرض رصيد</a>
        </div>
        <div class="card">
            <img src="img/1.jpg" alt="Seveurs"><br>
            <a href="Seveurs.php">الموظفين</a>
        </div>
        <div class="card">
            <img src="img/1.jpg" alt="Recetes"><br>
            <a href="Recetes.php">وصفات</a>
        </div>
        <div class="card">
            <img src="img/1.jpg" alt="Produits"><br>
            <a href="produit.php">عرض المنتجات</a>
        </div>
        <div class="card">
            <img src="img/1.jpg" alt="Imprime"><br>
            <a href="imprime.php">قائمة وصفات للطباعة</a>
        </div>
    </div>
</body>
</html>
