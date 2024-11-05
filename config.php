<?php
$servername = "localhost"; // ou o IP do seu servidor
$username = "root"; // seu usuário MySQL
$password = ""; // sua senha MySQL
$dbname = "LongaVida"; // nome do banco de dados

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
