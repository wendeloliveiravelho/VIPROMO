<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mysqli = new mysqli('localhost', 'root', '', 'vipromo');
    if ($mysqli->connect_error) {
        die("Erro de conexão: " . $mysqli->connect_error);
    }

    $nome = $mysqli->real_escape_string($_POST['nome']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $telefone = $mysqli->real_escape_string($_POST['telefone']);
    $data_nascimento = $mysqli->real_escape_string($_POST['data_nascimento']);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<p style='color:red;'>E-mail já cadastrado. <a href='cadastro.php'>Tentar novamente</a></p>";
    } else {
        $stmt = $mysqli->prepare("INSERT INTO usuarios (nome, email, telefone, data_nascimento, senha) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nome, $email, $telefone, $data_nascimento, $senha);

        if ($stmt->execute()) {
            echo "<p style='color:green;'>Cadastro realizado com sucesso! <a href='login.php'>Clique aqui para fazer login</a></p>";
        } else {
            echo "Erro ao cadastrar: " . $stmt->error;
        }
    }

    $stmt->close();
    $mysqli->close();
} else {
    header("Location: cadastro.php");
    exit;
}
