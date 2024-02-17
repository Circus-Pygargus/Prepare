document.addEventListener('DOMContentLoaded', () => {
    const helpActivators = document.querySelectorAll('.help-activator');

    helpActivators.forEach(activator => {
        activator.addEventListener('click', (event) => {
            const clickedElement = event.target;
            let activatorBtn;
            if (!clickedElement.classList.contains('help-activator')) {
                activatorBtn = clickedElement.closest('.help-activator');
            } else {
                activatorBtn = clickedElement;
            }

            const helper = document.querySelector('#'+activatorBtn.dataset.helperId);

            helper.classList.toggle('hidden');
        });
    });
});
