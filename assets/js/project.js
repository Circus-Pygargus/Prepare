document.addEventListener('DOMContentLoaded', () => {
    const contributorsFormModal = document.querySelector('#contributors-form-modal');
    const addCategoryFormModal = document.querySelector('#add-category-form-modal');

    if (contributorsFormModal) {
        const contributorsFormBtn = document.querySelector('#contributors-form-activator');

        const showContributorsForm = () => {
            contributorsFormModal.classList.remove('hidden');
        };

        contributorsFormBtn.addEventListener('click', showContributorsForm);
    }

    if (addCategoryFormModal) {
        const addCategoryFormBtn = document.querySelector('#add-category-form-activator');

        const showAddCategoryForm = () => {
            addCategoryFormModal.classList.remove('hidden');
        };

        addCategoryFormBtn.addEventListener('click', showAddCategoryForm);
    }
});
