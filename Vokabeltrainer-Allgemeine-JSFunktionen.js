function loadLoginLogoutLink() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "Vokabeltrainer-Prüfung-Benutzer-Menue.php", true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            const linkContainer = document.getElementById("login-logout-link");
            if (linkContainer) {
                linkContainer.innerHTML = xhr.responseText;
            } else {
                console.error("Element mit ID 'login-logout-link' nicht gefunden.");
            }
        } else {
            console.error("Fehler beim Abrufen des Login/Logout-Links:", xhr.status);
        }
    };
    xhr.onerror = function () {
        console.error("Netzwerkfehler beim Abrufen des Login/Logout-Links.");
    };
    xhr.send();
}

document.addEventListener("DOMContentLoaded", loadLoginLogoutLink);