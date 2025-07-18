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
