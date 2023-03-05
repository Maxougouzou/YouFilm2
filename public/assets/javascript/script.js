// Sélectionner le bouton et le menu
const button = document.querySelector('#menu-button');
const menu = document.querySelector('#menu');

// Cacher le menu par défaut
menu.style.display = 'none';

// Ajouter un gestionnaire d'événement au bouton
button.addEventListener('click', function() {
    // Vérifier si le menu est caché ou affiché
    if (menu.style.display === 'none') {
        // Afficher le menu
        menu.style.display = 'block';
    } else {
        // Cacher le menu
        menu.style.display = 'none';
    }
});