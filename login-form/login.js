const regLink = document.querySelector('.register-form');
const logLink = document.querySelector('.login-form');

function loginFunc() {
    logLink.classList.toggle("active");
    regLink.classList.toggle("active");
}

function registerFunc() {
    logLink.classList.toggle("active");
    regLink.classList.toggle("active");
}

const passwordInput = document.getElementById("reg-password");
const confirmPasswordInput = document.getElementById("confirm");
const passwordError = document.getElementById("password-error");

confirmPasswordInput.addEventListener('input', function () {
    if (confirmPasswordInput.value !== passwordInput.value) {
        passwordError.textContent = "Passwords don't match";
    }
    else {
        passwordError.textContent = "";
    }
    if (passwordInput == "") {
        passwordError.textContent = "";
    }
})    

