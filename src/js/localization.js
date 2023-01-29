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
                for (var i = 0; i < positions.length; i++) {
                    var infowindow = new google.maps.InfoWindow({
                        position: positions[i+1],
                        map: map,
                        content: positions[i]
                    });
                }
            });
            var infowindow = new google.maps.InfoWindow({
                map: map,
                position: pos,
                content: 'user location'
            });
            map.setCenter(pos);
        });
    }
}



