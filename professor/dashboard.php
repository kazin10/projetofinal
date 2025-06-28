<?php
session_start();

// Impede cache da página (evita retorno com botão "voltar" após logout)
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Redireciona para login se não estiver autenticado
if (!isset($_SESSION['email']) || !isset($_SESSION['nome'])) {
    header('Location: ../includes/index.php');
    exit();
}

// Nome do usuário logado
$nome = htmlspecialchars($_SESSION['nome']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Portal do Professor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/professor.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
        }
        .modal-content {
            background: white;
            margin: 10% auto;
            padding: 2rem;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            position: relative;
        }
        .close {
            position: absolute;
            top: 0.5rem;
            right: 1rem;
            font-size: 1.5rem;
            cursor: pointer;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">Portal do Professor</div>
    <div class="user-info">
        <?php echo "<h1>Bem-vindo, <span style='color:white;'>$nome</span>!</h1>"; ?>
        <div class="user-avatar">VS</div>
    </div>
</header>

<div class="container">
    <aside class="sidebar">
    <ul class="nav-menu">
    <li class="nav-item active" onclick="showSection('dashboard')">
        <i class="fas fa-home"></i> Dashboard
    </li>
    <li class="nav-item" onclick="showSection('notas')">
        <i class="fas fa-clipboard-list"></i> Lançar Notas
    </li>
    <li class="nav-item" onclick="showSection('atividades')">
        <i class="fas fa-tasks"></i> Atividades
    </li>
    <li class="nav-item" onclick="showSection('frequencia')">
        <i class="fas fa-calendar-alt"></i> Registrar Frequência
    </li>
    <li class="nav-item">
        <form action="limpar_dados.php" method="POST" onsubmit="return confirmarLimpeza();" style="margin: 0;">
            <button type="submit" class="btn btn-danger" style="width: 100%; text-align: left; padding: 0.75rem; background: none; border: none; color:rgb(0, 0, 0); font-size: 1rem; cursor: pointer;">
                <i class="fas fa-broom"></i> Limpar Dados
            </button>
        </form>
    </li>
    <li class="nav-item">
        <a href="../includes/sair.php" class="btn btn-danger">
            <i class="fas fa-sign-out-alt"></i> Sair
        </a>
    </li>
   
</ul>

    </aside>

  <main class="main-content">
    <section id="dashboard-section" class="content-section">
        <div class="welcome-banner">
            <?php echo "<h1>Bem-vindo(a), <u>$nome</u></h1>"; ?>
            <p>Gerencie as informações acadêmicas dos seus alunos com facilidade.</p>
        </div>

        <div class="cards-container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">

            <!-- Ações Rápidas -->
            <div class="card quick-actions">
                <div class="card-header">
                    <h2 class="card-title">⚡ Ações Rápidas</h2>
                </div>
                <div class="card-body actions-grid" style="display: flex; flex-direction: column; gap: 0.75rem;">
                    <button class="btn btn-primary" onclick="showSection('notas')">
                        <i class="fas fa-plus"></i> Adicionar Nota
                    </button>
                    <button class="btn btn-primary" onclick="showSection('frequencia')">
                        <i class="fas fa-calendar-alt"></i> Registrar Falta
                    </button>
                    <button class="btn btn-primary" onclick="showSection('atividades')">
                        <i class="fas fa-book"></i> Nova Atividade
                    </button>
                </div>
            </div>

            <!-- Resumo de Turmas -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">👥 Minhas Turmas</h2>
                </div>
                <div class="card-body">
                    <ul class="list-clean">
                        <li><strong>PDM - TDS3º</strong><br><small>30 alunos</small></li>
                        <li><strong>Banco de Dados - TDS3º</strong><br><small>25 alunos</small></li>
                        <li><strong>Métodos de Pesquisa - TDS3º</strong><br><small>20 alunos</small></li>
                    </ul>
                </div>
            </div>

            <!-- Atividades Pendentes -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">📝 Atividades Pendentes</h2>
                </div>
                <div class="card-body">
                    <ul class="list-clean">
                        <li><strong>Trabalho PDM</strong> - 15/20 entregues</li>
                        <li><strong>Prova BD</strong> - 10/25 entregues</li>
                        <li><strong>Seminário</strong> - 5/20 entregues</li>
                    </ul>
                </div>
            </div>

            <!-- Últimos Avisos -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">📢 Últimos Avisos</h2>
                </div>
                <div class="card-body">
                    <div class="notice">
                        <strong>🗓️ Reunião Pedagógica</strong>
                        <p>Dia 25/06 às 14h - Sala dos Professores</p>
                        <small>Postado em: 20/06</small>
                    </div>
                    <hr>
                    <div class="notice">
                        <strong>📄 Entrega de Diários</strong>
                        <p>Prazo: 30/06</p>
                        <small>Postado em: 18/06</small>
                    </div>
                </div>
            </div>

        </div>
    </section>


        <section id="notas-section" class="content-section" style="display: none;">
        <div style="
  background-color: #fff;
  border-radius: 12px;
  padding: 2rem;
  width: 100%;
  max-width: 600px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  border: 1px solid #e0e0e0;
  margin-bottom: 2rem;
  margin-left: 0; /* garante alinhamento à esquerda */
">
  <h2 style="font-size: 1.8rem; color: #2c3e50; margin-bottom: 1.2rem;">
    📝 Lançar Nota para Aluno
  </h2>

  <form method="post" action="">
    <div style="margin-bottom: 1.5rem;">
      <label for="nome" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Aluno</label>
      <select name="nome" required style="
        width: 100%;
        padding: 0.75rem;
        border-radius: 8px;
        border: 1px solid #ccc;
        background-color: #fdfdfd;
      ">
        <option value="">-- Selecione o aluno --</option>
        <?php
        require '../includes/config.php';
        $sql = "SELECT nome FROM usuarios WHERE portal = 'aluno' ORDER BY nome";
        $res = $conexao->query($sql);
        while ($aluno = $res->fetch_assoc()) {
          echo "<option value='" . htmlspecialchars($aluno['nome']) . "'>" . htmlspecialchars($aluno['nome']) . "</option>";
        }
        ?>
      </select>
    </div>

    <div style="margin-bottom: 1.5rem;">
      <label for="disciplina" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Disciplina</label>
      <input type="text" name="disciplina" required style="
        width: 100%;
        padding: 0.75rem;
        border-radius: 8px;
        border: 1px solid #ccc;
        background-color: #fdfdfd;
      ">
    </div>

    <div style="margin-bottom: 1.5rem;">
      <label for="nota" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Nota</label>
      <input type="number" name="nota" step="0.01" min="0" max="10" required style="
        width: 100%;
        padding: 0.75rem;
        border-radius: 8px;
        border: 1px solid #ccc;
        background-color: #fdfdfd;
      ">
    </div>

    <button type="submit" style="
      width: 100%;
      padding: 0.75rem;
      background-color: #3498db;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      cursor: pointer;
      transition: background-color 0.3s;
    " onmouseover="this.style.backgroundColor='#2980b9'" onmouseout="this.style.backgroundColor='#3498db'">
      Salvar Nota
    </button>
  </form>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $nome = $_POST['nome'];
      $disciplina = $_POST['disciplina'];
      $nota = $_POST['nota'];

      if (!empty($nome) && !empty($disciplina) && is_numeric($nota) && $nota >= 0 && $nota <= 10) {
          $stmt = $conexao->prepare("SELECT id FROM usuarios WHERE nome = ?");
          $stmt->bind_param("s", $nome);
          $stmt->execute();
          $res = $stmt->get_result();
          $stmt->close();

          if ($res->num_rows > 0) {
              $aluno = $res->fetch_assoc();
              $aluno_id = $aluno['id'];

              $stmt = $conexao->prepare("INSERT INTO notas (id_aluno, disciplina, nota) VALUES (?, ?, ?)");
              $stmt->bind_param("isd", $aluno_id, $disciplina, $nota);

              if ($stmt->execute()) {
                  echo "<p style='color: green; margin-top: 1rem;'>✅ Nota salva com sucesso!</p>";
              } else {
                  echo "<p style='color: red; margin-top: 1rem;'>❌ Erro ao salvar a nota: " . htmlspecialchars($stmt->error) . "</p>";
              }
              $stmt->close();
          } else {
              echo "<p style='color: red; margin-top: 1rem;'>⚠️ Aluno não encontrado.</p>";
          }
      } else {
          echo "<p style='color: red; margin-top: 1rem;'>⚠️ Preencha todos os campos corretamente (nota de 0 a 10).</p>";
      }
  }
  ?>
