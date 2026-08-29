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

var formFiltros = document.getElementById('form-filtros');

if (formFiltros) {
    formFiltros.addEventListener('submit', function (evento) {
        var inicial = formFiltros.querySelector('#data_inicial').value;
        var final = formFiltros.querySelector('#data_final').value;

        // Datas no formato YYYY-MM-DD comparam certo como string, sem precisar converter pra Date.
        if (inicial && final && final < inicial) {
            evento.preventDefault();
            alert('A data final não pode ser menor que a inicial.');
        }
    });
}