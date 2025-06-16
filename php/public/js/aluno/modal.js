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

    // Ajusta a largura do select conforme o texto selecionado
    function ajustarLarguraSelect(select) {
        const temp = document.createElement('span');
        temp.style.visibility = 'hidden';
        temp.style.position = 'fixed';
        temp.style.font = window.getComputedStyle(select).font;
        temp.innerText = select.options[select.selectedIndex].text;
        document.body.appendChild(temp);
        select.style.width = (temp.offsetWidth + 48) + 'px'; // 48px para padding e seta
        document.body.removeChild(temp);
    }

    const select = document.getElementById('auto-width-select');
    ajustarLarguraSelect(select);
    select.addEventListener('change', function() {
        ajustarLarguraSelect(this);
    });
});