(function(){
    const now = new Date();
    now.setHours(now.getHours() + 1);
    now.setSeconds(0); now.setMilliseconds(0);
    document.getElementById('date_heure').value = now.toISOString().slice(0,16);

    window.changeDur = function(delta){
        const inp = document.getElementById('duree');
        let v = parseInt(inp.value) + delta;
        v = Math.min(300, Math.max(15, v));
        inp.value = v;
        updatePresets(v);
    };

    window.setDur = function(val){
        document.getElementById('duree').value = val;
        updatePresets(val);
    };

    function updatePresets(val){
        document.querySelectorAll('.dur-preset').forEach(p => {
            p.classList.remove('active');
            if(p.onclick?.toString().includes(`setDur(${val})`)) {
                p.classList.add('active');
            }
        });
    }

    document.getElementById('duree').addEventListener('input', function(){
        updatePresets(parseInt(this.value));
    });
})();