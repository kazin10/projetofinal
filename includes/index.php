<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="../css/index.css">
  <title>Login institucional</title>
</head>
<body>
  <div class="login-container">
    <div class="login-header">
      <h1>Bem-vindo!</h1>
      <p>Escolha seu portal e faça login</p>
    </div>
    <?php if (isset($_GET['erro'])): ?>
  <div style="background: #fee2e2; color: #b91c1c; padding: 10px; border-radius: 6px; margin-bottom: 15px; text-align: center;">
    <?php
      switch ($_GET['erro']) {
        case 'login':
          echo 'E-mail ou senha inválidos.';
          break;
        case 'portal_incorreto':
          echo 'Tipo de acesso incorreto. Verifique se selecionou "Aluno" ou "Professor" corretamente.';
          break;
        case 'dados':
          echo 'Por favor, preencha todos os campos.';
          break;
      }
    ?>
  </div>
<?php endif; ?>

    <div class="login-body">
      <form action="../includes/verificar.php" method="POST">
        <!-- Tipo de usuário -->
        <div class="form-group">
          <label for="portal" class="form-label">Acessar como:</label>
          <select name="portal" id="portal" class="form-select" required>
            <option value="">Selecione uma opção</option>
            <option value="aluno">Aluno</option>
            <option value="professor">Professor</option>
          </select>
        </div>

        <!-- Nome -->
        <div class="form-group">
          <label for="nome" class="form-label">Nome:</label>
          <input type="text" name="nome" id="nome" class="form-control" required>
        </div>

        <!-- Email -->
        <div class="form-group">
          <label for="email" class="form-label">E-mail:</label>
          <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <!-- Senha -->
        <div class="form-group">
          <label for="senha" class="form-label">Senha:</label>
          <input type="password" name="senha" id="senha" class="form-control" required>
        </div>

        <!-- Botão de login -->
        <div class="form-group">
          <button type="submit" name="submit" class="btn btn-primary">Entrar</button>
        </div>

        <!-- Links -->
        <div class="login-links">
          <a href="../includes/cadastro.php">Criar conta</a>
        </div>
  </div>
      </form>
    </div>
  </div>
</body>
</html>

