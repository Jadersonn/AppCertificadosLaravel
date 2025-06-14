document.addEventListener("DOMContentLoaded", function () {
    // Para todos os botões "ENVIAR"
    document.querySelectorAll('.enviar-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            document.getElementById('modal-solicitacao').style.display = 'flex';
        });
    });

    document.getElementById('fechar-modal').onclick = function() {
        document.getElementById('modal-solicitacao').style.display = 'none';
    };

    // Fecha ao clicar fora do modal
    document.getElementById('modal-solicitacao').onclick = function(e) {
        if (e.target === this) this.style.display = 'none';
    };

    // Atualiza o status do arquivo
    const inputArquivo = document.getElementById('arquivo');
    const statusArquivo = document.getElementById('arquivo-status');
    inputArquivo.addEventListener('change', function() {
        if (this.files && this.files.length > 0) {
            statusArquivo.innerHTML = `<span class="arquivo-texto">${this.files[0].name}</span>`;
        } else {
            statusArquivo.innerHTML = `<span class="arquivo-mais">+</span><br><span class="arquivo-texto">Selecione um PDF</span>`;
        }
    });
});