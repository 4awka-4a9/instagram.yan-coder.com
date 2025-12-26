const getId = (id) => document.getElementById(id);
const getSl = (selector) => document.querySelector(selector);

const password = getId("password");
const show_hide_password = getId("show_hide_password");

const imageElement = getSl(".heroImg");
let slideIndex = 0;
const IMAGE_DATA = [
    "images/1.png",
    "images/2.png",
    "images/3.png",
    "images/4.png",
];

if (password) {

    show_hide_password.addEventListener("click", function(){

        if (password.type === "password") {

            password.type = "text";
            show_hide_password.innerText = "Hide";

        } 
        else {

            password.type = "password";
            show_hide_password.innerText = "Show";

        }

    })

    function showSlides() {

        const slider = () => {
            slideIndex++;
            imageElement.style.backgroundImage = `url("${IMAGE_DATA[slideIndex]}")`;

            if (slideIndex == 3) slideIndex =- 1; 

        }

        let timer = setInterval(slider, 3000)

    }

    showSlides();

}

