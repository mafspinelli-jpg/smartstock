<?php

session_start();

include("config/conexao.php");

if(isset($_POST['entrar'])){

$email = $_POST['email'];

$senha = $_POST['senha'];

$sql = "SELECT * FROM usuarios
WHERE email='$email'
AND senha='$senha'";

$resultado = mysqli_query($conexao,$sql);

if(mysqli_num_rows($resultado) > 0){

$_SESSION['usuario']=$email;

header("Location:index.php");

}else{

echo "Login inválido";

}

}

?>

<form method="POST">

<h2>Login SmartStock</h2>

<input
type="email"
name="email"
placeholder="Digite seu email"
required>

<br><br>

<input
type="password"
name="senha"
placeholder="Digite sua senha"
required>

<br><br>

<button name="entrar">

Entrar

</button>

</form>