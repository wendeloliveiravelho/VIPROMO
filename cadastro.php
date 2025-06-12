<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Cadastro de Usuário</title>
<style>
  body {
    font-family: Arial, sans-serif;
    background-color: gray;
    margin: 0; padding: 0;
  }
  .container {
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
  }
  h2 {
    text-align: center;
    color: gray;
  }
  .form-group {
    margin-bottom: 20px;
  }
  label {
    display: block;
    margin-bottom: 8px;
    font-size: 14px;
    color: gray;
  }
  input[type=text], input[type=email], input[type=password], input[type=tel], input[type=date] {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 16px;
    box-sizing: border-box;
  }
  button {
    width: 100%;
    padding: 15px;
    background-color: green;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
  }
  button:hover {
    background-color: darkgreen;
  }
</style>
</head>
<body>
<div class="container">
  <h2>Cadastro de Usuário</h2>
  <form action="processa_cadastro.php" method="POST">
    <div class="form-group">
      <label for="nome">Nome Completo:</label>
      <input type="text" id="nome" name="nome" required placeholder="Digite seu nome completo">
    </div>
    <div class="form-group">
      <label for="email">E-mail:</label>
      <input type="email" id="email" name="email" required placeholder="Digite seu e-mail">
    </div>
    <div class="form-group">
      <label for="telefone">Telefone:</label>
      <input type="tel" id="telefone" name="telefone" placeholder="Digite seu telefone">
    </div>
    <div class="form-group">
      <label for="data_nascimento">Data de Nascimento:</label>
      <input type="date" id="data_nascimento" name="data_nascimento">
    </div>
    <div class="form-group">
      <label for="senha">Senha:</label>
      <input type="password" id="senha" name="senha" required placeholder="Digite sua senha">
    </div>
    <button type="submit">Cadastrar</button>
  </form>
</div>
</body>
</html>
