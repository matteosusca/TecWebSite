const DECLINE_ENDPOINT = 'decline.php?sender=';


//add onclick event to the accept button
document.getElementById("decline").onclick = function() {
    const sender = document.getElementById("sender").value;
    const url = DECLINE_ENDPOINT + sender;
    fetch(url);
    showNotifications();
}