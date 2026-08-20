<?php

session_start();

$host = "localhost";
$user = "root";
$password = "";
$database = "crud_aula";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// CADASTRAR
if (isset($_POST['cadastrar'])) {

    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);

    if (empty($nome) || empty($email)) {
        die("Nome e email são obrigatórios!");
    }

    $sql = "INSERT INTO usuarios (nome, email) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ss", $nome, $email);
    $stmt->execute();

    header("Location: index.php");
    exit;
}

// EXCLUIR
if (isset($_POST['excluir'])) {
    
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        die("Token CSRF inválido!");
    }
    
    $id = filter_var($_POST['excluir'], FILTER_VALIDATE_INT);
    if ($id === false) {
        die("ID inválido!");
    }

    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: index.php");
    exit;
}

// EDITAR
if (isset($_POST['editar'])) {

    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    $sql = "UPDATE usuarios SET nome = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ssi", $nome, $email, $id);
    $stmt->execute();

    header("Location: index.php");
    exit;
}

// BUSCAR USUÁRIOS
$sql = "SELECT id, nome, email FROM usuarios ORDER BY id DESC";
$resultado = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>CRUD de Usuários</title>
</head>

<body>

    <h1>Cadastro de Usuários</h1>

    <form method="POST">

        <label>Nome:</label>
        <input type="text" name="nome" required>

        <br><br>

        <label>E-mail:</label>
        <input type="email" name="email" required>

        <br><br>

        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <button type="submit" name="cadastrar">
            Cadastrar
        </button>

    </form>

    <h2>Usuários cadastrados</h2>

    <table border="1">

        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Ações</th>
        </tr>

        <?php 
        if ($resultado) {
            while ($usuario = $resultado->fetch_assoc()) { 
        ?>

            <tr>

                <td>
                    <?= $usuario['id'] ?>
                </td>

                <td>
                    <?= $usuario['nome'] ?>
                </td>

                <td>
                    <?= $usuario['email'] ?>
                </td>

                <td>

                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="excluir" value="<?= $usuario['id'] ?>">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <button type="submit" onclick="return confirm('Tem certeza?')">Excluir</button>
                    </form>

                </td>

            </tr>

        <?php } } ?>

    </table>

</body>

</html>