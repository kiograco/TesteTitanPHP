// Validação básica dos formulários de autenticação.
document.querySelectorAll('#form-login, #form-cadastro').forEach(function (form) {
    form.addEventListener('submit', function (evento) {
        var vazio = Array.from(form.querySelectorAll('input[required]'))
            .some(function (campo) {
                return !campo.value.trim();
            });

        if (vazio) {
            evento.preventDefault();
            alert('Preencha todos os campos.');
            return;
        }

        var email = form.querySelector('input[type="email"]');

        if (email) {
            var emailValido = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim());

            if (!emailValido) {
                evento.preventDefault();
                alert('Digite um e-mail válido.');
                email.focus();
            }
        }
    });
});