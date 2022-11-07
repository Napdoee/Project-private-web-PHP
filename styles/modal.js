var btn = document.getElementById('ModalBtn');
var span = document.getElementsByClassName("close")[0];
var modal = document.getElementById('myModal');

btn.onclick = function() {
    modal.style.display = "block";
}

span.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}