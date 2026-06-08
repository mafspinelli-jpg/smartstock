<?php
session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . "/brownie/DAL/usuario.php";

if (isset($_POST['entrar'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $usuarioDAL = new \DAL\Usuario();
    $usuarioLogado = $usuarioDAL->Login($email, $senha);

    if ($usuarioLogado !== null) {
        $_SESSION['usuario'] = $usuarioLogado->getEmail();
        header("Location: index.php");
        exit();
    } else {
        $erro = "E-mail ou senha inválidos no banco de dados!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Browni-e</title>
</head>
<body>

    <h2>Acesso ao Sistema Browni-e</h2>

    <?php if (isset($erro)) { echo "<p style='color: red;'>$erro</p>"; } ?>

    <form method="POST">
        <label>E-mail:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Senha:</label><br>
        <input type="password" name="senha" required><br><br>

        <button name="entrar">Entrar no Sistema</button>
    </form>

</body>
</html>