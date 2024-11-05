<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $data_nascimento = $_POST['data_nascimento'];
    $cpf = $_POST['cpf'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];

    $hashed_password = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nome, email, senha, data_nascimento, cpf, cidade, estado) 
            VALUES ('$nome', '$email', '$hashed_password', '$data_nascimento', '$cpf', '$cidade', '$estado')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p>Usuário cadastrado com sucesso!</p>";
    } else {
        echo "<p>Erro: " . $conn->error . "</p>";
    }
}

if (isset($_GET['editar'])) {
    $id = $_GET['editar'];
    $sql = "SELECT * FROM usuarios WHERE id = $id";
    $result = $conn->query($sql);
    $usuario = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['atualizar'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $data_nascimento = $_POST['data_nascimento'];
    $cpf = $_POST['cpf'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];

    if (empty($senha)) {
        $sql = "UPDATE usuarios SET nome='$nome', email='$email', data_nascimento='$data_nascimento', cpf='$cpf', cidade='$cidade', estado='$estado' WHERE id=$id";
    } else {
        $hashed_password = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET nome='$nome', email='$email', senha='$hashed_password', data_nascimento='$data_nascimento', cpf='$cpf', cidade='$cidade', estado='$estado' WHERE id=$id";
    }
    
    if ($conn->query($sql) === TRUE) {
        echo "<p>Usuário atualizado com sucesso!</p>";
    } else {
        echo "<p>Erro: " . $conn->error . "</p>";
    }
}

if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    $sql = "DELETE FROM usuarios WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p>Usuário excluído com sucesso!</p>";
    } else {
        echo "<p>Erro: " . $conn->error . "</p>";
    }
}

$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuários</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            color: #fff;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #fff;
        }
        form {
            background-color: #1a1a1a;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(255, 255, 255, 0.1);
        }
        label {
            display: block;
            margin: 5px 0;
            color: #fff;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #444;
            border-radius: 4px;
            background-color: #333;
            color: #fff;
        }
        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #1a1a1a;
        }
        th, td {
            border: 1px solid #444;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #222;
        }
        .action-buttons a {
            margin-right: 10px;
            color: #007BFF;
            text-decoration: none;
        }
        .action-buttons a:hover {
            text-decoration: underline;
        }
        .show-password {
            cursor: pointer;
            margin-left: 5px;
        }
    </style>
    <script>
        function togglePassword() {
            const passwordField = document.getElementById("senha");
            const passwordType = passwordField.getAttribute("type") === "password" ? "text" : "password";
            passwordField.setAttribute("type", passwordType);
        }
    </script>
</head>
<body>
    <h2>Cadastro de Usuários</h2>
    <form method="POST" action="">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" value="<?php echo isset($usuario) ? $usuario['nome'] : ''; ?>" required>
        
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo isset($usuario) ? $usuario['email'] : ''; ?>" required>
        
        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" required>
        <span class="show-password" onclick="togglePassword()">👁️</span>
        
        <label for="data_nascimento">Data de Nascimento:</label>
        <input type="date" name="data_nascimento" value="<?php echo isset($usuario) ? $usuario['data_nascimento'] : ''; ?>" required>

        <label for="cpf">CPF:</label>
        <input type="text" name="cpf" value="<?php echo isset($usuario) ? $usuario['cpf'] : ''; ?>" required>
        
        <label for="cidade">Cidade:</label>
        <input type="text" name="cidade" value="<?php echo isset($usuario) ? $usuario['cidade'] : ''; ?>" required>
        
        <label for="estado">Estado:</label>
        <input type="text" name="estado" value="<?php echo isset($usuario) ? $usuario['estado'] : ''; ?>" required>

        <input type="hidden" name="id" value="<?php echo isset($usuario) ? $usuario['id'] : ''; ?>">
        <input type="submit" name="<?php echo isset($usuario) ? 'atualizar' : 'cadastrar'; ?>" value="<?php echo isset($usuario) ? 'Atualizar' : 'Cadastrar'; ?>">
    </form>

    <h2>Usuários Cadastrados</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Data de Nascimento</th>
            <th>CPF</th>
            <th>Cidade</th>
            <th>Estado</th>
            <th>Criado Em</th>
            <th>Ações</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nome']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['data_nascimento']; ?></td>
                    <td><?php echo $row['cpf']; ?></td>
                    <td><?php echo $row['cidade']; ?></td>
                    <td><?php echo $row['estado']; ?></td>
                    <td><?php echo $row['criado_em']; ?></td>
                    <td class="action-buttons">
                        <a href="?editar=<?php echo $row['id']; ?>">Alterar</a>
                        <a href="?excluir=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este usuário?');">Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="9">Nenhum usuário cadastrado.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
