document.addEventListener('DOMContentLoaded', () => {
    const toggleExcerptbtns = document.querySelectorAll('.toggle-excerpt');

    toggleExcerptbtns.forEach(btn => {
        btn.addEventListener('click', (event) => {
            const parentSpan = event.target.closest('div.idea-comment');
            const excerptElement = parentSpan.querySelector('.excerpt');
            const fullTextElement = parentSpan.querySelector('.full-text');

            if (excerptElement && fullTextElement) {
                excerptElement.classList.toggle('hidden');
                fullTextElement.classList.toggle('hidden');
            }
        });
    });
});
