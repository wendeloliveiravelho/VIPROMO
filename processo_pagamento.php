<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    die("Usuário não logado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli("localhost", "root", "", "vipromo");

    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }

    $usuario_id = $_SESSION['usuario_id'];
    $assentos = isset($_POST['assentos']) ? $_POST['assentos'] : [];

    if (is_array($assentos)) {
        $assentos = implode(',', $assentos);
    } else {
        $assentos = '';
    }

    $usuario_id = $conn->real_escape_string($usuario_id);
    $assentos = $conn->real_escape_string($assentos);

    $sql = "INSERT INTO reservas (usuario_id, assentos) VALUES ('$usuario_id', '$assentos')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Pagamento e reserva confirmados!'); window.location.href='minhas_reservas.php';</script>";
    } else {
        echo "Erro ao processar o pagamento: " . $conn->error;
    }

    $conn->close();
}
?>