
    /* Toggle pour afficher et masquer le formulaire du profil utilisateur */
    $(document).ready(function() {
        $('#btn-profil').click(function () {
            $('#modif-user').toggleClass('d-block');
        });
        $('#btn-mdp').click(function () {
            $('#modif-mdp').toggleClass('d-block');
        });
    })



    /* Toggle between showing and hiding the navigation menu links when the user clicks on the hamburger menu / bar icon */
    function myFunction() {
        var x = document.getElementById("myLinks");
        if (x.style.display === "flex") {
            x.style.display = "none";
        } else {
            x.style.display = "flex";
        }
    }

/* Galerie des médias */
const diapo_img = document.querySelector(".diapo-images");

if(diapo_img){
    var elements = document.querySelector(".elements");
    var slides = Array.from(elements.children);

    var next = document.querySelector("#nav-droite");
    var prev = document.querySelector("#nav-gauche");

    var compteur = 0 // Compteur qui permettra de savoir sur quelle slide nous sommes
    var timer;
    var elements;
    var slides;
    var slideWidth;

    slideWidth = diapo_img.getBoundingClientRect().width;

    next.addEventListener("click", slideNext);
    prev.addEventListener("click", slidePrev);

    function slideNext(){
        // On incrémente le compteur
        compteur++;
        if(compteur == slides.length){
            compteur = 0;
        }

        let decal = -slideWidth * compteur;
        elements.style.transform = `translateX(${decal}px)`;
    }

    function slidePrev(){
        compteur--;
        if(compteur < 0){
            compteur = slides.length - 1;
        }

        let decal = -slideWidth * compteur;
        elements.style.transform = `translateX(${decal}px)`;
    }

    function stopTimer(){
        clearInterval(timer);
    }

    function startTimer(){
        timer = setInterval(slideNext, 4000);
    }

    var timer = setInterval(slideNext, 4000);

    diapo_img.addEventListener("mouseover", stopTimer);
    diapo_img.addEventListener("mouseout", startTimer);



    window.addEventListener("resize", () => {
        slideWidth = diapo_img.getBoundingClientRect().width;
        slideNext();
    })
}
