const openBtn = document.getElementById('openLogin');
const modal = document.getElementById('loginModal');
const closeBtn = document.getElementById('closeModal');

openBtn.onclick = function() {
    modal.style.display = "flex";
}

closeBtn.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
