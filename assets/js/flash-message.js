const flashMsgs = document.querySelectorAll('.flash-message');

flashMsgs.forEach(flashMsg => {
    const closeBtn = flashMsg.querySelector('button');

    closeBtn.addEventListener('click', () => {
        flashMsg.classList.add('hidden');
    });
})
