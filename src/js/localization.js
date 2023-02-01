function initialize() {
    google.maps.visualRefresh = true;

    var map = new google.maps.Map(document.getElementById('map'), {
        mapId: "74b0e77f9be9730b",
        zoom: 10
    });

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            $(document).ready(function () {
                for (var user in positions) {
                    new google.maps.InfoWindow({
                        map: map,
                        position: JSON.parse(positions[user]),
                        content: user
                    });
                }
            });
            var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            $.ajax({
                url: "templates/receiver.php",
                type: "POST",
                data: { "data": JSON.stringify(pos) },
                success: function (response) {
                    console.log(response);
                }
            });
            new google.maps.InfoWindow({
                map: map,
                position: pos,
                content: 'My location'
            });
            map.setCenter(pos);
        });
    }
}



