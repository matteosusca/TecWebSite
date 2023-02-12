const URL_ENDPOINT = 'accept.php?sender=';


//add onclick event to the accept button
document.getElementById("accept").onclick = function() {
    console.log("accept button clicked");
    const sender = document.getElementById("sender_accept").value;
    const url = URL_ENDPOINT + sender;
    fetch(url);
}

//get user of the accepted user via id sender_accept




