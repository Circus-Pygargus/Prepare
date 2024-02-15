document.addEventListener('DOMContentLoaded', () => {
    const contributorsFormModal = document.querySelector('#contributors-form-modal');
    const addCategoryFormModal = document.querySelector('#add-category-form-modal');
    const addItemModal = document.querySelector('#add-item-form-modal');

    const initialContributors = {};
    const initialCategory = {};
    const initialItem = {};
    const formDataObjects = [];
    const cancelFormBtns = document.querySelectorAll('.cancel-btn');

    const resetForm = (form, initialData) => {
        form.querySelectorAll('input:not([type="hidden"]), select:not([type="hidden"]), textarea')
            .forEach(field => {
                const fieldName = field.name;
                if (field.type === 'checkbox' || field.type === 'radio') {
                    field.checked = initialData[fieldName][field.value] || false;
                } else {
                    field.value = initialData[fieldName];
                }
            }
        );
    };

    document.querySelector('form[name="project_contributors"]')
    .querySelectorAll('input:not([type="hidden"]), select:not([type="hidden"]), textarea')
            .forEach(field => {
                if (field.type === 'checkbox' || field.type === 'radio') {
                    initialContributors[field.name] = initialContributors[field.name] || [];
                    initialContributors[field.name][field.value] = field.checked;
                } else if (field.tagName.toLowerCase() === 'textarea') {
                    initialContributors[field.name] = field.textContent;
                }
                else {
                    initialContributors[field.name] = field.value;
                }
            });
    formDataObjects.initialContributors = initialContributors;

    document.querySelector('form[name="category"]')
    .querySelectorAll('input:not([type="hidden"]), select:not([type="hidden"]), textarea')
        .forEach(field => {
            if (field.type === 'checkbox' || field.type === 'radio') {
                initialCategory[field.name] = initialCategory[field.name] || [];
                initialCategory[field.name][field.value] = field.checked;
            } else if (field.tagName.toLowerCase() === 'textarea') {
                initialCategory[field.name] = field.textContent;
            }
            else {
                initialCategory[field.name] = field.value;
            }
        }
    );
    formDataObjects.initialCategory = initialCategory;

    document.querySelector('form[name="item"]')
        .querySelectorAll('input:not([type="hidden"]), select:not([type="hidden"]), textarea')
            .forEach(field => {
                if (field.type === 'checkbox' || field.type === 'radio') {
                    initialItem[field.name] = initialItem[field.name] || [];
                    initialItem[field.name][field.value] = field.checked;
                } else if (field.tagName.toLowerCase() === 'textarea') {
                    initialItem[field.name] = field.textContent;
                }
                else {
                    initialItem[field.name] = field.value;
                }
            });
    formDataObjects.initialItem = initialItem;

    cancelFormBtns.forEach(cancelFormBtn => {
        cancelFormBtn.addEventListener('click', (event) => {
            resetForm(event.target.closest('form'), formDataObjects[event.target.dataset.formData]);
            cancelFormBtn.closest('[id$="-form-modal"]').classList.add('hidden');
        });
    });

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
                addItemModal.querySelector('#item_category').value = event.target.dataset.categoryId;
                showEdititemForm();
            });
        });
    }
});
