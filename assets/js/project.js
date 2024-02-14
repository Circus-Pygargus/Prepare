document.addEventListener('DOMContentLoaded', () => {
    const contributorsFormModal = document.querySelector('#contributors-form-modal');
    const addCategoryFormModal = document.querySelector('#add-category-form-modal');
    const addItemModal = document.querySelector('#add-item-form-modal');

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

    if (addItemModal) {
        const addItemFormBtns = document.querySelectorAll('.add-item-form-activator');

        const showEdititemForm = () => {
            addItemModal.classList.remove('hidden');
        };

        addItemFormBtns.forEach(btn => {
            btn.addEventListener('click', (event) => {
                addItemModal.querySelector('#item_category').value = btn.dataset.categoryId;
                showEdititemForm();
            });
        });
    }
});
