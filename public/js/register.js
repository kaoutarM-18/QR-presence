function checkStrength(val) {
    const bar = document.getElementById('strength-bar');
    let strength = 0;
    if (val.length >= 6) strength++;
    if (val.length >= 10) strength++;
    if (/[A-Z]/.test(val)) strength++;
    if (/[0-9]/.test(val)) strength++;
    if (/[^A-Za-z0-9]/.test(val)) strength++;

    const colors = ['#ef4444','#f59e0b','#f59e0b','#10b981','#10b981'];
    const widths = ['20%','40%','60%','80%','100%'];

    bar.style.width   = strength > 0 ? widths[strength-1] : '0%';
    bar.style.background = strength > 0 ? colors[strength-1] : 'transparent';
}


function toggleFiliere() {
    let etudiant = document.getElementById('role-etudiant');
    let filiereField = document.getElementById('filiere-field');

    if (etudiant.checked) {
        filiereField.style.display = 'block';
    } else {
        filiereField.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    toggleFiliere();
});

document.getElementById('role-etudiant').addEventListener('change', toggleFiliere);
document.getElementById('role-enseignant').addEventListener('change', toggleFiliere);
