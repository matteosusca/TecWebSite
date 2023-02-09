function update_user_activity() {
    axios.post("api_set_active_user.php").then(response => {
        console.log(response);
    });
}

setInterval(() => { update_user_activity() }, 500); // update user status once every 500 msec 