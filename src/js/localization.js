

function show() {
    google.maps.visualRefresh = true;
    let map = new google.maps.Map(document.getElementById('map'), {
        mapId: "74b0e77f9be9730b",
        zoom: 10,
        center: new google.maps.LatLng(0, 0),
    });
    let infoWindows = [];
    //print all other users on map
    axios.post("api_get_users_position.php").then(response => {
        for (let user in response.data) {
            if (!response.data[user]) continue;
            infoWindows.push(new google.maps.InfoWindow({
                position: JSON.parse(response.data[user]),
                content: user,
                map: map,
            }));

        }
    });
    setInterval(() => { update(map, infoWindows) }, 10000);
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            //update current sessions's user position
            map.setCenter(new google.maps.LatLng(position.coords.latitude, position.coords.longitude));
        });
    }
}

function update(map, infoWindows) {
    axios.post("api_get_users_position.php").then(response => {
        for (let user in response.data) {
            if (!response.data[user]) continue;
            let userFound = false;
            for (let i = 0; i < infoWindows.length; i++) {
                if (infoWindows[i].content === user) {
                    infoWindows[i].setPosition(JSON.parse(response.data[user]));
                    userFound = true;
                    break;
                }
            }
            if (!userFound) {
                infoWindows.push(new google.maps.InfoWindow({
                    position: JSON.parse(response.data[user]),
                    content: user,
                    map: map,
                }));
            }
        }
    });
}

function setPosition() {
    //update current sessions's user position
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            axios.post("api_set_user_position.php", {
                "data": JSON.stringify(new google.maps.LatLng(position.coords.latitude, position.coords.longitude))
            });
        });
    }

}

function initialize() {
    setInterval(() => { setPosition() }, 10000);
    if (document.getElementById("map")) {
        show();
    }
}


