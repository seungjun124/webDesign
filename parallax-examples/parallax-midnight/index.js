let road = document.querySelector("#road");
let mt = document.querySelector("#mountain");
let sky = document.querySelector("#sky");
let moon = document.querySelector("#moon");
let midnight = document.querySelector("#midnight");

window.addEventListener("scroll", () => {
    let scrollY = window.scrollY;
    road.style.top = 0.5 * scrollY + "px";
    mt.style.top = 150 + 0.05 * scrollY + "px";
    moon.style.left = +1.1 * scrollY + "px";
    sky.style.top = -1.2 * scrollY + "px";
    midnight.style.top = 120 + -1.5 * scrollY + "px";
});