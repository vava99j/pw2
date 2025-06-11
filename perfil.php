<?php
$servidor = "localhost";
$usuario = "root";
$senha = "root";
$banco = "pet";

$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

if (!$conexao) {
    die("Falha na conexão: " . mysqli_connect_error());
}

// Recebe o email via GET ou POST (exemplo: perfil.php?email=teste@teste.com)
$email = $_GET['email'] ?? $_POST['email'] ?? '';

if (!$email) {
    echo json_encode(["erro" => "Email não informado"]);
    exit;
}

$sql = "SELECT nome, telefone FROM usuarios WHERE email = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $nome, $telefone);

if (mysqli_stmt_fetch($stmt)) {
    echo json_encode([
        "nome" => $nome,
        "telefone" => $telefone
    ]);
} else {
    echo json_encode(["erro" => "Usuário não encontrado"]);
}

mysqli_stmt_close($stmt);
mysqli_close($conexao);
?>