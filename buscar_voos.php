<?php
include 'conexao.php';

$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';
$departure = $_GET['departure'] ?? '';

if ($from && $to && $departure) {
    $stmt = $conn->prepare("SELECT * FROM voos WHERE origem = ? AND destino = ? AND data_partida = ?");
    $stmt->bind_param("sss", $from, $to, $departure);
    $stmt->execute();
    $result = $stmt->get_result();
    $voos = [];

    while ($row = $result->fetch_assoc()) {
        $voos[] = $row;
    }

    echo json_encode($voos);
} else {
    echo json_encode([]);
}
?>
