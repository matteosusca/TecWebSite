function retrive_user_activity() {
    axios.get("api-active-users.php").then(response => {
        console.log(response);
    });    
}

setInterval(() => { retrive_user_activity() }, 5000); // get user status once every 5 seconds
