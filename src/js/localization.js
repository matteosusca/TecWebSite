

async function show() {
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
            var infoWindow = new google.maps.InfoWindow({
                position: JSON.parse(response.data[user]),
                map: map,
                content: user,
            });
            infoWindows.push(infoWindow);
        }
    });
    await update(map, infoWindows);
    setInterval(() => { update(map, infoWindows) }, 10000);
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            //update current sessions's user position
            var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            map.setCenter(pos);
        });
    }
}

async function update(map, infoWindows) {
    console.log("updating");
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
                let infoWindow = new google.maps.InfoWindow({
                    position: JSON.parse(response.data[user]),
                    map: map,
                    content: user,
                });
                infoWindows.push(infoWindow);
            }
        }
    });
}

async function setPosition() {
    //update current sessions's user position
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(async function (position) {
            let pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            axios.post("api_set_user_position.php", {
                "data": JSON.stringify(pos)
            });
        });
    }

}

async function initialize() {
    await setPosition();
    setInterval(() => { setPosition() }, 10000);
    if (document.getElementById("map")) {
        show();
    }
}


