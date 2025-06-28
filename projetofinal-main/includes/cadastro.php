<?php

     if(isset($_POST['submit']))
     {
        //print_r('Portal: ' . $_POST['portal']);
        //print_r('<br>');
        //print_r('Nome : ' . $_POST['nome']);
        //print_r('<br>');
        //print_r('Email: ' . $_POST['email']);
        //print_r('<br>');
        //print_r('Senha: ' . $_POST['senha']);

        include_once('config.php');

        $portal = $_POST['portal'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        // $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        $result = mysqli_query($conexao, "INSERT INTO usuarios(portal,nome,email,senha) 
        VALUES('$portal','$nome','$email','$senha')");

        header('Location: index.php');
     }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro no Portal Educacional</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/cadastro.css">
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1><i class="fas fa-user-plus"></i> Cadastro no Portal</h1>
            <p>Preencha os campos abaixo para criar sua conta</p>
        </div>
        <div class="login-body">
            <form action="cadastro.php" method="POST">
                <fieldset style="border: 2px solid #3b82f6; border-radius: 10px; padding: 20px; margin: 0;">
                    <legend style="font-weight: 600; color: #1d4ed8; padding: 0 10px;">Formulário de Cadastro</legend>
            
                    <div class="form-group">
                        <label for="portal" class="form-label">Selecione o Portal:</label>
                        <select id="portal" name="portal" class="form-control" required>
                            <option value="">-- Selecione o portal --</option>
                            <option value="aluno">Portal do Aluno</option>
                            <option value="professor">Portal do Professor</option>
                        </select>
                    </div>
            
                    <div class="form-group">
                        <label for="nome" class="form-label">Nome completo:</label>
                        <input type="text" name="nome" id="nome" class="form-control" required>
                    </div>
            
                    <div class="form-group">
                        <label for="email" class="form-label">Email institucional:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="email" id="email" class="form-control" placeholder="seu.email@escola.com" required>
                        </div>
                    </div>
            
                    <div class="form-group">
                        <label for="senha" class="form-label">Senha:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="senha" id="senha" class="form-control" placeholder="Digite sua senha" required>
                        </div>
                    </div>
            
                    <div class="form-group">
                        <input type="submit" name="submit" id="submit" value="Cadastrar" class="btn btn-primary">
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</body>
</html>
