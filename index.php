<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>VIPROMO - Passagens Aéreas</title>
  <style>

    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: red;
    }

    .login-container {
      background-color: white;
      padding: 30px;
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
      width: 300px;
      text-align: center;
      position: fixed;
      top: 50%;
      right: 20px;
      transform: translateY(-50%);
      display: none;
    }

    h2 {
      margin-bottom: 20px;
    }

    input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    button {
      width: 100%;
      padding: 10px;
      background-color: blue;
      color: white;
      border: none;
      cursor: pointer;
      border-radius: 5px;
    }

    button:hover {
      background-color: blue;
    }

    .error {
      color: red;
      display: none;
    }

    header {
      background-color: blue;
      color: white;
      padding: 20px;
      text-align: center;
    }

    nav {
      background-color: black;
      padding: 10px 0;
      text-align: center;
    }

    nav a {
      color: white;
      margin: 0 20px;
      text-decoration: none;
      font-size: 16px;
    }

    nav a:hover {
      background-color: gray;
      padding: 5px 15px;
      border-radius: 5px;
    }

    .banner {
      background-image: url('https://example.com/banner-aviation.jpg');
      background-size: cover;
      background-position: center;
      height: 300px;
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
      text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
    }

    .banner h2 {
      font-size: 3rem;
    }

    .search-section {
      background-color: white;
      padding: 20px;
      text-align: center;
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .search-section input,
    .search-section select {
      padding: 10px;
      margin: 10px;
      width: 200px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .search-section button {
      padding: 10px 20px;
      background-color: blue;
      color: white;
      border: none;
      cursor: pointer;
      border-radius: 5px;
    }

    .search-section button:hover {
      background-color: blue;
    }

    .offers {
      padding: 40px;
      text-align: center;
      background-color: gray;
    }

    .offers h3 {
      margin-bottom: 30px;
    }

    .offer-card {
      display: inline-block;
      background-color: white;
      width: 250px;
      margin: 15px;
      padding: 15px;
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
    }

    .offer-card img {
      width: 100%;
      border-radius: 10px;
    }

    .offer-card h4 {
      margin: 10px 0;
    }

    .results {
      padding: 40px;
      text-align: center;
      background-color: white;
      display: none; /* Oculto por padrão */
    }

    .result-card {
      background-color: gray;
      padding: 15px;
      margin: 10px;
      border-radius: 10px;
      box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
    }

    .about {
      padding: 40px;
      text-align: center;
      background-color: white;
    }

    .about h3 {
      margin-bottom: 20px;
    }

    .contact {
      padding: 40px;
      text-align: center;
      background-color: red;
    }

    .contact h3 {
      margin-bottom: 20px;
    }

    .contact-form input,
    .contact-form textarea {
      width: 300px;
      padding: 10px;
      margin: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .contact-form button {
      padding: 10px 20px;
      background-color: blue;
      color: white;
      border: none;
      cursor: pointer;
      border-radius: 5px;
    }

    .contact-form button:hover {
      background-color: blue;
    }

    footer {
      background-color: gray;
      color: white;
      padding: 20px;
      text-align: center;
    }

    footer p,
    footer a {
      color: white;
      text-decoration: none;
    }

    footer a:hover {
      text-decoration: underline;
    }

    @media (max-width: 768px) {
      .banner h2 {
        font-size: 2rem;
      }

      .search-section input,
      .search-section select {
        width: 100%;
        margin: 5px 0;
      }

      .offer-card {
        width: 90%;
      }

      .result-card {
        width: 90%;
        margin: 10px auto;
      }

      .contact-form input,
      .contact-form textarea {
        width: 90%;
      }

      .login-container {
        width: 90%;
        right: 10px;
      }
    }
  </style>
</head>
<body>

<?php if (isset($_SESSION['usuario_id'])): ?>
  <p>Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>! <a href="logout.php">Sair</a></p>
<?php else: ?>
  <p><a href="login.php">Login</a> | <a href="cadastro.php">Cadastrar</a></p>

<?php endif; ?>

<header>
  <h1>VIPROMO - Passagens Aéreas</h1>
</header>

<nav>
  <a href="#home">Início</a>
  <a href="#search">Buscar Voos</a>
  <a href="#offers">Ofertas</a>
  <a href="#about">Sobre Nós</a>
  <a href="#contact">Contato</a>
</nav>

<div class="banner" id="home">
  <h2>VIPROMO, Viaje com as Melhores Ofertas</h2>
</div>

<section class="search-section" id="search">
  <h3>Pesquise seu Voo</h3>
 <form method="POST">
    <select name="from" id="from" required>
      <option value="">Origem</option>
      <option value="São Paulo">São Paulo</option>
      <option value="Rio de Janeiro">Rio de Janeiro</option>
      <option value="Brasília">Brasília</option>
      <option value="Porto Alegre">Porto Alegre</option>
      <option value="Florianópolis">Florianópolis</option>
      <option value="Belo Horizonte">Belo Horizonte</option>
      <option value="Amazonas">Amazonas</option>
      <option value="Alagoas">Alagoas</option>
      <option value="Natal">Natal</option>
      <option value="Curitiba">Curitiba</option>
      <option value="Mato Grosso">Mato Grosso</option>
      <option value="Salvador">Salvador</option>
    </select>

    <select name="to" id="to" required>
      <option value="">Destino</option>
      <option value="São Paulo">São Paulo</option>
      <option value="Rio de Janeiro">Rio de Janeiro</option>
      <option value="Brasília">Brasília</option>
      <option value="Porto Alegre">Porto Alegre</option>
      <option value="Florianópolis">Florianópolis</option>
      <option value="Belo Horizonte">Belo Horizonte</option>
      <option value="Amazonas">Amazonas</option>
      <option value="Alagoas">Alagoas</option>
      <option value="Natal">Natal</option>
      <option value="Curitiba">Curitiba</option>
      <option value="Mato Grosso">Mato Grosso</option>
      <option value="Salvador">Salvador</option>
    </select>

    <input type="date" name="departure" id="departure" required>
    <button type="submit">Buscar</button>
  </form>
</section>


<?php
$resultados = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include 'conexao.php';

  $origem = mysqli_real_escape_string($conexao, $_POST['from']);
  $destino = mysqli_real_escape_string($conexao, $_POST['to']);
  $data_ida = mysqli_real_escape_string($conexao, $_POST['departure']);

  $sql = "SELECT * FROM voos WHERE origem = '$origem' AND destino = '$destino' AND data_partida >= '$data_ida'";

  $result = mysqli_query($conexao, $sql);

  while ($row = mysqli_fetch_assoc($result)) {
    $resultados[] = $row;
  }

  mysqli_close($conexao);
}
?>

<section class="results" id="results" style="<?= !empty($resultados) ? 'display: block;' : 'display: none;' ?>">
  <h3>Resultados da Busca</h3>
  <div id="resultContainer">
    <?php if (!empty($resultados)): ?>
      <?php foreach ($resultados as $voo): ?>
        <div class="result-card">
          <h4><?= htmlspecialchars($voo['origem']) ?> para <?= htmlspecialchars($voo['destino']) ?></h4>
          <p>Data de Ida: <?= date('d/m/Y', strtotime($voo['data_partida'])) ?></p>
          <p>Preço: R$ <?= number_format($voo['preco'], 2, ',', '.') ?></p>
          <a href="escolha_assentos.php?voo_id=<?= $voo['id'] ?>">Escolher assentos</a>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Nenhum voo encontrado com esses critérios.</p>
    <?php endif; ?>
  </div>
</section>


<section class="offers" id="offers">
  <h3>Ofertas Especiais</h3>
  <?php
    include 'conexao.php';

    $sql = "SELECT * FROM voos LIMIT 4";
    $result = mysqli_query($conexao, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="offer-card">';
        echo '<img src="' . htmlspecialchars($row['imagem']) . '" alt="Imagem do voo">';
        echo '<h4>' . htmlspecialchars($row['origem']) . ' a ' . htmlspecialchars($row['destino']) . '</h4>';
        echo '<p>R$ ' . number_format($row['preco'], 2, ',', '.') . '</p>';
        echo '<a href="escolha_assentos.php?voo_id=' . $row['id'] . '">Escolher assento</a>';
        echo '<p>Data de partida: ' . date('d/m/Y', strtotime($row['data_partida'])) . '</p>';

        echo '</div>';
    }

    mysqli_close($conexao);
  ?>
</section>


<section class="about" id="about">
  <h3>Sobre Nós</h3>
  <p>Somos uma plataforma dedicada a oferecer as melhores ofertas de passagens aéreas para você viajar pelo Brasil e pelo mundo.</p>
</section>

<section class="contact" id="contact">
  <h3>Contato</h3>
  <form class="contact-form" action="salvar_contato.php" method="post">
    <input type="text" name="nome" placeholder="Seu Nome" required>
    <input type="email" name="email" placeholder="Seu Email" required>
    <input type="text" name="assunto" placeholder="Assunto (opcional)">
    <textarea name="mensagem" placeholder="Sua Mensagem" required></textarea>
    <button type="submit">Enviar</button>
  </form>
</section>

<footer>
  <p>&copy; 2025 VIPROMO. Todos os direitos reservados.</p>
  <p><a href="#privacy">Política de Privacidade</a></p>
</footer>

<div class="login-container" id="login">
  <h2>Login</h2>
  <form id="loginForm">
    <input type="text" placeholder="Usuário" required>
    <input type="password" placeholder="Senha" required>
    <button type="submit">Entrar</button>
    <p class="error" id="errorMessage">Usuário ou senha incorretos!</p>
  </form>
</div>

<script>

  document.getElementById('searchForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const from = document.getElementById('from').value;
    const to = document.getElementById('to').value;
    const departure = document.getElementById('departure').value;

    const resultsContainer = document.getElementById('resultContainer');
    const voo_id = Math.floor(Math.random() * 1000); 

    resultsContainer.innerHTML = `
      <div class="result-card">
          <h4>${from} para ${to}</h4>
          <p>Data de Ida: ${departure}</p>
          <p>Preço: R$ 299,00</p>
          <a href="escolha_assentos.php?voo_id=${voo_id}">Escolher assentos</a>
      </div>
    `;

    document.getElementById('results').style.display = 'block';
  });
</script>

</body>
</html>
