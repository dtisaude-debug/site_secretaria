/* =============================================
   MENU HAMBURGER
============================================= */
const hamburger = document.getElementById('hamburger');
const navLinks  = document.getElementById('navLinks');

hamburger.addEventListener('click', () => {
  navLinks.classList.toggle('open');
});

navLinks.querySelectorAll('a').forEach(link => {
  link.addEventListener('click', () => navLinks.classList.remove('open'));
});

/* =============================================
   ACTIVE LINK AO SCROLL
============================================= */
const sections = document.querySelectorAll('section[id]');
const links    = document.querySelectorAll('.nav-links a');

window.addEventListener('scroll', () => {
  let current = '';
  sections.forEach(sec => {
    if (window.scrollY >= sec.offsetTop - 100) {
      current = sec.getAttribute('id');
    }
  });
  links.forEach(link => {
    link.classList.remove('active');
    if (link.getAttribute('href') === `#${current}`) {
      link.classList.add('active');
    }
  });
});

/* =============================================
   FORMULÁRIO DE CONTATO — Envio via fetch
============================================= */
const contatoForm = document.getElementById('contatoForm');
const btnEnviar   = document.getElementById('btnEnviar');
const formAlert   = document.getElementById('formAlert');

function showAlert(tipo, mensagem) {
  formAlert.className  = `form-alert ${tipo}`;
  formAlert.innerHTML  = `
    <i class="fas ${tipo === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
    ${mensagem}
  `;
  formAlert.style.display = 'flex';

  // Esconde após 6 segundos
  setTimeout(() => {
    formAlert.style.display = 'none';
  }, 6000);
}

if (contatoForm) {
  contatoForm.addEventListener('submit', async function(e) {
    e.preventDefault();

    const nome     = document.getElementById('nome').value.trim();
    const email    = document.getElementById('email').value.trim();
    const mensagem = document.getElementById('mensagem').value.trim();

    // Estado de loading
    btnEnviar.classList.add('loading');
    btnEnviar.querySelector('span').textContent = 'Enviando...';
    btnEnviar.disabled = true;

    try {
      const response = await fetch('/enviar-contato', {
        method:  'POST',
        headers: { 'Content-Type': 'application/json' },
        body:    JSON.stringify({ nome, email, mensagem })
      });

      const data = await response.json();

      if (data.success) {
        showAlert('success', data.message);
        contatoForm.reset();
      } else {
        showAlert('error', data.message);
      }

    } catch (error) {
      showAlert('error', 'Erro de conexão. Tente novamente.');
    } finally {
      // Restaura o botão
      btnEnviar.classList.remove('loading');
      btnEnviar.querySelector('span').textContent = 'Enviar';
      btnEnviar.disabled = false;
    }
  });
}

/* =============================================
   ANIMAÇÃO DE ENTRADA — Intersection Observer
============================================= */
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.style.opacity   = '1';
      entry.target.style.transform = 'translateY(0)';
    }
  });
}, { threshold: 0.1 });

document.querySelectorAll('.noticia-card, .servico-item').forEach(el => {
  el.style.opacity    = '0';
  el.style.transform  = 'translateY(20px)';
  el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
  observer.observe(el);
});

/* =============================================
   CAROUSEL DE DEPARTAMENTOS
============================================= */
const track     = document.getElementById('deptTrack');
const btnPrev   = document.getElementById('deptPrev');
const btnNext   = document.getElementById('deptNext');
const dotsWrap  = document.getElementById('deptDots');

let currentIndex = 0;

// Quantos cards visíveis por vez dependendo da largura
function getVisible() {
  if (window.innerWidth <= 600)  return 1;
  if (window.innerWidth <= 900)  return 2;
  return 3;
}

const cards      = track ? Array.from(track.children) : [];
const totalCards = cards.length;

function getTotalSlides() {
  return Math.ceil(totalCards / getVisible());
}

// Cria os dots dinamicamente
function buildDots() {
  if (!dotsWrap) return;
  dotsWrap.innerHTML = '';
  for (let i = 0; i < getTotalSlides(); i++) {
    const dot = document.createElement('button');
    dot.classList.add('dot');
    dot.setAttribute('aria-label', `Slide ${i + 1}`);
    if (i === currentIndex) dot.classList.add('active');
    dot.addEventListener('click', () => goTo(i));
    dotsWrap.appendChild(dot);
  }
}

