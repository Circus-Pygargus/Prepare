document.addEventListener('DOMContentLoaded', () => {
    const formToAutoFill = document.querySelector('form[name="change_user_role"]');

    if (formToAutoFill) {
        const autoFillFormBtns = document.querySelectorAll('.user-role-form-activator');
        const confirmationModal = document.querySelector('#confirmation-modal');
        const confirmationModalMessageDisplayer = confirmationModal.querySelector('.confirmation-modal_message');
        const confirmationModalConfirmBtn = confirmationModal.querySelector('#confirmation-modal-confirm');
        const confirmationModalCancelBtn = confirmationModal.querySelector('#confirmation-modal-cancel');

        const formActivatorBtnClicked = (event) => {
            const activatorBtn = event.target;
            const username = activatorBtn.dataset.name;
            const roleWanted = activatorBtn.dataset.roleWanted;
            formToAutoFill.querySelector('#change_user_role_username').value = username;
            formToAutoFill.querySelector('#change_user_role_wantedBiggestRole').value = roleWanted;
            openConfirmationModal(username, roleWanted);
        };

        const openConfirmationModal = (username, wantedRole) => {
            confirmationModalMessageDisplayer.innerHTML = `T'es vraiment sûr de vouloir réattribuer le rôle ${wantedRole} à ${username} ?`;
            confirmationModal.classList.remove('d-none');
        };

        autoFillFormBtns.forEach(activatorBtn => {
            activatorBtn.addEventListener('click', formActivatorBtnClicked);
        });

        const sendForm = () => {
            formToAutoFill.submit();
        };

        const hideConfirmationModal = () => {
            confirmationModal.classList.add('d-none');
        };

        confirmationModalConfirmBtn.addEventListener('click', sendForm);

        confirmationModalCancelBtn.addEventListener('click', hideConfirmationModal);
    }
});
