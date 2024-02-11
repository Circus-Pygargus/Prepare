document.addEventListener('DOMContentLoaded', () => {
    const formToAutoFill = document.querySelector('form[name="change_user_role"]');

    if (formToAutoFill) {
        const autoFillFormBtns = document.querySelectorAll('.user-role-form-activator');

        const formActivatorBtnClicked = (event) => {
            const activatorBtn = event.target;
            formToAutoFill.querySelector('#change_user_role_username').value = activatorBtn.dataset.name;
            formToAutoFill.querySelector('#change_user_role_wantedBiggestRole').value = activatorBtn.dataset.roleWanted;
            formToAutoFill.submit();
        };

        autoFillFormBtns.forEach(activatorBtn => {
            activatorBtn.addEventListener('click', formActivatorBtnClicked);
        });
    }
});
