<?php

session_start();

// Verifica se o usuário está logado, se não estiver, redireciona para a página de login
if (!isset($_SESSION['matricula'])) {
    header('Location: index.html'); // Redireciona para a página de login
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro do Ponto</title>
    <link rel="stylesheet" href="styles-telaponto.css">
</head>
<body>
    <h2>Confira os dados antes de Registrar seu ponto.</h2>

    <p>Matrícula: <?php echo $_SESSION['matricula']; ?></p>
    <p>Nome: <?php echo $_SESSION['nome']; ?></p>
    <p>Data Nascimento: <?php echo $_SESSION['data_nascimento']; ?></p>
    <p>Setor: <?php echo $_SESSION['setor']; ?></p>

    <form action="registrar_ponto.php" method="post">
        <input type="hidden" name="matricula" value="<?php echo $_SESSION['matricula']; ?>">
        <input type="submit" value="Registrar Ponto">
    </form>

    <a href="logout.php">Logout</a>
</body>
</html>

