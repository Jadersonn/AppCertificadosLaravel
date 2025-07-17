document.addEventListener("DOMContentLoaded", function () {
    // Abrir modais
    document.querySelectorAll('[data-modal="turma"]').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const modalTurma = document.getElementById('modal-turma');
            if (modalTurma) {
                modalTurma.style.display = 'flex';
            }
        });
    });

    document.querySelectorAll('[data-modal="responsavel"]').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const modalResp = document.getElementById('modal-responsavel');
            if (modalResp) {
                modalResp.style.display = 'flex';
            }
        });
    });

    // Fechar modais
    const fecharTurma = document.getElementById('fechar-modal-turma');
    if (fecharTurma) {
        fecharTurma.onclick = function () {
            const modalTurma = document.getElementById('modal-turma');
            if (modalTurma) modalTurma.style.display = 'none';
        };
    }

    const fecharResponsavel = document.getElementById('fechar-modal-responsavel');
    if (fecharResponsavel) {
        fecharResponsavel.onclick = function () {
            const modalResp = document.getElementById('modal-responsavel');
            if (modalResp) modalResp.style.display = 'none';
        };
    }

    // Fechar ao clicar fora
    const modalTurma = document.getElementById('modal-turma');
    if (modalTurma) {
        modalTurma.onclick = function (e) {
            if (e.target === this) this.style.display = 'none';
        };
    }

    const modalResp = document.getElementById('modal-responsavel');
    if (modalResp) {
        modalResp.onclick = function (e) {
            if (e.target === this) this.style.display = 'none';
        };
    }
});

 