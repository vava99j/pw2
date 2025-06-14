<?php
session_start(); // Adicione esta linha no início do arquivo

$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "pet";

$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

if (!$conexao) {
    die("Falha na conexão: " . mysqli_connect_error());
}

$sql = "SELECT id_animal, nome_pet, descriçao, foto_pet FROM animal";
$result = mysqli_query($conexao, $sql);
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoção de Animais</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>
            <img src="fotos/Vj_quero_a_palavra_doe-pet_estilizada_com_as_letras__0e2b4ce2-5c4d-4d8a-8401-b20751ebdc5c.png" alt="Doe Pet" style="height:60px;">
        </h1>
        <nav>
            <a href="#sobre">Sobre</a>
            <?php if (isset($_SESSION['email'])): ?>
                <a href="perfil.php" id="btn-perfil">perfil</a>
                   <a href="doe.html">doe</a>
            <?php else: ?>
                <a href="cadastro.html" id="btn-cadastro">cadastro</a>
                <a href="login.html" id="btn-login">entre</a>
                 <a href="index.php"> login para doar</a>
            <?php endif; ?>
         
        </nav>
    </header>
<br>
<br>
    <section id="animais">
        <h2>Animais Disponíveis</h2>
        <div style="display: flex; flex-wrap: wrap; gap: 20px;">
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <div class="ficha-animal" style="border:1px solid #ccc; padding:16px; width:220px; border-radius:8px; background:#fafafa;">
                    <?php if ($row['foto_pet']): ?>
    <img src="data:image/jpeg;base64,<?= base64_encode($row['foto_pet']) ?>" alt="Foto do animal" style="width:200px; height:200px; object-fit:cover; border-radius:8px;">
<?php else: ?>
    <img src="fotos/sem-foto.jpg" alt="Sem foto" style="width:200px; height:200px; object-fit:cover; border-radius:8px;">
<?php endif; ?>
                    <h3><?php echo htmlspecialchars($row['nome_pet']); ?></h3>
                    <p><?php echo nl2br(htmlspecialchars($row['descriçao'])); ?></p>
                    <a href="adotar.php?id_animal=<?php echo $row['id_animal']; ?>"><button>Adotar</button></a>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <section id="sobre">
        <h2>Sobre Nós</h2>
        <p>Somos uma ONG dedicada a encontrar lares amorosos para animais resgatados.</p>
        <a href="sobre.php">mais sobre</a>
    </section>

    <section id="contato">
        <h2>Contato</h2>
        <p>Email: contato@adocaoanimais.com</p>
        <p>Telefone: (11) 99999-9999</p>
    </section>

    <footer>
        <p>&copy; doe-pet 2025</p>
    </footer>

</body>
</html>
<?php mysqli_close($conexao); ?>
<?php
if (isset($_GET['status']) && $_GET['status'] === 'adotado') {
    echo '<div class="alerta-sucesso" style="margin: 16px auto; max-width: 500px; background: #e0f7fa; color: #00695c; border: 1px solid #4dd0e1; border-radius: 6px; padding: 12px 18px; text-align: center; font-size: 1.1em;">
    Animal adotado com sucesso!
    </div>';
}
?>