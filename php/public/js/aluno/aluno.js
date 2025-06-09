document.addEventListener("DOMContentLoaded", () => {
  const progressCircle = document.querySelector(".progress-circle");
  const progressBar = document.querySelector(".progress-ring-bar");

  if (progressCircle && progressBar) {
      const percentage = parseFloat(progressCircle.getAttribute("data-percentage"));
      const maxDashArray = parseFloat(progressBar.getAttribute("stroke-dasharray")); // Circunferência do círculo


      // Calcula o deslocamento corretamente
      const offset =   percentages * maxDashArray/ 100;

      // Aplica o deslocamento ajustado
     progressBar.style.strokeDashoffset = offset;

      console.log(`Porcentagem: ${percentages}, Offset: ${offset}`);
  } else {
      console.error("Elementos da barra de progresso não encontrados.");
  }
});