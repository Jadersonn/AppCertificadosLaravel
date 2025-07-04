document.addEventListener("DOMContentLoaded", function () {
    // Abrir o modal ao clicar no botão "ENVIAR"
    document.querySelectorAll('.enviar-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            document.getElementById('modal-solicitacao').style.display = 'flex';
        });
    });

    // Fechar modal ao clicar no botão fechar
    document.getElementById('fechar-modal').onclick = function() {
        document.getElementById('modal-solicitacao').style.display = 'none';
    };

    // Fechar modal ao clicar fora do conteúdo
    document.getElementById('modal-solicitacao').onclick = function(e) {
        if (e.target === this) this.style.display = 'none';
    };

    // Atualiza o nome do arquivo selecionado
    const inputArquivo = document.getElementById('arquivo');
    const statusArquivo = document.getElementById('arquivo-status');
    if (inputArquivo && statusArquivo) {
        inputArquivo.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                statusArquivo.innerHTML = `<span class="arquivo-texto">${this.files[0].name}</span>`;
            } else {
                statusArquivo.innerHTML = `<span class="arquivo-mais">+</span><br><span class="arquivo-texto">Selecione um PDF</span>`;
            }
        });
    }

    // Ajusta largura do select (caso ele exista)
    function ajustarLarguraSelect(select) {
        if (!select || !(select instanceof Element)) return;

        const temp = document.createElement('span');
        temp.style.visibility = 'hidden';
        temp.style.position = 'fixed';
        temp.style.font = window.getComputedStyle(select).font;
        temp.innerText = select.options[select.selectedIndex].text;
        document.body.appendChild(temp);
        select.style.width = (temp.offsetWidth + 48) + 'px'; // margem extra
        document.body.removeChild(temp);
    }

    //verificando a existencia do elemento
    const select = document.getElementById('auto-width-select');
    if (select) {
        ajustarLarguraSelect(select);
        select.addEventListener('change', function() {
            ajustarLarguraSelect(this);
        });
    }
});
