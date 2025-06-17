<?php
$servidor = "localhost";
$usuario = "root";
$senha = "root";
$banco = "pet";

$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

if (!$conexao) {
    die("Falha na conexão: " . mysqli_connect_error());
}

// Exclui o animal se solicitado
if (isset($_GET['adotar'])) {
    $id = intval($_GET['adotar']);
    $sql = "DELETE FROM animal WHERE id = $id"; // corrigido de 'id_animal' para 'id'
    mysqli_query($conexao, $sql);
    mysqli_close($conexao);
    header("Location: index.php?status=adotado");
    exit;
}

$id_animal = isset($_GET['id_animal']) ? intval($_GET['id_animal']) : 0;

$animal = null;

if ($id_animal > 0) {
    $sql = "SELECT 
                nome_pet, tipo, idade, descricao, foto_pet, contato, endereco
            FROM animal
            WHERE id = $id_animal
            LIMIT 1"; // corrigido de 'id_animal' para 'id'

    $result = mysqli_query($conexao, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $animal = mysqli_fetch_assoc($result);
    }
}

mysqli_close($conexao);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Adotar Animal</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="icon" type="image/png" href="fotos/favicon.png" />
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

                <div class="info-label">Contato:</div>
                <a href="tel:<?= htmlspecialchars($animal['contato']) ?>">
                    <div class="info-value"><?= htmlspecialchars($animal['contato']) ?></div>
                </a>

                <div class="info-label">Endereço:</div>
                <div class="info-value"><?= htmlspecialchars($animal['endereco']) ?></div>

                <div class="info-label">Idade:</div>
                <div class="info-value"><?= htmlspecialchars($animal['idade']) ?></div>

                <div class="info-label">Descrição:</div>
                <div class="info-value"><?= nl2br(htmlspecialchars($animal['descricao'])) ?></div>

                <?php if (!empty($animal['foto_pet'])): ?>
                    <img class="animal-foto" src="data:image/jpeg;base64,<?= base64_encode($animal['foto_pet']) ?>" alt="Foto do animal" />
                <?php else: ?>
                    <p>Sem foto disponível</p>
                <?php endif; ?>
            </div>

            <button type="button" onclick="confirmarAdocao(<?= $id_animal ?>)">Adotar</button>
        <?php else: ?>
            <p>Animal não encontrado.</p>
        <?php endif; ?>
    </div>

    <script>
        function confirmarAdocao(id_animal) {
            const confirmacao = confirm("Tem certeza que deseja adotar este animal?");
            if (confirmacao) {
                window.location.href = "adotar.php?adotar=" + id_animal;
            }
        }
    </script>

    <footer>
        <p>&copy; doe-pet 2025</p>
    </footer>
</body>
</html>
