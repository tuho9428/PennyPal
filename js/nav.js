
const burgerMenu1 = document.querySelector('.burger-menu');
const nav1 = document.querySelector('nav ul');

burgerMenu1.addEventListener('click', () => {
    nav1.classList.toggle('open');
});

document.addEventListener('click', function(event) {
if (!event.target.closest('.nav-container')) {
  nav1.classList.remove('open');
}
});