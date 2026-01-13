document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            alert.style.transition = 'opacity 0.5s ease-out, height 0.5s ease-out';
            alert.style.opacity = '0';
            alert.style.height = alert.offsetHeight + 'px';
            setTimeout(function() {
                alert.style.height = '0';
                alert.style.margin = '0';
                alert.style.padding = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            }, 50);
        }, 4000);
    });
});
