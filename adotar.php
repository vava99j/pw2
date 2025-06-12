<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "pet";

$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

if (!$conexao) {
    die("Falha na conexão: " . mysqli_connect_error());
}

$id_animal = isset($_GET['id_animal']) ? intval($_GET['id_animal']) : 0;

$sql = "SELECT 
            animal.nome_pet, animal.tipo, animal.idade, animal.descriçao, animal.foto_pet,
            usuarios.nome AS dono_nome, usuarios.email, usuarios.telefone
        FROM animal
        INNER JOIN usuarios ON animal.id_usuario = usuarios.id
        WHERE animal.id_animal = $id_animal
        LIMIT 1";
$result = mysqli_query($conexao, $sql);
$animal = mysqli_fetch_assoc($result);

mysqli_close($conexao);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adotar Animal</title>
    <link rel="stylesheet" href="style.css">
    <style>
      
    </style>
</head>
<body>
    <div class="container">
        <h1>Ficha do Animal para Adoção</h1>
        <?php if ($animal): ?>
        <div>
            <div class="info-label">Nome do animal:</div>
            <div class="info-value"><?= htmlspecialchars($animal['nome_pet']) ?></div>
            <div class="info-label">Tipo:</div>
            <div class="info-value"><?= htmlspecialchars($animal['tipo']) ?></div>
            <div class="info-label">Idade:</div>
            <div class="info-value"><?= htmlspecialchars($animal['idade']) ?></div>
            <div class="info-label">Descrição:</div>
            <div class="info-value"><?= nl2br(htmlspecialchars($animal['descriçao'])) ?></div>
            <?php if ($animal['foto_pet']): ?>
                <img class="animal-foto" src="data:image/jpeg;base64,<?= base64_encode($animal['foto_pet']) ?>" alt="Foto do animal">
            <?php endif; ?>
        </div>
        <hr>
        <h2>Informações do responsável</h2>
        <div>
            <div class="info-label">Nome do responsável:</div>
            <div class="info-value"><?= htmlspecialchars($animal['dono_nome']) ?></div>
            <div class="info-label">Email:</div>
            <div class="info-value"><?= htmlspecialchars($animal['email']) ?></div>
            <div class="info-label">Telefone:</div>
            <div class="info-value"><?= htmlspecialchars($animal['telefone']) ?></div>
        </div>
        <?php else: ?>
            <p>Animal não encontrado.</p>
        <?php endif; ?>
    </div>
  
     <footer>
        <p>&copy; 2025 Adoção de Animais</p>
    </footer>
</body>
</html>