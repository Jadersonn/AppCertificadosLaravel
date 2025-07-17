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


/*function animarBarraProgresso(valorFinal) {
    const barra = document.getElementById('progressBar');
    let valorAtual = 0;
    const intervalo = setInterval(() => {
        if (valorAtual >= valorFinal) {
            clearInterval(intervalo);
        } else {
            valorAtual++;
            barra.style.width = valorAtual + '%';
            barra.setAttribute('aria-valuenow', valorAtual);
            barra.textContent = valorAtual + '%';
        }
    }, 10); // velocidade da animação
}*/

