var login = document.getElementById('login');
var password = document.getElementById('password');
var meter = document.getElementById('password-strength-meter');

password.addEventListener('input', function() {
    var nomDeCompte = login.value;
    var mdp = password.value;
    var resultat = zxcvbn(mdp, [nomDeCompte]);

    //Update la barre de force
    meter.value = resultat.score;
});