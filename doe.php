<?php
session_start();
$usuario_logado = isset($_SESSION['email']);

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



// Garante que só usuários logados possam doar
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

// Busca o id do usuário logado
$email = $_SESSION['email'] ?? '';
$id_usuario = null;
if ($email) {
    $sql = "SELECT id, nome, telefone FROM usuarios WHERE email = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id_usuario, $nome, $telefone);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
}

// Recebe os dados do formulário
$nome_pet = $_POST['nome_pet'] ?? '';
$tipo = $_POST['tipo'] ?? '';
$idade = $_POST['idade'] ?? '';
$descriçao = $_POST['descriçao'] ?? '';
$contato = $_POST['contato'] ?? '';
$cep = $_POST['cep'] ?? '';
$endereço = $_POST['endereço'] ?? '';
$endereco_completo = "CEP: $cep - $endereço";
$foto_pet = null;
if (isset($_FILES['foto_pet']) && $_FILES['foto_pet']['error'] == 0) {
    $foto_pet = file_get_contents($_FILES['foto_pet']['tmp_name']);
}

// Validação simples (você pode melhorar)
if (!$nome_pet || !$tipo || !$idade || !$descriçao || !$foto_pet || !$contato || !$endereço) {
    echo "Preencha todos os campos!";
    mysqli_close($conexao);
    exit;
}

// Insere o animal com endereço e contato
$sql = "INSERT INTO animal (nome_pet, tipo, idade, descriçao, foto_pet, contato, endereço) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "ssissss", $nome_pet, $tipo, $idade, $descriçao, $foto_pet, $contato, $endereco_completo);
$sucesso = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
mysqli_close($conexao);

if ($sucesso) {
    header("Location: index.php");
    exit;
} else {
    echo "Erro ao cadastrar animal.";
}
?>