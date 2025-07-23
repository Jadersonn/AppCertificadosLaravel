document.addEventListener("DOMContentLoaded", function () {
    // Abrir modais
    document.querySelectorAll('[data-modal="turma"]').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const modalTurma = document.getElementById('turmaModal');
            if (modalTurma) {
                modalTurma.style.display = 'flex';
            }
        });
    });

    document.querySelectorAll('[data-modal="responsavel"]').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const modalResp = document.getElementById('responsavelModal');
            if (modalResp) {
                modalResp.style.display = 'flex';
            }
        });
    });

    const nomeInput = document.getElementById('nomeAluno');
    const cpfInput = document.getElementById('cpfAluno');
    const turmaInput = document.getElementById('turmaAluno');
    const tbody = document.getElementById('tbodyAdicionarAluno');

    function adicionarAlunoNaTabela() {
        const nome = nomeInput.value.trim();
        const cpf = cpfInput.value.trim();
        const turma = turmaInput.value.trim();

        if (nome && cpf && turma) {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${nome}</td>
                <td>${cpf}</td>
                <td>${turma}</td>
            `;
            tbody.appendChild(tr);
            nomeInput.value = '';
            cpfInput.value = '';
            turmaInput.value = '';
        }
    }

    function filtrarTabelaAluno() {
        const nome = nomeInput.value.toLowerCase();
        const cpf = cpfInput.value.toLowerCase();
        const turma = turmaInput.value.toLowerCase();

        Array.from(tbody.querySelectorAll('tr')).forEach(function (row) {
            const tdNome = row.children[1]?.textContent.toLowerCase() || '';
            const tdCpf = row.children[2]?.textContent.toLowerCase() || '';
            const tdTurma = row.children[3]?.textContent.toLowerCase() || '';

            if ((nome === '' || tdNome.includes(nome)) &&
                (cpf === '' || tdCpf.includes(cpf)) &&
                (turma === '' || tdTurma.includes(turma))) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    [nomeInput, cpfInput, turmaInput].forEach(input => {
        input.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                adicionarAlunoNaTabela();
            }
        });
        input.addEventListener('input', filtrarTabelaAluno);
    });

    // Fechar modais
    const fecharTurma = document.getElementById('fechar-modal-turma');
    if (fecharTurma) {
        fecharTurma.onclick = function () {
            const modalTurma = document.getElementById('turmaModal');
            if (modalTurma) modalTurma.style.display = 'none';
        };
    }

    const fecharResponsavel = document.getElementById('fechar-modal-responsavel');
    if (fecharResponsavel) {
        fecharResponsavel.onclick = function () {
            const modalResp = document.getElementById('responsavelModal');
            if (modalResp) modalResp.style.display = 'none';
        };
    }

    // Fechar ao clicar fora
    const modalTurma = document.getElementById('turmaModal');
    if (modalTurma) {
        modalTurma.onclick = function (e) {
            if (e.target === this) this.style.display = 'none';
        };
    }

    const modalResp = document.getElementById('responsavelModal');
    if (modalResp) {
        modalResp.onclick = function (e) {
            if (e.target === this) this.style.display = 'none';
        };
    }
});
