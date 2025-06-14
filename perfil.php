<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit;
}

$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "pet";

$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);
if (!$conexao) {
    die("Falha na conexão: " . mysqli_connect_error());
}

// Atualiza foto de perfil se enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto_user']) && $_FILES['foto_user']['error'] === 0) {
    $foto_user = file_get_contents($_FILES['foto_user']['tmp_name']);
    $email = $_SESSION['email'];
    $sql = "UPDATE usuarios SET foto_user = ? WHERE email = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "bs", $foto_user, $email);
    mysqli_stmt_send_long_data($stmt, 0, $foto_user);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Busca dados do usuário logado
$email = $_SESSION['email'];
$sql = "SELECT id, nome, telefone, foto_user FROM usuarios WHERE email = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $id_usuario, $nome, $telefone, $foto_user);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

mysqli_close($conexao);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Meu Perfil</title>
    <link rel="icon" type="image/png" href="fotos/favicon.png">
</head>
<body>
        <header>
        <h1>
            <img src="fotos/Vj_quero_a_palavra_doe-pet_estilizada_com_as_letras__0e2b4ce2-5c4d-4d8a-8401-b20751ebdc5c.png" alt="Doe Pet" style="height:60px;">
        </h1>
        <nav>
            <a href="sobre.php">Sobre</a>
            <a href="index.php">inicio</a>
            <a href="doe.html">doe</a>

        </nav>
    </header> 
    <div class="container">
        <h1>Meu Perfil</h1>
        <div style="display: flex; flex-direction: column; align-items: center;">
            <?php if ($foto_user): ?>
                <img src="data:image/jpeg;base64,<?= base64_encode($foto_user) ?>" alt="Foto de perfil"
                     style="width:120px;height:120px;object-fit:cover;border-radius:8px;margin-bottom:10px;display:block;">
            <?php else: ?>
                <img src="https://via.placeholder.com/120x120?text=Sem+Foto" alt="Sem foto"
                     style="width:120px;height:120px;object-fit:cover;border-radius:8px;margin-bottom:10px;display:block;">
            <?php endif; ?>
            <form method="post" enctype="multipart/form-data" style="margin-bottom:20px;">
                <label for="foto_user">Alterar foto de perfil:</label>
                <input type="file" name="foto_user" id="foto_user" accept="image/*" required>
                <button type="submit">Salvar Foto</button>
            </form>
        </div>
        <div class="info-label">Nome:</div>
        <div class="info-value"><?= htmlspecialchars($nome) ?></div>
        <div class="info-label">Email:</div>
        <div class="info-value"><?= htmlspecialchars($email) ?></div>
        <div class="info-label">Telefone:</div>
        <div class="info-value"><?= htmlspecialchars($telefone) ?></div>
        <form method="post" action="logout.php">
            <button id="btn-sair" type="submit">Sair</button>
        </form>
    </div>
    <footer>
        <p>&copy; doe-pet 2025</p>
    </footer>
</body>
</html>