// Atualiza posição do carousel
function updateCarousel() {
  if (!track) return;

  const visible     = getVisible();
  const cardWidth   = track.parentElement.offsetWidth;
  const gap         = 20;
  const slideWidth  = (cardWidth - gap * (visible - 1)) / visible;

  // Move o track
  const offset = currentIndex * (slideWidth + gap) * visible;
  track.style.transform = `translateX(-${offset}px)`;

  // Atualiza largura de cada card
  cards.forEach(card => {
    card.style.flex     = `0 0 ${slideWidth}px`;
    card.style.minWidth = `${slideWidth}px`;
  });

  // Atualiza dots
  document.querySelectorAll('.dot').forEach((dot, i) => {
    dot.classList.toggle('active', i === currentIndex);
  });

  // Desabilita botões nas extremidades
  if (btnPrev) btnPrev.disabled = currentIndex === 0;
  if (btnNext) btnNext.disabled = currentIndex >= getTotalSlides() - 1;
}

function goTo(index) {
  currentIndex = Math.max(0, Math.min(index, getTotalSlides() - 1));
  updateCarousel();
}

if (btnPrev) btnPrev.addEventListener('click', () => goTo(currentIndex - 1));
if (btnNext) btnNext.addEventListener('click', () => goTo(currentIndex + 1));

// Recalcula ao redimensionar
window.addEventListener('resize', () => {
  currentIndex = 0;
  buildDots();
  updateCarousel();
});

// Inicializa
if (track) {
  buildDots();
  updateCarousel();
}