</div>


        </section>

        <section id="atividades-section" class="content-section" style="display: none;">
        <h2 style="margin-bottom: 1rem; font-size: 1.75rem; color: #333;">📘 Criar Nova Atividade</h2>

<div style="padding: 1.5rem; border: 1px solid #ccc; border-radius: 12px; max-width: 600px; background-color: #f9f9f9; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
    <form action="acao_enviar.php" method="POST">
        <div style="margin-bottom: 1rem;">
            <label for="titulo" style="display: block; margin-bottom: 0.3rem; font-weight: bold;">Título da Atividade</label>
            <input type="text" id="titulo" name="titulo" placeholder="Digite o título da atividade" required
                   style="width: 100%; padding: 0.75rem; border-radius: 6px; border: 1px solid #ccc;">
        </div>

        <div style="margin-bottom: 1rem;">
            <label for="descricao" style="display: block; margin-bottom: 0.3rem; font-weight: bold;">Descrição</label>
            <textarea id="descricao" name="descricao" placeholder="Descreva a atividade" required
                      style="width: 100%; height: 120px; padding: 0.75rem; border-radius: 6px; border: 1px solid #ccc;"></textarea>
        </div>

        <div style="margin-bottom: 1rem;">
            <label for="data_entrega" style="display: block; margin-bottom: 0.3rem; font-weight: bold;">Data de Entrega</label>
            <input type="date" id="data_entrega" name="data_entrega" required
                   style="width: 100%; padding: 0.75rem; border-radius: 6px; border: 1px solid #ccc;">
        </div>

        <button type="submit" style="
            background-color: #3498db;
            color: #fff;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
        ">
            Enviar Atividade
        </button>
    </form>
