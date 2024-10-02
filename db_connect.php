<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "bloco_notas_isabela_victoria";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn -> connect_error);
}

?>