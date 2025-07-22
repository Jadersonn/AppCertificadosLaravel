document.addEventListener("DOMContentLoaded", () => {
  const progressCircle = document.querySelector(".progress-circle");
  const progressBar = document.querySelector(".progress-ring-bar");

  if (progressCircle && progressBar) {
    const percentage = parseFloat(progressCircle.getAttribute("data-percentage"));; // obter a porcentagem do atributo data-percentage
    const safePercentage = Math.max(0, Math.min(percentage, 100)); //variavel para manter a porcentagem entre 0 e 100
    const radius = parseFloat(progressCircle.getAttribute("data-radius"));
    const circumference = 2 * Math.PI * radius;

    const offset = circumference - (circumference * safePercentage) / 100;
    document.querySelector('.progress-ring-bar').style.strokeDashoffset = offset; //mostrando a porcentagem na barra de progresso
    console.log(`Porcentagem: ${percentage}, Offset: ${offset}`);
  } else {
    console.error("Elementos da barra de progresso não encontrados.");
  }
});


function abrirModalCategoria(elemento) {
  const tipoId = elemento.getAttribute('data-id');
  const url = `/categorias/modal/${tipoId}`; // Rota que retorna o HTML do modal

  // Exemplo com jQuery
  $('#categoriaModalContent').html('<div class="modal-body text-center p-5">Carregando...</div>');
  fetch(url)
    .then(response => response.text())
    .then(html => {
      document.getElementById('categoriaModalContent').innerHTML = html;
    })
    .catch(error => {
      document.getElementById('categoriaModalContent').innerHTML = '<div class="modal-body text-center p-5 text-danger">Erro ao carregar.</div>';
    });
}

function abrirModalConclusao(elemento) {
  const alunoId = elemento.getAttribute('data-id');
  const url = `/aluno/modal-conclusao/${alunoId}`; // Rota que retorna o HTML do modal

  // Exibe mensagem de carregando
  document.getElementById('modal-conclusao-content').innerHTML = '<div class="modal-body text-center p-5">Carregando...</div>';

  fetch(url)
    .then(response => response.text())
    .then(html => {
      document.getElementById('modal-conclusao-content').innerHTML = html;
      document.getElementById('modal-conclusao').style.display = 'block';
    })
    .catch(error => {
      document.getElementById('modal-conclusao-content').innerHTML = '<div class="modal-body text-center p-5 text-danger">Erro ao carregar.</div>';
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const circle = document.querySelector('.progress-ring-bar');
    const progressCircle = document.querySelector('.progress-circle');
    const pontos = parseInt(progressCircle.getAttribute('data-percentage'), 10);
    const maxPontos = 120;
    const radius = 60;
    const circumference = 2 * Math.PI * radius;

    circle.style.strokeDasharray = circumference;
    // Calcula o offset: quanto maior os pontos, menor o offset
    const offset = circumference - (pontos / maxPontos) * circumference;
    circle.style.strokeDashoffset = offset;
});

