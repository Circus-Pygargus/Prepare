document.addEventListener('DOMContentLoaded', () => {
    const body = document.querySelector('body');
    const formModals = document.querySelectorAll('.form-modal');

    const formNamePrefixes = ['contributors', 'category', 'idea']; // Just fill here =)
    const formInitialData = [];
    for (const formNamePrefix of formNamePrefixes) {
        formInitialData[formNamePrefix] = [];
    }

    const cancelFormBtns = document.querySelectorAll('.cancel-btn');


    const resetForm = (form, initialData) => {
        form.querySelectorAll('input:not([id$="_token"]), select, textarea')
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


    cancelFormBtns.forEach(cancelFormBtn => {
        cancelFormBtn.addEventListener('click', (event) => {
            body.classList.remove('overflow-hidden');
            resetForm(event.target.closest('form'), formInitialData[event.target.dataset.form]);
            cancelFormBtn.closest('.form-modal').classList.add('hidden');
        });
    });


    if (formModals) {
        formModals.forEach(formModal => {
            const initialData = {};
            const showFormBtns = document.querySelectorAll('.' + formModal.dataset.name + '-form-activator');

            const showForm = () => {
                body.classList.add('overflow-hidden');
                formModal.classList.remove('hidden');
                formModal.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start',
                });
            }

            formModal.querySelectorAll('input:not([id$="_token"]), select, textarea')
                .forEach(field => {
                    if (field.type === 'checkbox' || field.type === 'radio') {
                        initialData[field.name] = initialData[field.name] || [];
                        initialData[field.name][field.value] = field.checked;
                    } else if (field.tagName.toLowerCase() === 'textarea') {
                        initialData[field.name] = field.textContent;
                    }
                    else {
                        initialData[field.name] = field.value;
                    }
                })
            ;
            formInitialData[formModal.dataset.name] = initialData;


            showFormBtns.forEach(showFormBtn => {
                showFormBtn.addEventListener('click', () => {
                    // if several btns to show one form, then there's an entity relation
                    if (showFormBtn.dataset.fieldToFill && showFormBtn.dataset.dataToFill) {
                        formModal.querySelector('#' + formModal.dataset.name + '_' + showFormBtn.dataset.fieldToFill).value = showFormBtn.dataset.dataToFill;
                    }
                    showForm();
                });
            });

            formModal.addEventListener('click', (event) => {
                if ( !formModal.classList.contains('hidden') && !formModal.contains(event.target)) {
                    event.stopPropagation();
                    event.preventDefault();
                }
            });
        });
    }
});
