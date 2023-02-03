function retrive_user_activity() {
    let usernames = Array.from(document.getElementsByName("user-username"));
    axios.get("api-get-active-users.php").then(response => {
        usernames.forEach(username => { document.getElementById(username.value).innerHTML = getDate(response.data[username.value]) });
    });    
}

function getDate(last_activity) {
    return (Date.now() - new Date(last_activity)) <= 10_000 ? "Online" : "Last active: " + last_activity;
}


setInterval(() => { retrive_user_activity() }, 500); // get user status once every 5 seconds