/* =============================================
   DADOS DOS DEPARTAMENTOS (modal)
============================================= */
const deptData = {
  dts: {
    sigla:      'DTS',
    nome:       'Departamento de Transporte Sanitario',
    icone:      'fas fa-ambulance',
    descricao:  'O dts garante o deslocamento de pacientes que precisam realizar tratamentos médicos em outros municípios ou estados.',
    infos: [
      { icone: 'fa-solid fa-user',      titulo:'Responsável',   texto: 'Isaias Nogueira Leal'},
      { icone: 'fas fa-map-marker-alt', titulo: 'Atendimento',  texto: 'Pacientes do SUS que necessitam de tratamento fora do município' },
      { icone: 'fas fa-file-alt',       titulo: 'Documentos',   texto: 'Laudo médico, RG, CPF e Cartão SUS' },
      { icone: 'fas fa-phone',          titulo: 'Contato',      texto: '(42) 3142-1517' },
      { icone: 'fas fa-clock',          titulo: 'Horário',      texto: 'Segunda a Sexta, das 08h00 às 17h00' },
    ]
  },
  dvs: {
    sigla:      'DVS',
    nome:       'Departamento de Vigilância em Saúde',
    icone:      'fas fa-search',
    descricao:  'A Vigilância Sanitária é responsável por proteger e promover a saúde da população, por meio do controle sanitário da produção e consumo de produtos, serviços e ambientes.',
    infos: [
      { icone: 'fa-solid fa-user',      titulo:'Responsável',    texto: 'Marlene Terezinha Borecki'},
      { icone: 'fas fa-store',          titulo: 'Fiscalização',  texto: 'Estabelecimentos comerciais, alimentos e medicamentos' },
      { icone: 'fas fa-file-alt',       titulo: 'Alvarás',       texto: 'Emissão e renovação de alvarás sanitários' },
      { icone: 'fas fa-phone',          titulo: 'Contato',       texto: '(42) 3142-1555' },
      { icone: 'fas fa-clock',          titulo: 'Horário',       texto: 'Segunda a Sexta, das 08h às 17h' },
    ]
  },
  due: {
    sigla:      'DUE',
    nome:       'Urgência e Emergência',
    icone:      'fas fa-exclamation-triangle',
    descricao:  'O Departamento de Urgência e Emergência coordena e organiza os serviços de atendimento de urgência e emergência do município, garantindo atendimento rápido e eficaz à população.',
    infos: [
      { icone: 'fa-solid fa-user',      titulo:'Responsável',    texto: 'Erika Mayumi Yassue'},
      { icone: 'fas fa-hospital',       titulo: 'Unidades',      texto: 'UPA 24h e Urgências municipal(Trianon e Primavera)' },
      { icone: 'fas fa-ambulance',      titulo: 'SAMU',          texto: 'Ligue 192 para emergências' },
      { icone: 'fas fa-phone',          titulo: 'Contato',       texto: '(42) 3142-1519' },
      { icone: 'fas fa-clock',          titulo: 'Atendimento',   texto: '24 horas, 7 dias por semana' },
    ]
  },
  das: {
    sigla:      'DAS',
    nome:       'Departamento de Atenção à Saúde',
    icone:      'fas fa-hands-helping',
    descricao:  'O DAS coordena as ações de atenção primária à saúde, incluindo as Unidades Básicas de Saúde (UBS), programas de saúde da família e ações preventivas voltadas à comunidade.',
    infos: [
      { icone: 'fa-solid fa-user',      titulo:'Responsável',    texto: 'Hugo Vieira de Santana'},
      { icone: 'fas fa-clinic-medical', titulo: 'Unidades',      texto: 'Gestão das UBS de Guarapuava' },
      { icone: 'fas fa-user-md',        titulo: 'Programas',     texto: 'Saúde da Família, Hiperdia e outros' },
      { icone: 'fas fa-phone',          titulo: 'Contato',       texto: '(42) 3142-1523' },
      { icone: 'fas fa-clock',          titulo: 'Horário',       texto: 'Segunda a Sexta, das 08h às 17h' },
    ]
  },
  dasmc: {
    sigla:      'DASMC',
    nome:       'Departamento de Atenção à Saúde da Mulher e da Criança',
    icone:      'fa-solid fa-person-pregnant',
    descricao:  'O DAS cuida do atendimento a mulheres e crianças de forma especilizada, a partir de programas que preservam a saude.',
    infos: [
      { icone: 'fas fa-user-friends',   titulo: 'Público',       texto: 'Mulheres e crianças que precisam de atenção a saude' },
      { icone: 'fas fa-heart',          titulo: 'Serviços',      texto: 'Consultas, grupos terapêuticos e oficinas' },
      { icone: 'fas fa-phone',          titulo: 'Contato',       texto: '(42) 3142-1577' },
      { icone: 'fas fa-clock',          titulo: 'Horário',       texto: 'Segunda a Sexta, das 08h às 17h' },
    ]
  },
  draca: {
    sigla:      'DRACA',
    nome:       'Departamento de Regulação, Auditoria, Controle e Avaliação',
    icone:      'fas fa-book-medical',
    descricao:  'O DRACA atua para garantir que os recursos públicos da saúde sejam utilizados de forma transparente e que a população tenha acesso a serviços qualificados, por meio de regulação, auditoria e controle dos serviços de saúde.',
    infos: [
      { icone: 'fa-solid fa-user',      titulo:'Responsável',    texto: 'Graziele Schumanski'},
      { icone: 'fas fa-industry',       titulo: 'Atuação',       texto: 'Público' },
      { icone: 'fas fa-file-medical',   titulo: 'Serviços',      texto: 'Perícias, notificações e ações preventivas' },
      { icone: 'fas fa-phone',          titulo: 'Contato',       texto: '(42) 3142-1560' },
      { icone: 'fas fa-clock',          titulo: 'Horário',       texto: 'Segunda a Sexta, das 08h às 17h' },
    ]
  },
  dgtes: {
    sigla:     'DGTES',
    nome:      'Departamento de Gestão do Trabalho e Educação em Saúde',
    icone:     'fas fa-chalkboard-teacher',
    descricao: 'O DGTES é responsável por planejar e coordenar as políticas de gestão de pessoas e educação permanente em saúde, promovendo a qualificação dos profissionais do SUS municipal.',
    infos: [
      { icone: 'fa-solid fa-user',      titulo:'Responsável', texto: 'Carla Silverio'},
      { icone: 'fas fa-users',          titulo: 'Público',    texto: 'Servidores e profissionais da saúde municipal' },
      { icone: 'fas fa-graduation-cap', titulo: 'Programas',  texto: 'Educação permanente, capacitações e residências' },
      { icone: 'fas fa-phone',          titulo: 'Contato',    texto: '(42) 3142-1507' },
      { icone: 'fas fa-clock',          titulo: 'Horário',    texto: 'Segunda a Sexta, das 08h às 17h' },
    ]
  },
  dpgsus: {
    sigla:     'DPGSUS',
    nome:      'Departamento de Planejamento e Gerenciamento do SUS',
    icone:     'fas fa-chart-line',
    descricao: 'O DPGSUS coordena o planejamento estratégico e o gerenciamento dos recursos do SUS no município, garantindo o uso eficiente das verbas e o cumprimento das metas de saúde pública.',
    infos: [
      { icone: 'fa-solid fa-user',    titulo:'Responsável', texto: 'Adriana Alves'},
      { icone: 'fas fa-chart-bar',    titulo: 'Função',     texto: 'Planejamento, monitoramento e avaliação do SUS' },
      { icone: 'fas fa-file-alt',     titulo: 'Relatórios', texto: 'RAG, PMS e prestações de contas' },
      { icone: 'fas fa-phone',        titulo: 'Contato',    texto: '(42) 3142-1533' },
      { icone: 'fas fa-clock',        titulo: 'Horário',    texto: 'Segunda a Sexta, das 08h às 17h' },
    ]
  },
  dacs: {
    sigla:     'DACS',
    nome:      'Departamento de Administração, Compras e Serviços',
    icone:     'fas fa-building',
    descricao: 'O DACS é responsável por gerenciar a administração, compras e serviços da saúde, garantindo a eficiência e transparência nas operações.',
    infos: [
      { icone: 'fa-solid fa-user',    titulo:'Responsável', texto: 'Maria Izabel'},
      { icone: 'fas fa-tasks',        titulo: 'Função',     texto: 'Administração, compras e serviços' },
      { icone: 'fas fa-file-invoice', titulo: 'Serviços',   texto: 'Fornecimento de materiais e equipamentos' },
      { icone: 'fas fa-phone',        titulo: 'Contato',    texto: '(42) 3142-1529 / 3142-1530' },
      { icone: 'fas fa-clock',        titulo: 'Horário',    texto: 'Segunda a Sexta, das 08h às 17h' },
    ]
  }

};

