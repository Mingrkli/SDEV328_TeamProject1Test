// Global
// ====================================================================
const body = document.querySelector("body");

// Aside show
// ====================================================================
const accountIcon = document.querySelector("#accountIcon");
const navAside = document.querySelector("#navAside");

accountIcon.addEventListener("click", () => {
    navAside.classList.toggle("show");
});

// Login
// ====================================================================
const loginIcon = document.querySelector("#loginIcon");
const loginView = document.querySelector("#loginView");

loginIcon.addEventListener("click", () => {
    loginView.classList.toggle("show");
});

// Color Picker
// ====================================================================
const paletteIcon = document.querySelector("#paletteIcon");
const colorPickerContainer = document.querySelector("#colorPickerContainer");
const colorPickerInputs = document.querySelectorAll(".colorPickerInput");

// Show/hides the expand
paletteIcon.addEventListener("click", () => {
    colorPickerContainer.classList.toggle("show");
});

// Color Pickers :D
const mainColor = document.querySelector(".mainColor");
const secColor = document.querySelector(".secColor");
const textColor = document.querySelector(".textColor");

// Once window loads it will load the color if the user has chosen them
window.addEventListener("DOMContentLoaded", () => {
    checkMode();
});

// When user sets the color :D
colorPickerInputs.forEach((input) => {
    input.addEventListener("input", (e) => {
        let mode = "light";
        let modeLocalStorage = "Light";

        if (body.classList.contains("darkMode")) {
            mode = "dark";
            modeLocalStorage = "Dark";
        }

        if (e.target.classList.contains("mainColor")) {
            localStorage.setItem(
                "mainColor" + modeLocalStorage,
                e.target.value
            );
            document.documentElement.style.setProperty(
                "--c-" + mode + "-main",
                e.target.value
            );
        } else if (e.target.classList.contains("secColor")) {
            localStorage.setItem("secColor" + modeLocalStorage, e.target.value);
            document.documentElement.style.setProperty(
                "--c-" + mode + "-sec",
                e.target.value
            );
        } else if (e.target.classList.contains("textColor")) {
            localStorage.setItem(
                "textColor" + modeLocalStorage,
                e.target.value
            );
            document.documentElement.style.setProperty(
                "--c-" + mode + "-text",
                e.target.value
            );
        }
    });
});
// Function that mainly use to update color picker when changing light/dark modes
const checkMode = () => {
    if (localStorage.getItem("lightDarkMode") != "darkMode") {
        if (localStorage.getItem("mainColorLight") === null) {
            localStorage.setItem("mainColorLight", "#ffffff");
            mainColor.value = "#ffffff";
        } else {
            mainColor.value = localStorage.getItem("mainColorLight");
            document.documentElement.style.setProperty(
                "--c-light-main",
                localStorage.getItem("mainColorLight")
            );
        }

        if (localStorage.getItem("secColorLight") === null) {
            localStorage.setItem("secColorLight", "#0083ff");
            secColor.value = "#0083ff";
        } else {
            secColor.value = localStorage.getItem("secColorLight");
            document.documentElement.style.setProperty(
                "--c-light-sec",
                localStorage.getItem("secColorLight")
            );
        }

        if (localStorage.getItem("textColorLight") === null) {
            localStorage.setItem("textColorLight", "#000000");
            textColor.value = "#000000";
        } else {
            textColor.value = localStorage.getItem("textColorLight");
            document.documentElement.style.setProperty(
                "--c-light-text",
                localStorage.getItem("textColorLight")
            );
        }
    } else {
        if (localStorage.getItem("mainColorDark") === null) {
            localStorage.setItem("mainColorDark", "#141414");
            mainColor.value = "#141414";
        } else {
            mainColor.value = localStorage.getItem("mainColorDark");
            document.documentElement.style.setProperty(
                "--c-dark-main",
                localStorage.getItem("mainColorDark")
            );
        }

        if (localStorage.getItem("secColorDark") === null) {
            localStorage.setItem("secColorDark", "#9544ff");
            secColor.value = "#9544ff";
        } else {
            secColor.value = localStorage.getItem("secColorDark");
            document.documentElement.style.setProperty(
                "--c-dark-sec",
                localStorage.getItem("secColorDark")
            );
        }

        if (localStorage.getItem("textColorDark") === null) {
            localStorage.setItem("textColorDark", "#ffffff");
            textColor.value = "#ffffff";
        } else {
            textColor.value = localStorage.getItem("textColorDark");
            document.documentElement.style.setProperty(
                "--c-dark-text",
                localStorage.getItem("textColorDark")
            );
        }
    }
};

// Light and Dark Mode
// ====================================================================
const lightModeIcon = document.querySelector("#lightModeIcon");
const darkModeIcon = document.querySelector("#darkModeIcon");

window.addEventListener("DOMContentLoaded", () => {
    if (localStorage.getItem("lightDarkMode") == "darkMode") {
        lightModeIcon.classList.add("hidden");
        darkModeIcon.classList.remove("hidden");
        body.classList.add("darkMode");
    }
});

document.querySelector("#light-dark-mode").addEventListener("click", () => {
    // If it's not on dark mode
    if (!body.classList.contains("darkMode")) {
        lightModeIcon.classList.add("hidden");
        darkModeIcon.classList.remove("hidden");
        body.classList.add("darkMode");
        localStorage.setItem("lightDarkMode", "darkMode");
    } else {
        lightModeIcon.classList.remove("hidden");
        darkModeIcon.classList.add("hidden");
        body.classList.remove("darkMode");
        localStorage.setItem("lightDarkMode", "lightMode");
    }

    checkMode();
});
