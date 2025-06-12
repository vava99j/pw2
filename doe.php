<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit;
} else if (!isset($_SESSION['email'])) {
    header("Location: cadastro.html");
    exit;
} else if (!isset($_SESSION['email'])) {
    header("Location: loginERRO.html");
    exit;
} else if (!isset($_SESSION['email'])) {
    header("Location: cadastroERRO.html");
    exit;
}
?> 

<?php

$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "pet";

$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);


if (!$conexao) {
    die("Falha na conexão: " . mysqli_connect_error());
}




$nome_pet = $_POST['nome_pet'];
$descriçao = $_POST['descriçao'];
$foto_pet = null;
if (isset($_FILES['foto_pet']) && $_FILES['foto_pet']['error'] == 0) {
    $foto_pet = addslashes(file_get_contents($_FILES['foto_pet']['tmp_name']));
}


$sql = "INSERT INTO animal (nome_pet, descriçao, foto_pet) VALUES ('$nome_pet', '$descriçao', '$foto_pet')";

if (mysqli_query($conexao, $sql)) {
    header("Location: index.php");
    exit;
} else {
    echo "Erro: " . mysqli_error($conexao);
}


mysqli_close($conexao);
?>