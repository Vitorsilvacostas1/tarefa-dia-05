<?php
include 'config.php';

$id = $_GET['id'];

$sql = "DELETE FROM usuarios WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Usuário excluído com sucesso!'); window.location.href='consultar.php';</script>";
} else {
    echo "Erro: " . $conn->error;
}
?>
