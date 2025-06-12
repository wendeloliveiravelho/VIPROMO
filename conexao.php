<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "vipromo";

$conexao = mysqli_connect($host, $usuario, $senha, $banco);

if (!$conexao) {
    die("Erro ao conectar: " . mysqli_connect_error());
}
?>


