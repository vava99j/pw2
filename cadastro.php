<?php
// Conexão com o banco
$servidor = "localhost";
$usuario = "root";
$senha = "root";
$banco = "pet";

$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);
if (!$conexao) {
    die("Falha na conexão: " . mysqli_connect_error());
}

$email = $_POST['email'] ?? '';
$nome = $_POST['nome'] ?? '';
$senha = $_POST['senha'] ?? '';

// Verifica se o email já existe
$sql_verifica = "SELECT id FROM usuarios WHERE email = ?";
$stmt = mysqli_prepare($conexao, $sql_verifica);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    // Email já cadastrado
    echo "Este email já está cadastrado. Você será redirecionado para o login em 3 segundos.";
    mysqli_stmt_close($stmt);
    mysqli_close($conexao);
    header("refresh:0.1;url=login.html"); // redireciona após 3 segundos
    exit;
}
mysqli_stmt_close($stmt);

// Se não existe, insere o usuário
$sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "sss", $nome, $email, $senha);
$sucesso = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
mysqli_close($conexao);

if ($sucesso) {
    echo "Cadastro realizado com sucesso! Você será redirecionado para o login.";
    header("refresh:3;url=login.html");
    exit;
} else {
    echo "Erro ao cadastrar usuário.";
}
?>
