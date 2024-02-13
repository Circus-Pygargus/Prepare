document.addEventListener('DOMContentLoaded', () => {
    const contributorsFormModal = document.querySelector('#contributors-form-modal');

    if (contributorsFormModal) {
        const contributorsFormBtn = document.querySelector('#contributors-form-activator');

        const showContributorsForm = () => {
            contributorsFormModal.classList.remove('hidden');
        };

        contributorsFormBtn.addEventListener('click', showContributorsForm);
    }
});
