<?php
session_start();

// Redireciona se não estiver logado
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit;
}

// Conexão com o banco
$servidor = "localhost";
$usuario = "root";
$senha = "root";
$banco = "pet";

$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);
if (!$conexao) {
    die("Falha na conexão: " . mysqli_connect_error());
}

// Dados do usuário logado
$email = $_SESSION['email'] ?? '';
$nome = '';
$telefone = '';
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

// Dados do formulário
$nome_pet = $_POST['nome_pet'] ?? '';
$tipo = $_POST['tipo'] ?? '';
$idade = $_POST['idade'] ?? '';
$descricao = $_POST['descricao'] ?? ''; // variável sem acento
$cep = $_POST['cep'] ?? '';
$endereco = $_POST['endereco'] ?? ''; // variável sem acento
$contato = $_POST['contato'] ?? '';
$endereco_completo = "CEP: $cep - $endereco";

// Foto
$foto_pet = null;
if (isset($_FILES['foto_pet']) && $_FILES['foto_pet']['error'] == 0) {
    $foto_pet = file_get_contents($_FILES['foto_pet']['tmp_name']);
}

// Verificação de campos obrigatórios
if (!$nome_pet || !$tipo || !$idade || !$descricao || !$foto_pet || !$endereco || !$contato) {
    echo "Preencha todos os campos!";
    mysqli_close($conexao);
    exit;
}

// Inserção no banco
$sql = "INSERT INTO animal (nome_pet, tipo, idade, descricao, foto_pet, endereco, contato, id_usuario) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "ssissssi", $nome_pet, $tipo, $idade, $descricao, $foto_pet, $endereco_completo, $contato, $id_usuario);
$sucesso = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
mysqli_close($conexao);

// Redirecionamento
if ($sucesso) {
    header("Location: index.php");
    exit;
} else {
    echo "Erro ao cadastrar animal.";
}
?>
