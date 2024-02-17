document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('form');
    const spinner = document.querySelector('#loading-spinner');

    if (forms && spinner) {
        forms.forEach(form => {
            form.addEventListener('submit', (event) => {
                event.preventDefault();

                if (form.checkValidity()) {
                    spinner.classList.remove('hidden');

                    setTimeout(() => {
                        form.submit();
                    }, 500);
                }
            });
        });
    }
});
