document.addEventListener('DOMContentLoaded', function () {

    // Konfirmasi sebelum menghapus data
    document.querySelectorAll('.btn-delete-confirm').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            var pesan = btn.getAttribute('data-confirm-message') || 'Apakah Anda yakin ingin menghapus data ini?';
            if (!confirm(pesan)) {
                e.preventDefault();
            }
        });
    });

    // Auto hide alert Bootstrap setelah beberapa detik
    document.querySelectorAll('.alert-auto-hide').forEach(function (alert) {
        setTimeout(function () {
            var bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            bsAlert.close();
        }, 4000);
    });

    // Smooth scroll sederhana untuk anchor link (#id)
    document.querySelectorAll('a[href^="#"]:not([href="#"])').forEach(function (link) {
        link.addEventListener('click', function (e) {
            var target = document.querySelector(link.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

});
