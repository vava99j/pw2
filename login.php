<?php

$conn = mysqli_connect("localhost", "root", "root", "pet");

if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}

$email = $_POST['email'];
$senha = $_POST['senha'];

// Preparar a consulta para evitar SQL Injection
$stmt = mysqli_prepare($conn, "SELECT * FROM usuarios WHERE email = ? AND senha = ?");
if (!$stmt) {
    die("Falha na preparação da query: " . mysqli_error($conn));
}

// Vincular parâmetros
mysqli_stmt_bind_param($stmt, "ss", $email, $senha);

// Executar
mysqli_stmt_execute($stmt);

// Pegar resultado
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    session_start();
    $_SESSION['email'] = $email;
    header("Location: index.php");
    mysqli_close($conn);
    exit;
} else {
    header("Location: loginERRO.html");
    mysqli_close($conn);
    exit;
}

?>
