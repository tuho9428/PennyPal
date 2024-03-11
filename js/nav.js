
const burgerMenu = document.querySelector('.burger-menu');
const nav = document.querySelector('nav ul');

burgerMenu.addEventListener('click', () => {
    nav.classList.toggle('open');
});

document.addEventListener('click', function(event) {
if (!event.target.closest('.nav-container')) {
  nav.classList.remove('open');
}
});