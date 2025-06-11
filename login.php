<?php

$conn = mysqli_connect("localhost", "root", "root", "pet");


if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}


$email = $_POST['email'];
$senha = $_POST['senha'];


$sql = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) > 0) {
    header("Location: index.html");
    exit;
} else {
    header("Location: loginERRO.html");
    exit;
}


mysqli_close($conn);
?>