<?php
session_start();
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "pet";

$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

if (!$conexao) {
    die("Falha na conexão: " . mysqli_connect_error());
}

// Usa o email da sessão para buscar os dados do usuário logado
$email = $_SESSION['email'] ?? '';

$nome = '';
$telefone = '';

if ($email) {
    $sql = "SELECT nome, telefone FROM usuarios WHERE email = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $nome, $telefone);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
}

mysqli_close($conexao);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Meu Perfil</title>
    <style>
        body {
            background: #f7f3ef;
            color: #3e2723;
            font-family: Arial, sans-serif;
            padding-top: 80px;
        }
        .container {
            background: #fff;
            max-width: 400px;
            margin: 40px auto 0 auto;
            padding: 32px 28px 24px 28px;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(101,67,33,0.08);
            display: flex;
            flex-direction: column;
            align-items: stretch;
        }
        h1 {
            color: #6d4c23;
            text-align: center;
            margin-bottom: 24px;
        }
        .info-label {
            font-weight: bold;
            color: #6d4c23;
            margin-top: 12px;
        }
        .info-value {
            margin-bottom: 10px;
        }
        #btn-sair {
            background: #6d4c23;
            color: #fff;
            border: none;
            padding: 10px 0;
            border-radius: 6px;
            font-size: 1.1rem;
            font-weight: bold;
            margin-top: 24px;
            cursor: pointer;
            transition: background 0.2s;
        }
        #btn-sair:hover {
            background: #3e2723;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Meu Perfil</h1>
        <div>
            <div class="info-label">Nome:</div>
            <div class="info-value"><?= htmlspecialchars($nome) ?></div>
            <div class="info-label">Email:</div>
            <div class="info-value"><?= htmlspecialchars($email) ?></div>
            <div class="info-label">Telefone:</div>
            <div class="info-value"><?= htmlspecialchars($telefone) ?></div>
        </div>
        <form method="post" action="logout.php">
            <button id="btn-sair" type="submit">Sair</button>
        </form>
    </div>
    <footer>
        <p>&copy; 2025 Adoção de Animais</p>
    </footer>
</body>
</html>