function onScanSuccess(decodedText) {

    window.location.href = decodedText;
}

let scanner = new Html5QrcodeScanner("reader", {
    fps: 10,
    qrbox: 250
});

scanner.render(onScanSuccess);


setTimeout(() => {
    let success = document.getElementById('flash-success');
    let alert = document.getElementById('flash-alert');

    if (success) {
        success.style.transition = "0.5s";
        success.style.opacity = "0";
        setTimeout(() => success.remove(), 500);
    }

    if (alert) {
        alert.style.transition = "0.5s";
        alert.style.opacity = "0";
        setTimeout(() => alert.remove(), 500);
    }
}, 2000);