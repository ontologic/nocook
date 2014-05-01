    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script>
        var directionsDisplay;
        var directionsService = new google.maps.DirectionsService();
        var map;

        function initialize() {
            directionsDisplay = new google.maps.DirectionsRenderer();
            var mapOptions = {
                zoom:7
            }
            map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
            directionsDisplay.setMap(map);
            calcRoute();
        }

        function calcRoute() {
            var request = {
                //origin: "433 Highland Ave NE Atlanta, GA, 30312",
                //destination: "Los Angeles, CA",
                origin: "<?php echo $start; ?>",
                destination: "<?php echo $end; ?>",
                travelMode: google.maps.TravelMode.DRIVING
            };
            directionsService.route(request, function(response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    directionsDisplay.setDirections(response);
                }
            });
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>

<div id="map-canvas" style="height: 75%; width: 50%; margin: 0 auto;"></div>
    <?php echo form_open(null, array('role' => 'form')) ?>
        <input type="submit" value="Mark as Delivered" class="btn btn-default" />
    </form>