console.log('JS do professor carregado!');

document.addEventListener('DOMContentLoaded', () => {
    const botoesEditar = document.querySelectorAll('.btn-editar');

    botoesEditar.forEach(botao => {
        botao.addEventListener('click', (e) => {
            e.preventDefault();

            const id = botao.getAttribute('data-id');

            fetch(`/certificados/${id}/edit`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(res => res.json())
                .then(cert => {
                    // VERIFIQUE SE ESTES IDS EXISTEM NO SEU HTML!
                    document.getElementById('edit-titulo').value = cert.titulo ?? '';
                    document.getElementById('edit-descricao').value = cert.descricao ?? '';

                    document.getElementById('form-editar').action = `/certificados/${id}`;
                    document.getElementById('modal-editar').style.display = 'block';
                })
                .catch(err => console.error('Erro ao carregar dados do certificado:', err));
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-rejeitar').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();

            // Cria o popup
            const popup = document.createElement('div');
            popup.style.position = 'fixed';
            popup.style.top = '0';
            popup.style.left = '0';
            popup.style.width = '100vw';
            popup.style.height = '100vh';
            popup.style.background = 'rgba(0,0,0,0.5)';
            popup.style.display = 'flex';
            popup.style.alignItems = 'center';
            popup.style.justifyContent = 'center';
            popup.style.zIndex = '9999';

            popup.innerHTML = `
                <div style="background:#fff;padding:30px;border-radius:8px;min-width:300px;box-shadow:0 2px 8px #333;">
                    <h3 style="margin-bottom:15px;">Justificativa da Rejeição</h3>
                    <form class="form-rejeitar-popup" method="POST" action="${btn.dataset.action}">
                        <input type="hidden" name="_token" value="${btn.dataset.csrf}">
                        <input type="text" name="justificativa" placeholder="Justificativa" required style="width:100%;margin-bottom:15px; font-size:14px; padding:6px;">
                        <div style="text-align:center;">
                            <button type="submit" class="professor-card-btn" >Rejeitar</button>
                            <button type="button" class="professor-card-btn btn-cancelar-popup" style="background:#ccc; color:#333;">Cancelar</button>
                        </div>
                    </form>
                </div>
            `;

            document.body.appendChild(popup);

            // Cancelar fecha o popup
            popup.querySelector('.btn-cancelar-popup').onclick = function () {
                document.body.removeChild(popup);
            };

            // Submete o formulário normalmente
            popup.querySelector('.form-rejeitar-popup').onsubmit = function () {
                return true;
            };
        });
    });
});
