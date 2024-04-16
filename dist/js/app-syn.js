document.addEventListener('DOMContentLoaded', function () {
    let isDragging = false;
    let startPosition = 0;
    let currentPosition = 0;

    const swipeButton = document.querySelector('.btn-light-success');
    const slider = document.getElementById('slider');

    swipeButton.addEventListener('mousedown', function (e) {
        isDragging = true;
        startPosition = e.clientX - slider.offsetLeft;

        document.addEventListener('mousemove', handleDrag);
        document.addEventListener('mouseup', handleRelease);
    });

    function handleDrag(e) {
        if (isDragging) {
            currentPosition = e.clientX - startPosition;

            if (currentPosition > 0 && currentPosition < (document.body.clientWidth - slider.clientWidth)) {
                slider.style.left = currentPosition + 'px';
            }
        }
    }

    function handleRelease() {
        isDragging = false;

        document.removeEventListener('mousemove', handleDrag);
        document.removeEventListener('mouseup', handleRelease);

        // You can add additional logic here if needed
    }
});