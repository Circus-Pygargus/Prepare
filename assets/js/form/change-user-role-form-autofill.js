document.addEventListener('DOMContentLoaded', () => {
    const formName = 'change_user_role';
    const formToAutoFill = document.querySelector('form[name="'+formName+'"]');

    if (formToAutoFill) {
        const autoFillFormBtns = document.querySelectorAll('.user-role-form-activator');
        const confirmationModal = document.querySelector('#confirmation-modal');
        const confirmationModalMessageDisplayer = confirmationModal.querySelector('.confirmation-modal_message');
        const confirmationModalConfirmBtn = confirmationModal.querySelector('#confirmation-modal-confirm');
        const confirmationModalCancelBtn = confirmationModal.querySelector('#confirmation-modal-cancel');

        const formActivatorBtnClicked = (event) => {
            const clickedElement = event.target;
            let activatorBtn;
            if (!clickedElement.classList.contains('user-role-form-activator')) {
                activatorBtn = clickedElement.closest('.user-role-form-activator');
            } else {
                activatorBtn = clickedElement;
            }
            const username = activatorBtn.dataset.name;
            const roleWanted = activatorBtn.dataset.roleWanted;
            formToAutoFill.querySelector('#change_user_role_username').value = username;
            formToAutoFill.querySelector('#change_user_role_wantedBiggestRole').value = roleWanted;
            confirmationModalConfirmBtn.dataset.formName = formName;
            openConfirmationModal(username, roleWanted);
        };

        const openConfirmationModal = (username, wantedRole) => {
            confirmationModalMessageDisplayer.innerHTML = `T'es vraiment sûr de vouloir attribuer le rôle ${wantedRole} à ${username} ?`;
            confirmationModal.classList.remove('hidden');
        };

        autoFillFormBtns.forEach(activatorBtn => {
            activatorBtn.addEventListener('click', formActivatorBtnClicked);
        });

        const sendForm = (btnClicked) => {
            document.querySelector('form[name="'+btnClicked.dataset.formName+'"]').submit();
        };

        const hideConfirmationModal = () => {
            confirmationModal.classList.add('hidden');
        };

        confirmationModalConfirmBtn.addEventListener('click', (event) => {
            sendForm(event.target);
        } );

        confirmationModalCancelBtn.addEventListener('click', hideConfirmationModal);
    }
});
