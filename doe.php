<?php

$servidor = "localhost";
$usuario = "root";
$senha = "root";
$banco = "pet";

$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);


if (!$conexao) {
    die("Falha na conexão: " . mysqli_connect_error());
}



$nome_dono = $_POST['nome_dono'];
$nome_pet = $_POST['nome_pet'];
$descriçao = $_POST['descriçao'];
$foto_pet = $_POST['foto_pet'];


$sql = "INSERT INTO animal (nome_dono , nome_pet, descriçao, foto_pet) 
VALUES ('$nome_dono', '$nome_pet', '$descriçao', '$foto_pet')";

if (mysqli_query($conexao, $sql)) {
    header("Location: index.html");
    exit;
} else {
    echo "Erro: " . mysqli_error($conexao);
}


mysqli_close($conexao);
?>