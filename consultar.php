<?php
include 'config.php';

$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Consultar Usuários</title>
</head>
<body>
    <div class="container">
        <h1>Usuários Cadastrados</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['nome']}</td>
                            <td>{$row['email']}</td>
                            <td>
                                <a href='editar.php?id={$row['id']}'>Editar</a> | 
                                <a href='excluir.php?id={$row['id']}'>Excluir</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Nenhum usuário cadastrado.</td></tr>";
            }
            ?>
        </table>
        <a href="index.php">Voltar</a>
    </div>
</body>
</html>
