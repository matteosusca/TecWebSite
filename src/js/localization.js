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
                console.log(positions);
                for (var i = 0; i < positions.length; i=i+2) {
                    var infowindow = new google.maps.InfoWindow({
                        position: JSON.parse(positions[i+1]),
                        map: map,
                        content: positions[i]
                    });
                }
            });
            var infowindow = new google.maps.InfoWindow({
                map: map,
                position: pos,
                content: 'my location'
            });
            map.setCenter(pos);
        });
    }
}


