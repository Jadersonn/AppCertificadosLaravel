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