</div>
        </section>

        <section id="frequencia-section" class="content-section" style="display: none;">
        <h2 style="font-size: 1.8rem; color: #2c3e50; margin-bottom: 1.2rem;">
  📅 Registrar Frequência
</h2>

<div style="
  background-color: #fff;
  border-radius: 12px;
  padding: 2rem;
  width: 100%;
  max-width: 600px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  border: 1px solid #e0e0e0;
  margin-bottom: 2rem;
">
  <form method="POST" action="registrar_frequencia.php" class="form-box">
    
    <div style="margin-bottom: 1.5rem;">
      <label for="id_aluno" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Aluno</label>
      <select name="id_aluno" required style="
        width: 100%;
        padding: 0.75rem;
        border-radius: 8px;
        border: 1px solid #ccc;
        background-color: #fdfdfd;
      ">
        <option value="">-- Selecione o aluno --</option>
        <?php
        require '../includes/config.php';
        $res = $conexao->query("SELECT id, nome FROM usuarios WHERE portal = 'aluno'");
        while ($row = $res->fetch_assoc()) {
          echo "<option value='{$row['id']}'>" . htmlspecialchars($row['nome']) . "</option>";
        }
        ?>
      </select>
    </div>

    <div style="margin-bottom: 1.5rem;">
      <label for="data" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Data</label>
      <input type="date" name="data" required style="
        width: 100%;
        padding: 0.75rem;
        border-radius: 8px;
        border: 1px solid #ccc;
        background-color: #fdfdfd;
      ">
    </div>

    <div style="margin-bottom: 1.5rem;">
      <label for="presente" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Presença</label>
      <select name="presente" required style="
        width: 100%;
        padding: 0.75rem;
        border-radius: 8px;
        border: 1px solid #ccc;
        background-color: #fdfdfd;
      ">
        <option value="1">Presente</option>
        <option value="0">Falta</option>
      </select>
    </div>

    <button type="submit" style="
      width: 100%;
      padding: 0.75rem;
      background-color: #3498db;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      cursor: pointer;
      transition: background-color 0.3s;
    " onmouseover="this.style.backgroundColor='#2980b9'" onmouseout="this.style.backgroundColor='#3498db'">
      Registrar Frequência
    </button>
  </form>
</div>


 </div>    
        </section>
    </main>
</div>

<footer>
    <p>&copy; 2025 Portal do Professor - Todos os direitos reservados</p>
</footer>

<script>
function showSection(sectionId) {
    document.querySelectorAll('.content-section').forEach(section => {
        section.style.display = 'none';
    });
    const activeSection = document.getElementById(sectionId + '-section');
    if (activeSection) activeSection.style.display = 'block';

    document.querySelectorAll('.nav-item').forEach(item => item.classList.remove('active'));
    const matchedItem = [...document.querySelectorAll('.nav-item')].find(item =>
        item.getAttribute('onclick')?.includes(sectionId)
    );
    if (matchedItem) matchedItem.classList.add('active');
}

function openModal(id) {
    const modal = document.getElementById(id);
    if (modal) modal.style.display = 'block';
}

function closeModal(id) {
    const modal = document.getElementById(id);
    if (modal) modal.style.display = 'none';
}

window.onclick = function(event) {
    document.querySelectorAll('.modal').forEach(modal => {
        if (event.target == modal) modal.style.display = 'none';
    });
}

// Carrega a seção inicial
window.addEventListener('DOMContentLoaded', () => showSection('dashboard'));
</script>

</body>
</html>
