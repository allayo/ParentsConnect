document.addEventListener('DOMContentLoaded', function() {
    const likeButtons = document.querySelectorAll('.likeBtn');
    likeButtons.forEach(button => {
        button.addEventListener('click', function() {
            if (!this.classList.contains('liked')) {
                this.classList.add('liked');
                this.innerHTML += ' liked';
            }
        });
    });
});