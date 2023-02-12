const URL_ENDPOINT = 'accept.php?sender=';


//add onclick event to the accept button
document.getElementById("accept").onclick = function() {
    const sender = document.getElementById("sender").value;
    const url = URL_ENDPOINT + sender;
    fetch(url);
    showNotifications();
}