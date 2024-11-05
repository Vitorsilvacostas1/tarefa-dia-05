<?php
include 'config.php';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $data_nascimento = $_POST['data_nascimento'];

    $sql = "UPDATE usuarios SET nome='$nome', email='$email', senha='$senha', data_nascimento='$data_nascimento' WHERE id='$id'";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Usuário atualizado com sucesso!'); window.location.href='consultar.php';</script>";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT * FROM usuarios WHERE id='$id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Editar Usuário</title>
</head>
<body>
    <div class="container">
        <h1>Editar Usuário</h1>
        <form method="POST">
            <input type="text" name="nome" value="<?= $user['nome'] ?>" required>
            <input type="email" name="email" value="<?= $user['email'] ?>" required>
            <input type="password" name="senha" placeholder="Nova Senha (deixe vazio para não alterar)">
            <input type="date" name="data_nascimento" value="<?= $user['data_nascimento'] ?>">
            <button type="submit">Atualizar</button>
        </form>
        <a href="consultar.php">Voltar</a>
    </div>
</body>
</html>
