async function initialize() {
    google.maps.visualRefresh = true;
    var map = new google.maps.Map(document.getElementById('map'), {
        mapId: "74b0e77f9be9730b",
        zoom: 10,
    });
    //print all other users on map
    await axios.post("api_get_users_position.php").then(response => {
        console.log(response.data);
        for (var user in response.data) {
            if (!response.data[user]) continue;
            new google.maps.InfoWindow({
                position: JSON.parse(response.data[user]),
                map: map,
                content: user,
            });
        }
    });
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            //update current sessions's user position
            var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            axios.post("api_set_user_position.php", {
                "data": JSON.stringify(pos)
            });
            //print user on map
            new google.maps.InfoWindow({
                position: pos,
                map: map,
                content: "my position",
            });
            map.setCenter(pos);
        });
    }
}


