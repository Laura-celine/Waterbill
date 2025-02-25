document.addEventListener("DOMContentLoaded", function() {
    const heroText = document.querySelector(".hero h2");
    heroText.style.opacity = "0";
    heroText.style.transform = "translateY(20px)";

    setTimeout(() => {
        heroText.style.transition = "all 1s";
        heroText.style.opacity = "1";
        heroText.style.transform = "translateY(0)";
    }, 500);
});