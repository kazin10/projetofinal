<?php
require '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_aluno = $_POST['id_aluno'];
    $data = $_POST['data'];
    $presente = $_POST['presente'] === '1' ? 1 : 0;

    $stmt = $conexao->prepare("INSERT INTO frequencias (id_aluno, data, presente) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $id_aluno, $data, $presente);

    if ($stmt->execute()) {
        echo "Frequência registrada com sucesso!";
    } else {
        echo "Erro ao registrar: " . $stmt->error;
    }

    $stmt->close();
    $conexao->close();
}
?>
