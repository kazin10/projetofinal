// ============ VARIÁVEIS GLOBAIS ============
const portalSelect = document.getElementById('portal-select');
const loginForm = document.getElementById('login-form');
const portalTitle = document.getElementById('portal-title');
const emailInput = document.getElementById('email');
const senhaInput = document.getElementById('senha');
const loginBtn = document.getElementById('login-btn');
const formFrequencia = document.getElementById('form-frequencia');

// ============ EVENTO DE MUDANÇA DE PORTAL ============
portalSelect?.addEventListener('change', function () {
    const portal = this.value;
    portalTitle.textContent = portal === 'aluno' ? 'Portal do Aluno - Login' : 'Portal do Professor - Login';
    loginBtn.textContent = portal === 'aluno' ? 'Acessar como Aluno' : 'Acessar como Professor';
    emailInput.value = '';
    senhaInput.value = '';
    showMessage('', '');
});

// ============ EVENTO DE SUBMISSÃO DO FORMULÁRIO ============
loginForm?.addEventListener('submit', function (e) {
    e.preventDefault();

    const portal = portalSelect.value;
    const email = emailInput.value.trim();
    const senha = senhaInput.value.trim();

    if (!email || !senha) {
        showMessage('Por favor, preencha todos os campos', 'error');
        return;
    }

    const usuario = autenticarUsuario(portal, email, senha);

    if (usuario) {
        showMessage('Login bem-sucedido! Redirecionando...', 'success');
        setTimeout(() => {
            if (portal === 'aluno') {
                sessionStorage.setItem('aluno', JSON.stringify(usuario));
                window.location.href = '../aluno/dashboard.php';
            } else {
                sessionStorage.setItem('professor', JSON.stringify(usuario));
                window.location.href = '../professor/dashboard.php';
            }
        }, 1500);
    } else {
        showMessage('Email ou senha incorretos', 'error');
    }
});

// ============ EVENTO DE BUSCAR FREQUÊNCIA ============
formFrequencia?.addEventListener('submit', function (e) {
  e.preventDefault();
  buscarFrequencia(); // Sua função personalizada
});

// ============ AUTENTICAÇÃO SIMULADA ============
function autenticarUsuario(portal, email, senha) {
    const listaUsuarios = portal === 'aluno' ? usuarios.alunos : usuarios.professores;
    return listaUsuarios.find(user => user.email === email && user.senha === senha);
}

// ============ EXIBIR MENSAGENS ============
function showMessage(msg, type) {
    messageDiv.textContent = msg;
    messageDiv.className = `message ${type}`;
}

// ============ VERIFICAÇÃO DE AUTENTICAÇÃO ============
function checkAuth(requiredPortal) {
    const userData = sessionStorage.getItem(requiredPortal);
    if (!userData) {
        window.location.href = '../index.html';
    }
    return JSON.parse(userData);
}

// ============ NAVEGAÇÃO ENTRE SEÇÕES ============
function showSection(sectionId) {
    document.querySelectorAll('.content-section').forEach(section => {
        section.style.display = 'none';
    });
    document.getElementById(`${sectionId}-section`).style.display = 'block';

    document.querySelectorAll('.nav-item').forEach(item => {
        item.classList.remove('active');
        if (item.getAttribute('onclick')?.includes(sectionId)) {
            item.classList.add('active');
        }
    });
}

// ============ MODAIS ============
function openModal(modalId) {
    document.getElementById(modalId).style.display = 'flex';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

window.onclick = function (event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
};

// ============ FUNÇÕES DE AÇÃO ============
function enviarJustificativa() {
    alert('Justificativa enviada com sucesso!');
    closeModal('justificar-falta-modal');
}

function enviarMensagem() {
    alert('Mensagem enviada com sucesso!');
    closeModal('nova-mensagem-modal');
}

function gerarBoletim() {
    alert('Boletim gerado com sucesso!');
    closeModal('boletim-modal');
} // fim
