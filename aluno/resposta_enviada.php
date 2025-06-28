<?php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['email'])) {
    header('Location: ../index.php');
    exit();
}

$email = $_SESSION['email'];
$atividade = isset($_POST['atividade']) ? (int)$_POST['atividade'] : 0;
$resposta_texto = $_POST['resposta_texto'] ?? '';
$marcar_como_entregue = isset($_POST['somente_marcar']);

$arquivo = '';

// Se não for apenas marcar e enviou arquivo
if (!$marcar_como_entregue && !empty($_FILES['arquivo']['name'])) {
    $uploadDir = '../uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $arquivoNome = time() . '_' . basename($_FILES['arquivo']['name']);
    $arquivoCaminho = $uploadDir . $arquivoNome;

    if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $arquivoCaminho)) {
        $arquivo = 'uploads/' . $arquivoNome;
    } else {
        echo "Erro ao fazer upload do arquivo.";
        exit();
    }
}

$stmt = $conexao->prepare("INSERT INTO resposta (atividade, email, resposta_texto, arquivo) VALUES (?, ?, ?, ?)");
if (!$stmt) {
    die("Erro na preparação da query: " . $conexao->error);
}
$stmt->bind_param("isss", $atividade, $email, $resposta_texto, $arquivo);

if ($stmt->execute()) {
    header('Location: dashboard.php'); // Redireciona para atualizar a lista
    exit();
} else {
    echo "Erro ao enviar resposta: " . $stmt->error;
}

$stmt->close();
?>
