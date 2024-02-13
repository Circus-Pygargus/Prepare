document.addEventListener('DOMContentLoaded', () => {
    const formName = 'change_user_is_active';
    const formToAutoFill = document.querySelector('form[name="'+formName+'"]');

    if (formToAutoFill) {
        const autoFillFormBtns = document.querySelectorAll('.user-is-active-form-activator');
        const confirmationModal = document.querySelector('#confirmation-modal');
        const confirmationModalMessageDisplayer = confirmationModal.querySelector('.confirmation-modal_message');
        const confirmationModalConfirmBtn = confirmationModal.querySelector('#confirmation-modal-confirm');
        const confirmationModalCancelBtn = confirmationModal.querySelector('#confirmation-modal-cancel');

        const formActivatorBtnClicked = (event) => {
            const clickedElement = event.target;
            let activatorBtn;
            if (!clickedElement.classList.contains('user-is-active-form-activator')) {
                activatorBtn = clickedElement.closest('.user-is-active-form-activator');
            } else {
                activatorBtn = clickedElement;
            }
            const username = activatorBtn.dataset.name;
            const wantedIsActive = activatorBtn.dataset.wantedIsActive === 'true';
            console.log(activatorBtn, activatorBtn.dataset.wantedIsActive, wantedIsActive)
            formToAutoFill.querySelector('#change_user_is_active_username').value = username;
            formToAutoFill.querySelector('#change_user_is_active_wantedIsActive').value = String(wantedIsActive);
            confirmationModalConfirmBtn.dataset.formName = formName;
            openConfirmationModal(username, wantedIsActive);
        };

        const openConfirmationModal = (username, wantedIsActive) => {
            const wantedAction = wantedIsActive ? 'activer' : 'désactiver';
            confirmationModalMessageDisplayer.innerHTML = `T'es vraiment sûr de vouloir ${wantedAction} le compte de ${username} ?`;
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
        });

        confirmationModalCancelBtn.addEventListener('click', hideConfirmationModal);
    }
});
