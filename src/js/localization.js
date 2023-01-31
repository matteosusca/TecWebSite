function initialize() {
    google.maps.visualRefresh = true;

    var mapOptions = {
        zoom: 15,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            $.ajax({
                url: "receiver.php",
                type: "POST",
                data: { "data": JSON.stringify(pos) },
                success: function (response) {
                    console.log(response);
                }
            });
            $(document).ready(function () {
                for (var user in positions) {
                    new google.maps.InfoWindow({
                        position: JSON.parse(positions[user]),
                        map: map,
                        content: user
                    });
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



