<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    die("Você precisa estar logado.");
}

$mysqli = new mysqli("localhost", "root", "", "vipromo");
if ($mysqli->connect_error) {
    die("Erro de conexão: " . $mysqli->connect_error);
}

$voo_id = isset($_GET['voo_id']) ? intval($_GET['voo_id']) : 0;
if ($voo_id == 0) {
    die("Voo não informado.");
}

$reservados = [];
$sql = "SELECT assento FROM assentos_reservados WHERE voo_id = $voo_id";
$result = $mysqli->query($sql);
while ($row = $result->fetch_assoc()) {
    $reservados[] = $row['assento'];
}

$linhas = 30;
$colunas = ['A', 'B', 'C', 'D'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Escolha de Assentos - VIPROMO</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 800px;
            width: 100%;
        }

        .assento {
            width: 40px;
            height: 40px;
            margin: 5px;
            display: inline-block;
            text-align: center;
            line-height: 40px;
            cursor: pointer;
            border-radius: 5px;
        }

        .livre { background-color: #4CAF50; color: white; }
        .ocupado { background-color: #ccc; color: #666; cursor: not-allowed; }
        .selecionado { background-color: #2196F3; color: white; }

        button {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #2196F3;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #1976D2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Escolha seus assentos</h2>
        <form id="assentoForm" action="detalhes_compra.php" method="GET">
            <div id="assentos">
                <?php
                for ($linha = 1; $linha <= $linhas; $linha++) {
                    foreach ($colunas as $coluna) {
                        $assento = $linha . $coluna;
                        $classe = in_array($assento, $reservados) ? 'ocupado' : 'livre';
                        echo "<div class='assento $classe' data-assento='$assento'>$assento</div>";
                    }
                    echo "<br>";
                }
                ?>
            </div>
            <input type="hidden" name="voo_id" value="<?= $voo_id ?>">
            <input type="hidden" name="seats" id="seatsInput">
            <button type="submit">Continuar para Pagamento</button>
        </form>
    </div>

    <script>
        const assentos = document.querySelectorAll('.assento.livre');
        const seatsInput = document.getElementById('seatsInput');
        let selecionados = [];

        assentos.forEach(el => {
            el.addEventListener('click', () => {
                const assento = el.dataset.assento;
                if (selecionados.includes(assento)) {
                    selecionados = selecionados.filter(a => a !== assento);
                    el.classList.remove('selecionado');
                } else {
                    selecionados.push(assento);
                    el.classList.add('selecionado');
                }
                seatsInput.value = selecionados.join(',');
            });
        });
    </script>
</body>
</html>
