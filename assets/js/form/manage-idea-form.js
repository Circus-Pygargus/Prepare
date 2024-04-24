document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form[name="idea"]');

    if (form) {
        const ideaTypeSelect = form.querySelector('select#idea_type');
        const measurementTypeSelect = form.querySelector('select#idea_measurementType');

        measurementTypeSelect.closest('div').classList.add('hidden');

        ideaTypeSelect.addEventListener('change', e => {
            measurementTypeSelect.closest('div').classList.add('hidden');
            Object.values(ideaTypeSelect.options).forEach(itOption => {
                if (itOption.selected) {
                    Object.values(measurementTypeSelect.options).forEach(mtOption => {
                        mtOption.classList.remove('hidden');
                        if (mtOption.selected) {
                            mtOption.selected = false;
                        }
                        if (mtOption.innerHTML === 'Choisis un type de mesure') {
                            mtOption.selected = true;
                        }
                    });
                    if (itOption.innerHTML === 'objet' || itOption.innerHTML === 'action') {
                        Object.values(measurementTypeSelect.options).forEach(mtOption => {
                            if (mtOption.dataset.ideaType !== itOption.innerHTML) {
                                mtOption.classList.add('hidden');
                            }
                        });
                    }
                }
            });
            measurementTypeSelect.closest('div').classList.remove('hidden');
        });
    }
});
