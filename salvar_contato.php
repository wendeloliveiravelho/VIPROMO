<?php

$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "vipromo";

$conn = new mysqli($host, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$nome = $_POST['nome'];
$email = $_POST['email'];
$assunto = $_POST['assunto'] ?? '';
$mensagem = $_POST['mensagem'];

$sql = "INSERT INTO mensagens_contato (nome, email, assunto, mensagem) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $nome, $email, $assunto, $mensagem);

if ($stmt->execute()) {
    echo "<script>alert('Mensagem enviada com sucesso!'); window.location.href='index.php';</script>";
} else {
    echo "Erro ao salvar mensagem: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
