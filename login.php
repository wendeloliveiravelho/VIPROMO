<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mysqli = new mysqli('localhost', 'root', '', 'vipromo');
    if ($mysqli->connect_error) {
        die("Erro de conexão: " . $mysqli->connect_error);
    }
    
    $email = $mysqli->real_escape_string($_POST['email']);
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = '$email' LIMIT 1";
    $result = $mysqli->query($sql);

    if ($result && $result->num_rows === 1) {
        $usuario = $result->fetch_assoc();

        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
          header('Location: index.php');

            exit;
        } else {
            $erro = "Senha incorreta.";
        }
    } else {
        $erro = "Usuário não encontrado.";
    }
    $mysqli->close();
}
?>

<h2>Login</h2>
<?php if (!empty($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
<form method="POST" action="">
    E-mail: <input type="email" name="email" required><br>
    Senha: <input type="password" name="senha" required><br>
    <button type="submit">Entrar</button>
</form>
<a href="cadastro.php">Cadastrar</a>


