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
    <link rel="stylesheet" href="../css/aluno.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal do Aluno</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
</head>
<body>
    <header>
        <div class="logo">Portal do Aluno</div>
        <div class="user-info">
        <?php
            echo "<h1>Bem-vindo, <span style='color:white;'>$nome</span>!</h1>";
        ?>
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
                    <i class="fas fa-clipboard-list"></i> Minhas Notas
                </li>
                <li class="nav-item" onclick="showSection('frequencia')">
                    <i class="fas fa-calendar-check"></i> Minha Frequência
                </li>
                <li class="nav-item" onclick="showSection('atividades')">
                    <i class="fas fa-tasks"></i> Atividades
                </li>
                <<li class="nav-item">
                    <a href="../includes/sair.php" class="btn btn-danger" style="display: flex; align-items: center;">
                    <i class="fas fa-sign-out-alt" style="margin-right: 0.5rem;"></i> Sair
                   </a>
                </li>
            </ul>
        </aside>
        
        <main class="main-content">
            <!-- Seção Dashboard -->
            <div id="dashboard-section" class="content-section">
                <div class="welcome-banner">
                    <?php
                        echo "<h1>Bem-vindo, <span style='color:white;'>$nome</span>!</h1>";
                    ?>
                    <p>Acompanhe seu desempenho acadêmico</p>
                </div>
                
                <div class="cards-container">
                    <!-- Card de Notas -->
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Resumo de Notas</h2>
                            <span class="badge badge-info">Média: 8.2</span>
                        </div>
                        <ul style="list-style: none;">
                            <li style="padding: 0.5rem 0; border-bottom: 1px solid #e2e8f0;">
                                <strong>Programação Web</strong>
                                <p>Nota atual: 8.5</p>
                                <div class="progress-container">
                                    <div class="progress-bar" style="width: 85%"></div>
                                </div>
                            </li>
                            <li style="padding: 0.5rem 0; border-bottom: 1px solid #e2e8f0;">
                                <strong>Banco de Dados</strong>
                                <p>Nota atual: 7.8</p>
                                <div class="progress-container">
                                    <div class="progress-bar" style="width: 78%"></div>
                                </div>
                            </li>
                            <li style="padding: 0.5rem 0;">
                                <strong>Metodo de Pesquisa</strong>
                                <p>Nota atual: 8.3</p>
                                <div class="progress-container">
                                    <div class="progress-bar" style="width: 83%"></div>
                                </div>
                            </li>
                        </ul>
                        <button class="btn btn-primary" style="margin-top: 1rem; width: 100%;" onclick="showSection('notas')">
                            Ver Todas as Notas
                        </button>
                    </div>


             <!-- Card de Avisos -->
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Avisos Recentes</h2>
                        </div>
                        <div style="padding: 0.5rem 0; border-bottom: 1px solid #e2e8f0;">
                            <strong>Prova de Banco de Dados</strong>
                            <p>Dia 20/11 às 14h no laboratorio 1°</p>
                            <small style="color: #64748b;">Postado em: 10/11/2023</small>
                        </div>
                        <div style="padding: 0.5rem 0; border-bottom: 1px solid #e2e8f0;">
                            <strong>Trabalho de Programação Web</strong>
                            <p>Prazo final para entrega: 25/11/2023</p>
                            <small style="color: #64748b;">Postado em: 05/11/2023</small>
                        </div>
                        <div style="padding: 0.5rem 0;">
                            <strong>Recesso Acadêmico</strong>
                            <p>Dias 30/11 e 01/12 - não haverá aula</p>
                            <small style="color: #64748b;">Postado em: 01/11/2023</small>
                        </div>
                    </div>

<!-- Card de Atividades -->
<div class="card">
<?php
include '../includes/config.php';

$pendentes = 0;

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Total de atividades
    $sqlTotal = "SELECT COUNT(*) AS total FROM atividades";
    $resultTotal = $conexao->query($sqlTotal);
    $rowTotal = $resultTotal->fetch_assoc();
    $totalAtividades = $rowTotal['total'];

    // Total de atividades já respondidas por este aluno
    $stmt = $conexao->prepare("SELECT COUNT(*) AS respondidas FROM resposta WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultResp = $stmt->get_result();
    $rowResp = $resultResp->fetch_assoc();
    $respondidas = $rowResp['respondidas'];

    // Calcula pendentes
    $pendentes = $totalAtividades - $respondidas;
}
?>

<div class="card-header">
  <h2 class="card-title">Minhas Atividades</h2>
  <span class="badge badge-info"><?php echo $pendentes; ?> Pendentes</span>
