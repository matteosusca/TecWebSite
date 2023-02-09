function retrive_user_activity() {
    let usernames = Array.from(document.getElementsByName("user-username"));
    axios.get("api_get_active_users.php").then(response => {
        usernames.forEach(username => { 
            let status = getStatus(response.data[username.value]);
            updateText(username.value, status);
            updateIcon(username.value, status);
        });
    });    
}

// compare the last activity of the user with the current time in order to understand if the user is online or not
function getStatus(last_activity) {
    return (Date.now() - new Date(last_activity)) <= 10_000 ? "Online" : "Last active: " + last_activity;
}

// update the text of the user status
function updateText(username, status) {
    let text = document.getElementById(username);
    if(text) {
        text.innerHTML = status;
    }
}

// update the icon of the user status (green if online, grey if offline)
function updateIcon(username, status) {
    let icon = document.getElementById(username + "-span");
    if(icon) {
        status === "Online" ? icon.classList.add("bg-success") : icon.classList.remove("bg-success");
    }

}

setInterval(() => { retrive_user_activity() }, 500); // get user status once every 5 seconds
