function createBox() {
        const box = document.createElement('div');
        box.className = 'box';
        box.style.left = `${Math.random() * window.innerWidth}px`;
        box.style.top = `${Math.random() * window.innerHeight}px`;
        return box;
    }

    function animateBox(box) {
        const duration = Math.random() * 1 + 0.5;
        const delay = Math.random() * 3;
        box.style.animation = `twinkle ${duration}s linear ${delay}s infinite`;
    }

    function createShootingStar() {
        const shootingStar = document.createElement('div');
        shootingStar.className = 'shooting-star';

        const startX = Math.random() * window.innerWidth;
        const startY = Math.random() * window.innerHeight;
        const endX = Math.random() * window.innerWidth;
        const endY = Math.random() * window.innerHeight;
        const angle = Math.atan2(endY - startY, endX - startX) * (180 / Math
            .PI);

        shootingStar.style.left = `${startX}px`;
        shootingStar.style.top = `${startY}px`;
        shootingStar.style.transform = `rotate(${angle}deg)`;
        return shootingStar;
    }

    function animateShootingStar(shootingStar) {
        const duration = Math.random() * 3 + 2;
        shootingStar.style.animation = `shooting ${duration}s linear forwards`;
        shootingStar.addEventListener('animationend', function() {
            shootingStar.remove();
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const magicArea = document.getElementById('magicArea');
        const numBoxes = 50;
        const shootingStarInterval = 5000;

        for (let i = 0; i < numBoxes; i++) {
            const box = createBox();
            animateBox(box);
            magicArea.appendChild(box);
        }

        setInterval(function() {
            const shootingStar = createShootingStar();
            magicArea.appendChild(shootingStar);
            animateShootingStar(shootingStar);
        }, shootingStarInterval);
    });