<?php
session_start();
include_once('config.php');

if (isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha']) && !empty($_POST['portal'])) {
    $email  = $_POST['email'];
    $senha  = $_POST['senha'];
    $portalSelecionado = $_POST['portal'];

    // Consulta preparada para evitar SQL Injection
    $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows < 1) {
        header('Location: index.php?erro=login');
        exit();
    }

    $usuario = $result->fetch_assoc();
    
    // Aqui você deve validar a senha corretamente (exemplo abaixo usando texto puro)
    // Recomendo usar password_hash e password_verify, mas se não estiver usando, faça assim:
    if ($usuario['senha'] !== $senha) {
        header('Location: index.php?erro=login');
        exit();
    }

    // Verifica se o portal bate
    if ($usuario['portal'] !== $portalSelecionado) {
        header('Location: index.php?erro=portal_incorreto');
        exit();
    }

    // Login válido: armazene o email e portal na sessão
    $_SESSION['email'] = $usuario['email'];
    $_SESSION['portal'] = $usuario['portal'];
    $_SESSION['nome'] = $usuario['nome'];

    // Redireciona para o dashboard correto
    if ($usuario['portal'] === 'professor') {
        header('Location: ../professor/dashboard.php');
    } else {
        header('Location: ../aluno/dashboard.php');
    }
    exit();

} else {
    header('Location: index.php?erro=dados');
    exit();
}
?>
