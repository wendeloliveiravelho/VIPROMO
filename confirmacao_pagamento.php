<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pagamento Confirmado</title>
    <style>
        body {
            font-family: Arial;
            background-color: black;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .box {
            background-color: white;
            max-width: 500px;
            width: 90%;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px gray;
            text-align: center;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="box">
        <h1>✅ Pagamento realizado com sucesso!</h1>
        <p>Obrigado por reservar com a VIPROMO.</p>
        <a href="index.php">Voltar à página inicial</a>
    </div>
</body>
</html>
