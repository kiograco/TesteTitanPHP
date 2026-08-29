var formServico = document.getElementById('form-servico');

if (formServico) {
    formServico.addEventListener('submit', function (evento) {
        var descricao = formServico.querySelector('#description').value.trim();
        var preco = parseFloat(formServico.querySelector('#price').value);

        if (!descricao || isNaN(preco) || preco <= 0) {
            evento.preventDefault();
            alert('Preencha a descrição e um valor válido.');
        }
    });
}

document.querySelectorAll('form[action*="service/excluir"]').forEach(function (form) {
    form.addEventListener('submit', function (evento) {
        if (!confirm('Tem certeza que deseja excluir este serviço?')) {
            evento.preventDefault();
        }
    });
});