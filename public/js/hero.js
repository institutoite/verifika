document.addEventListener("scroll", function () {
    const heroImage = document.querySelector(".hero-image img");
    const scrollY = window.scrollY;
    heroImage.style.transform = `translateY(${scrollY * 0.2}px)`;
});