</div>

    <ul style="list-style: none;">
        <li style="padding: 0.5rem 0; border-bottom: 1px solid #e2e8f0;">
            <strong>Programação Web</strong>
            <p>Formulário em HTML – até 20/05</p>
        </li>
        <li style="padding: 0.5rem 0;">
            <strong>Banco de Dados</strong>
            <p>Diagrama ER – até 22/05</p>
        </li>
    </ul>
    <button class="btn btn-primary" style="margin-top: 1rem; width: 100%;" onclick="showSection('atividades')">
        Ver Todas as Atividades
    </button>
</div>
                    
                    <!-- Card de Ações Rápidas -->
                <div class="card">
            <div class="card-header">
            <h2 class="card-title">Ações Rápidas</h2>
            </div>
        <button class="btn btn-primary" style="margin-bottom: 0.5rem; width: 100%;" onclick="openModal('justificar-falta-modal')">
        <i class="fas fa-file-alt"></i> Justificar Falta
        </button>
    <button class="btn btn-primary" style="width: 100%;" onclick="showSection('atividades')">
        <i class="fas fa-tasks"></i> Ver Atividades
    </button>
</div>


</div>
</div>

<!-- Seção Atividades -->
<div id="atividades-section" class="content-section" style="display: block; padding: 2rem;">
  <h2 style="margin-bottom: 1.5rem; font-size: 2rem; color: #333;">📚 Minhas Atividades</h2>

  <?php
include '../includes/config.php';

if (!isset($_SESSION['email'])) {
    header('Location: ../index.php');
    exit();
}

$email = $_SESSION['email'];

$sql = "
SELECT * FROM atividades a
WHERE NOT EXISTS (
    SELECT 1 FROM resposta r WHERE r.atividade = a.id AND r.email = ?
)
ORDER BY a.data_entrega ASC
";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>
    <div style="background-color: #f9f9f9; padding: 1.5rem; border: 1px solid #ddd; border-radius: 12px; margin-bottom: 1.5rem; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h3 style="color: #2c3e50;"><?php echo htmlspecialchars($row['titulo']); ?></h3>
        <p><strong>Atividade:</strong> <?php echo nl2br(htmlspecialchars($row['descricao'])); ?></p>
        <p><strong>Data de Entrega:</strong> 📅 <?php echo date('d/m/Y', strtotime($row['data_entrega'])); ?></p>

        <form action="resposta_enviada.php" method="POST" enctype="multipart/form-data" style="margin-top: 1rem;">
            <input type="hidden" name="atividade" value="<?php echo $row['id']; ?>">

            <textarea name="resposta_texto" placeholder="Digite sua resposta aqui..." required style="width: 100%; height: 100px; padding: 0.75rem; margin-bottom: 0.75rem; border-radius: 6px; border: 1px solid #ccc; font-size: 1rem;"></textarea>

            <input type="file" name="arquivo" style="margin-bottom: 0.75rem;">
            
            <button type="submit" name="somente_marcar" value="1" style="background-color: #2ecc71; color: white; border: none; padding: 0.6rem 1.2rem; border-radius: 8px; font-size: 1rem; cursor: pointer;">
                Marcar como Entregue
            </button>
        </form>
    </div>
<?php
    }
} else {
    echo "<div style='background-color: #e8f5e9; padding: 1rem; border-radius: 8px;'>Nenhuma atividade disponível no momento.</div>";
}
?>

</div>

