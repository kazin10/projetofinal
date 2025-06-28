document.addEventListener('DOMContentLoaded', () => {
  const openFaltaBtns = document.querySelectorAll('.btn-add-falta');
  const openNotaBtns = document.querySelectorAll('.btn-add-nota');
  const openObsBtns = document.querySelectorAll('.btn-add-obs');
  const modals = document.querySelectorAll('.modal');
  const closeModalBtns = document.querySelectorAll('.close-modal');

  function openModal(modalId, aluno = null) {
    const modal = document.getElementById(modalId);
    modal.style.display = 'flex';

    if (aluno) {
      const input = modal.querySelector('input[readonly]');
      if (input) input.value = aluno;
    }
  }

  function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
  }

  // Botões de abertura
  openFaltaBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
      const aluno = e.target.closest('.student-item')?.querySelector('strong')?.textContent;
      openModal('frequencia-modal', aluno);
    });
  });

  openNotaBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
      const aluno = e.target.closest('.student-item')?.querySelector('strong')?.textContent;
      openModal('nota-modal', aluno);
    });
  });

  openObsBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
      const aluno = e.target.closest('.student-item')?.querySelector('strong')?.textContent;
      openModal('observacao-modal', aluno);
    });
  });

  closeModalBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      modals.forEach(modal => modal.style.display = 'none');
    });
  });

  // Fecha modal ao clicar fora
  window.addEventListener('click', (e) => {
    modals.forEach(modal => {
      if (e.target === modal) modal.style.display = 'none';
    });
  });

  // Botões Iniciar, Editar, Enviar
  document.querySelectorAll('.iniciar-btn').forEach(button => {
    button.addEventListener('click', () => {
      button.innerText = 'Em andamento...';
      button.disabled = true;
      button.classList.remove('btn-primary');
      button.classList.add('btn-warning');
    });
  });

  document.querySelectorAll('.editar-btn').forEach(button => {
    button.addEventListener('click', () => {
      const atividade = button.closest('.student-item').querySelector('strong')?.innerText;
      const novoNome = prompt('Editar o nome da atividade:', atividade);
      if (novoNome) {
        button.closest('.student-item').querySelector('strong').innerText = novoNome;
        alert('Atividade atualizada!');
      }
    });
  });

  document.querySelectorAll('.enviar-btn').forEach(button => {
    button.addEventListener('click', () => {
      if (confirm('Deseja realmente enviar essa atividade?')) {
        button.innerText = 'Enviado!';
        button.disabled = true;
        button.classList.remove('btn-primary');
        button.classList.add('btn-success');
      }
    });
  });
});

// Seções
function showSection(sectionId) {
  document.querySelectorAll('.content-section').forEach(section => {
    section.style.display = 'none';
  });

  const activeSection = document.getElementById(sectionId + '-section');
  if (activeSection) activeSection.style.display = 'block';

  document.querySelectorAll('.nav-item').forEach(item => item.classList.remove('active'));

  const matchedItem = Array.from(document.querySelectorAll('.nav-item')).find(item =>
    item.getAttribute('onclick')?.includes(sectionId)
  );
  if (matchedItem) matchedItem.classList.add('active');
}

// Ações simuladas
function salvarNota() {
  alert('Nota salva com sucesso!');
  closeModal('nota-modal');
}

function salvarFalta() {
  alert('Falta registrada com sucesso!');
  closeModal('frequencia-modal');
}

function salvarObservacao() {
  alert('Observação salva com sucesso!');
  closeModal('observacao-modal');
}

function verTurma(turmaId) {
  alert('Visualizando turma: ' + turmaId);
}

function editarNota(alunoId) {
  alert('Editando nota do aluno ID: ' + alunoId);
  openModal('nota-modal');
}

function verFrequencia(alunoId) {
  alert('Visualizando frequência do aluno ID: ' + alunoId);
}

function confirmarLimpeza() {
  return confirm("⚠️ Tem certeza que deseja apagar todos os dados de notas, atividades e frequência? Esta ação não pode ser desfeita!");
}