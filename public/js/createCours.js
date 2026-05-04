console.log("JS khdam");
(function () {
    const filiereSelect = document.getElementById('filiere_id');
    const moduleSelect  = document.getElementById('module_id');
    const loadingEl     = document.getElementById('loading-modules');
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const step3 = document.getElementById('step3');

    filiereSelect.addEventListener('change', function () {
        const id = this.value;
        moduleSelect.innerHTML = '<option value="">— Choisir un module —</option>';
        moduleSelect.disabled = true;

        step1.className = 'step-item done';
        step2.className = 'step-item active';
        step3.className = 'step-item';

        if (!id) {
            moduleSelect.innerHTML = '<option value="">— Choisir d\'abord une filière —</option>';
            step1.className = 'step-item active';
            step2.className = 'step-item';
            return;
        }

        loadingEl.classList.add('show');

        fetch(`/api/modules/${id}`)
            .then(r => r.json())
            .then(modules => {
                loadingEl.classList.remove('show');
                if (!modules.length) {
                    moduleSelect.innerHTML = '<option value="">Aucun module disponible</option>';
                    return;
                }
                moduleSelect.innerHTML = '<option value="">— Sélectionner un module —</option>';
                modules.forEach(m => {
                    moduleSelect.innerHTML += `<option value="${m.id}">${m.nom}</option>`;
                });
                moduleSelect.disabled = false;
            })
            .catch(() => {
                loadingEl.classList.remove('show');
                moduleSelect.innerHTML = '<option value="">Erreur de chargement</option>';
            });
    });

    moduleSelect.addEventListener('change', function () {
        step2.className = this.value ? 'step-item done' : 'step-item active';
        step3.className = this.value ? 'step-item active' : 'step-item';
    });

    document.getElementById('nom_cours').addEventListener('input', function () {
        step3.className = this.value.trim() ? 'step-item done' : 'step-item active';
    });
})();