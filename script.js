// script.js

// Add hover effects to buttons
document.querySelectorAll('.btn').forEach(button => {
    button.addEventListener('mouseenter', () => {
        button.style.transform = 'scale(1.05)'; // Slightly enlarge button on hover
    });

    button.addEventListener('mouseleave', () => {
        button.style.transform = 'scale(1)'; // Reset button size on mouse leave
    });
});

// Add a simple fade-in animation to the container
const container = document.querySelector('.container');
window.addEventListener('load', () => {
    container.style.opacity = '0';
    container.style.transform = 'translateY(-20px)';
    setTimeout(() => {
        container.style.opacity = '1';
        container.style.transform = 'translateY(0)';
        container.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
    }, 100);
});