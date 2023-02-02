function retrive_user_activity() {
    let usernames = Array.from(document.getElementsByName("user-username"));
    axios.get("api-get-active-users.php").then(response => {
        usernames.forEach(username => { document.getElementById(username.value).innerHTML = response.data[username.value] });
    });    
}

setInterval(() => { retrive_user_activity() }, 500); // get user status once every 5 seconds
