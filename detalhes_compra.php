<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    die("Você precisa estar logado.");
}

$usuario_id = $_SESSION['usuario_id'];

$mysqli = new mysqli('localhost', 'root', '', 'vipromo');
if ($mysqli->connect_error) {
    die("Erro de conexão: " . $mysqli->connect_error);
}

$voo_id = isset($_GET['voo_id']) ? (int)$_GET['voo_id'] : 0;
if ($voo_id <= 0) {
    die("Voo não informado corretamente.");
}

$seats = isset($_GET['seats']) ? explode(',', $_GET['seats']) : [];
$price_per_seat = 299.00;
$total_price = count($seats) * $price_per_seat;

$erro = '';
$exibir_pix_qr = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $seats = explode(',', $_POST['seats_hidden']);
    $metodo = $_POST['metodo'];
    $qr_code_id = $_POST['qr_code_id'] ?? '';
    $confirmar_pix = isset($_POST['confirmar_pix']);

    $nome = trim($_POST['nome'] ?? '');
    $cartao = preg_replace('/\D/', '', trim($_POST['cartao'] ?? ''));
    $validade = trim($_POST['validade'] ?? '');
    $cvv = trim($_POST['cvv'] ?? '');

    if ($metodo === 'cartao_credito' || $metodo === 'cartao_debito') {
        if (empty($nome) || empty($cartao) || empty($validade) || empty($cvv)) {
            $erro = 'Por favor, preencha todos os dados do cartão.';
        } elseif (!preg_match('/^\d{16}$/', $cartao)) {
            $erro = 'Número do cartão inválido.';
        } elseif (!preg_match('/^\d{3}$/', $cvv)) {
            $erro = 'CVV inválido.';
        }
    }

    if (empty($erro)) {
        $ja_ocupado = false;
        $ocupados = [];
        foreach ($seats as $s) {
            $s = $mysqli->real_escape_string($s);
            $check = $mysqli->query("SELECT id FROM assentos_reservados WHERE assento = '$s' AND voo_id = $voo_id");
            if ($check->num_rows > 0) {
                $ja_ocupado = true;
                $ocupados[] = $s;
            }
        }

        if ($ja_ocupado) {
            $erro = "Os seguintes assentos já foram reservados: " . implode(', ', $ocupados);
        } else {
            
            if ($metodo === 'pix' && !$confirmar_pix) {
                $exibir_pix_qr = true;
                $qr_code_id = 'vipromo_pix_' . rand(100000, 999999); 
            } else {
                $mysqli->begin_transaction();

                try {
                    foreach ($seats as $s) {
                        $s = $mysqli->real_escape_string($s);
                        $mysqli->query("INSERT INTO assentos_reservados (assento, usuario_id, voo_id) VALUES ('$s', $usuario_id, $voo_id)");
                    }

                    $valor = count($seats) * $price_per_seat;
                    $stmt = $mysqli->prepare("INSERT INTO pagamentos (usuario_id, valor, metodo, data_pagamento) VALUES (?, ?, ?, NOW())");
                    $stmt->bind_param("ids", $usuario_id, $valor, $metodo);
                    $stmt->execute();

                    $mysqli->commit();

                    echo "<h1>Compra Confirmada!</h1>";
                    echo "<p>Sua compra dos assentos <strong>" . implode(', ', $seats) . "</strong> foi realizada com sucesso.</p>";
                    echo "<p>Valor total: <strong>R$ " . number_format($valor, 2, ',', '.') . "</strong></p>";
                    echo "<p>Método escolhido: <strong>" . ucfirst(str_replace('_', ' ', $metodo)) . "</strong></p>";
                    echo '<p><a href="index.php">Voltar para o Início</a></p>';
                  exit;
                } catch (Exception $e) {
                    $mysqli->rollback();
                    echo "<p class='error'>Erro ao processar a compra: " . $e->getMessage() . "</p>";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Pagamento - VIPROMO</title>
<style>
    body { font-family: Arial; padding: 20px; background: #f0f0f0; }
    form { max-width: 400px; margin: auto; background: white; padding: 20px; border-radius: 10px; }
    input, select { width: 100%; padding: 10px; margin: 10px 0; }
    button { padding: 10px; width: 100%; background: blue; color: white; border: none; }
    .error { color: red; }
</style>
</head>
<body>

<h2>Pagamento - VIPROMO</h2>
<p>Assentos selecionados: <?= implode(', ', $seats) ?></p>
<p>Total: R$ <?= number_format($total_price, 2, ',', '.') ?></p>

<?php if (!empty($erro)): ?>
    <p class="error"><?= $erro ?></p>
<?php endif; ?>

<?php if ($exibir_pix_qr): ?>
    <h3>Escaneie o QR Code abaixo para pagar via PIX:</h3>
    <div style="text-align:center;">
        <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?= htmlspecialchars($qr_code_id) ?>&size=200x200">
    </div>
    <form method="post">
        <input type="hidden" name="seats_hidden" value="<?= htmlspecialchars(implode(',', $seats)) ?>">
        <input type="hidden" name="metodo" value="pix">
        <input type="hidden" name="qr_code_id" value="<?= htmlspecialchars($qr_code_id) ?>">
        <input type="hidden" name="confirmar_pix" value="1">
        <button type="submit">Confirmar pagamento PIX</button>
    </form>
<?php else: ?>

<form method="post">
    <input type="hidden" name="seats_hidden" value="<?= htmlspecialchars(implode(',', $seats)) ?>">

    <label for="metodo">Forma de pagamento:</label>
    <select name="metodo" id="metodo" required>
        <option value="cartao_credito">Cartão de crédito</option>
        <option value="cartao_debito">Cartão de débito</option>
        <option value="pix">PIX</option>
    </select>

    <div id="cartaoCampos">
        <input type="text" name="nome" placeholder="Nome no cartão">
        <input type="text" name="cartao" placeholder="Número do cartão (16 dígitos)" maxlength="19">
        <input type="month" name="validade">
        <input type="text" name="cvv" placeholder="CVV (3 dígitos)" maxlength="3">
    </div>

    <button type="submit">Pagar</button>
</form>

<script>
    const metodo = document.getElementById('metodo');
    const cartaoCampos = document.getElementById('cartaoCampos');

    function atualizarCampos() {
        cartaoCampos.style.display = metodo.value === 'pix' ? 'none' : 'block';
    }

    metodo.addEventListener('change', atualizarCampos);
    window.onload = atualizarCampos;
</script>

<?php endif; ?>

</body>
</html>