/* =============================================
   Noticias - Modal
============================================= */
function openModal(key) {
  const data    = deptData[key];
  const overlay = document.getElementById('modalOverlay');
  const header  = document.getElementById('modalHeader');

  if (!data || !overlay) return;

  // Preenche o header
  document.getElementById('modalIconFA').className  = data.icone;
  document.getElementById('modalSigla').textContent = data.sigla;
  document.getElementById('modalNome').textContent  = data.nome;

  // Cor do header = classe do departamento
  header.className = `modal-header ${key}`;

  // Preenche descrição
  document.getElementById('modalDescricao').textContent = data.descricao;

  // Preenche grid de informações
  const grid = document.getElementById('modalInfoGrid');
  grid.innerHTML = data.infos.map(info => `
    <div class="modal-info-item">
      <i class="${info.icone}" style="color: var(--teal)"></i>
      <div>
        <strong>${info.titulo}</strong>
        <span>${info.texto}</span>
      </div>
    </div>
  `).join('');

  // Abre o modal
  overlay.classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeModal() {
  const overlay = document.getElementById('modalOverlay');
  if (overlay) overlay.classList.remove('open');
  document.body.style.overflow = '';
}

// Fechar modal com ESC
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') closeModal();
});


/* =============================================
   MODAL DE NOTÍCIAS
============================================= */
let noticiasCache = [];

// Carrega os dados das notícias injetados pelo Flask
const noticiasScript = document.getElementById('noticiasData');
if (noticiasScript) {
  try {
    noticiasCache = JSON.parse(noticiasScript.textContent);
  } catch (e) {
    noticiasCache = [];
  }
}

function openNoticiaModal(index) {
  const noticia  = noticiasCache[index];
  const overlay  = document.getElementById('noticiaModalOverlay');

  if (!noticia || !overlay) return;

  // Preenche os dados
  document.getElementById('noticiaModalCategoria').textContent = noticia.categoria || 'Geral';
  document.getElementById('noticiaModalTitulo').textContent    = noticia.titulo    || '';
  document.getElementById('noticiaModalData').textContent      = noticia.data      || '';
  document.getElementById('noticiaModalAutor').textContent     = noticia.autor     || 'Secretaria';
  document.getElementById('noticiaModalResumo').textContent    = noticia.resumo    || '';
  document.getElementById('noticiaModalConteudo').textContent  = noticia.conteudo  || '';

  // Imagem
  const imagemWrap = document.getElementById('noticiaModalImagemWrap');
  if (noticia.imagem) {
    imagemWrap.innerHTML = `
      <img src="${noticia.imagem}"
           alt="${noticia.titulo}"
           onerror="this.parentElement.innerHTML='<div class=noticia-modal-imagem-placeholder><i class=fas fa-newspaper></i></div>'">
    `;
  } else {
    imagemWrap.innerHTML = `
      <div class="noticia-modal-imagem-placeholder">
        <i class="fas fa-newspaper"></i>
      </div>
    `;
  }

  // Abre o modal
  overlay.classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeNoticiaModal(event) {
  // Fecha se clicou no overlay ou no botão fechar
  if (event && event.target !== document.getElementById('noticiaModalOverlay')) return;

  const overlay = document.getElementById('noticiaModalOverlay');
  if (overlay) overlay.classList.remove('open');
  document.body.style.overflow = '';
}

// Fecha com ESC
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') {
    const overlay = document.getElementById('noticiaModalOverlay');
    if (overlay && overlay.classList.contains('open')) {
      overlay.classList.remove('open');
      document.body.style.overflow = '';
    }
  }
});