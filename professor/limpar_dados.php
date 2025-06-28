<?php
session_start();
require '../includes/config.php';

// Segurança: só usuários logados podem executar
if (!isset($_SESSION['email'])) {
    header("Location: ../includes/index.php");
    exit();
}

// Desativa verificação de chave estrangeira
$conexao->query("SET FOREIGN_KEY_CHECKS = 0");

// Limpa as tabelas
$conexao->query("TRUNCATE TABLE notas");
$conexao->query("TRUNCATE TABLE atividades");
$conexao->query("TRUNCATE TABLE frequencias");

// Reativa verificação de chave estrangeira
$conexao->query("SET FOREIGN_KEY_CHECKS = 1");

echo "<script>
    alert('✅ Dados apagados com sucesso!');
    window.location.href = '../professor/dashboard.php'; // Altere se necessário
</script>";
?>