<section id="frequencia-section" class="content-section" style="display: none;">
    <h2 style="margin-bottom: 1.5rem; font-size: 2rem;">📅 Buscar Frequência por Nome</h2>

    <form method="get" style="margin-bottom: 1.5rem;">
        <label for="nome">Nome do Aluno:</label>
        <input type="text" name="nome" id="nome" required style="padding: 8px; margin-left: 10px; border: 1px solid #ccc; border-radius: 5px;">
        <input type="submit" value="Buscar" style="padding: 8px 16px; margin-left: 10px; background-color: #3498db; color: white; border: none; border-radius: 5px;">
    </form>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Histórico de Presença</h3>
        </div>
        <div class="table-responsive">
            <table class="table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="padding: 10px; border: 1px solid #ddd;">Data</th>
                        <th style="padding: 10px; border: 1px solid #ddd;">Presença</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                include '../includes/config.php';

                if (isset($_GET['nome']) && !empty(trim($_GET['nome']))) {
                    $nome = trim($_GET['nome']);

                    // Buscar o aluno pelo nome
                    $sql = "SELECT id FROM usuarios WHERE nome = ?";
                    $stmt = $conexao->prepare($sql);
                    $stmt->bind_param("s", $nome);
                    $stmt->execute();
                    $res = $stmt->get_result();

                    if ($res->num_rows > 0) {
                        $row = $res->fetch_assoc();
                        $id_aluno = $row['id'];

                        // Buscar frequências do aluno
                        $stmt = $conexao->prepare("SELECT data, presente FROM frequencias WHERE id_aluno = ? ORDER BY data DESC");
                        $stmt->bind_param("i", $id_aluno);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($frequencia = $result->fetch_assoc()) {
                                $data = date('d/m/Y', strtotime($frequencia['data']));
                                $presente = $frequencia['presente'] ? '✅ Presente' : '❌ Falta';
                                echo "<tr>
                                        <td style='padding: 10px; border: 1px solid #ddd;'>$data</td>
                                        <td style='padding: 10px; border: 1px solid #ddd;'>$presente</td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='2' style='padding: 10px;'>Nenhum registro de frequência encontrado para <strong>$nome</strong>.</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2' style='padding: 10px;'>Aluno não encontrado.</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='2' style='padding: 10px;'>Digite um nome e clique em buscar.</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Seção Notas -->
<div id="notas-section" class="content-section" style="display: none;">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Minhas Notas</h2>
        </div>
        <div class="table-responsive">
            <form method="get" style="padding: 15px;">
                Nome do Aluno: <input type="text" name="nome">
                <input type="submit" value="Buscar Notas">
            </form>
            <table class="table">
                <thead>
                    <tr>
                        <th>Disciplina</th>
                        <th>Atividade</th>
                        <th>Nota</th>
                        <th>Data</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if (isset($_GET['nome'])) {
                    $nome = $_GET['nome'];

                    $sql = "SELECT id FROM usuarios WHERE nome = ?";
                    $stmt = $conexao->prepare($sql);
                    $stmt->bind_param("s", $nome);
                    $stmt->execute();
                    $resultado = $stmt->get_result();

                    if ($resultado->num_rows > 0) {
                        $aluno = $resultado->fetch_assoc();
                        $aluno_id = $aluno['id'];

                        $sqlNotas = "SELECT disciplina, nota FROM notas WHERE id_aluno = ?";
                        $stmtNotas = $conexao->prepare($sqlNotas);
                        $stmtNotas->bind_param("i", $aluno_id);
                        $stmtNotas->execute();
                        $resultadoNotas = $stmtNotas->get_result();

                        if ($resultadoNotas->num_rows > 0) {
                            while ($row = $resultadoNotas->fetch_assoc()) {
                                $nota = $row['nota'];
                                $status = '';
                                if ($nota >= 7) {
                                    $status = '<span class="badge badge-success">Aprovado</span>';
                                } elseif ($nota >= 5) {
                                    $status = '<span class="badge badge-warning">Recuperação</span>';
                                } else {
                                    $status = '<span class="badge badge-danger">Reprovado</span>';
                                }

                                echo "<tr>
                                    <td>{$row['disciplina']}</td>
                                    <td>Atividade</td>
                                    <td>{$nota}</td>
                                    <td>-</td>
                                    <td>$status</td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>Esse aluno não tem notas cadastradas.</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Aluno não encontrado.</td></tr>";
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div> 
   
    <!-- Modal Justificar Falta -->
    <div id="justificar-falta-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Justificar Falta</h3>
                <button class="modal-close" onclick="closeModal('justificar-falta-modal')">&times;</button>
            </div>
            <div class="form-group">
                <label class="form-label">Selecione a Disciplina:</label>
                <select class="form-control" id="disciplina-falta">
                    <option value="">-- Selecione --</option>
                    <option value="pw">Programação Web</option>
                    <option value="bd">Banco de Dados</option>
                    <option value="mat">Metodo de Pesquisa</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Data da Falta:</label>
                <input type="date" class="form-control" id="data-falta">
            </div>
            <div class="form-group">
                <label class="form-label">Tipo de Justificativa:</label>
                <select class="form-control" id="tipo-justificativa">
                    <option value="">-- Selecione --</option>
                    <option value="medico">Atestado Médico</option>
                    <option value="pessoal">Motivo Pessoal</option>
                    <option value="outro">Outro</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Descrição:</label>
                <textarea class="form-control" id="descricao-justificativa" rows="3" placeholder="Descreva o motivo da falta..."></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Anexar Comprovante (opcional):</label>
                <input type="file" class="form-control" id="anexo-justificativa">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal('justificar-falta-modal')">Cancelar</button>
                <button class="btn btn-primary" onclick="enviarJustificativa()">Enviar Justificativa</button>
            </div>
        </div>
    </div>
    <footer>
        <p>&copy; 2025 Portal do Aluno - Todos os direitos reservados</p>
    </footer>
    <script>
</script>
    <script src="../portal/portal.js"></script>
    <script>
    if (performance.navigation.type === 2) {
        // Se o usuário usou o botão voltar, recarrega a página
        location.reload(true);
    }
</script>
</body>
</html>