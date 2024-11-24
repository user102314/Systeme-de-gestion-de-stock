<?php
$servername = "sql303.infinityfree.com";
$username = "if0_37710768";
$password = "KQPI3NOpfO";
$dbname = "if0_37710768_cafe";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
