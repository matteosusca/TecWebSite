function update_user_activity() {
    axios.post("api-set-active-user.php").then(response => {
        console.log(response);
    });
}

setInterval(() => { update_user_activity() }, 5000); // update user status once every 5 seconds