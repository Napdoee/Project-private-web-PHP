function ToggleNav(){
    var sidenav = document.getElementById("sidenav");
    var main = document.getElementById("main");

    sidenav.classList.toggle("toggleNav");
    
    if(sidenav.className == "sidenav") {
        main.style.marginLeft = "155px";
    } else {
        main.style.marginLeft = "0px";
    }
}

function ChangeTheme(){
    var body = document.body;

    body.classList.toggle("theme");

    let theme = "dark";

    if(body.classList.contains("theme")){
        theme = "light";
    }

    document.cookie = "theme="+ theme;
}