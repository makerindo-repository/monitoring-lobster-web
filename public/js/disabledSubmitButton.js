(function(){
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            let btn = this.querySelector('button[type="submit"]');
                btn.setAttribute('disabled', true);
        });
    });
})();