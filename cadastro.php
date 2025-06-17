<?php

$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "pet";

$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);


if (!$conexao) {
    die("Falha na conexão: " . mysqli_connect_error());
}


$email = $_POST['email'];
$nome = $_POST['nome'];
$telefone = $_POST['telefone'];
$senha = $_POST['senha'];
$confirmar = $_POST['confirmar_senha'];


if ($senha != $confirmar) {
    echo "As senhas não conferem.";
    exit;
}


$sql = "INSERT INTO usuarios (email, nome, telefone, senha) 
VALUES ('$email', '$nome', '$telefone', '$confirmar')";

if (mysqli_query($conexao, $sql)) {
    header("Location: index.php");
    exit;
 } else {
        echo "Erro: " . mysqli_error($conexao);
    }
    



mysqli_close($conexao);
?>