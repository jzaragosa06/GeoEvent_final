<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Monitor Locations - GeoEvent</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer>
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #ffffff;
        }

        #map {
            height: 500px;
            width: 100%;
        }

        #side-panel {
            width: 100%;
            max-height: 700px;
            overflow-y: auto;
            border-left: 1px solid #ccc;
            padding-left: 10px;
        }

        .location-block {
            margin-bottom: 20px;
        }

        .container-fluid {
            margin-top: 30px;
            padding: 20px;
        }

        .collapsible {
            cursor: pointer;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #d6d8f7;
            margin-bottom: 10px;
        }

        .collapsible.active,
        .collapsible:hover {
            background-color: #ddd;
        }

        .collapsible-content {
            display: none;
            overflow: hidden;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 10px;
            background-color: #f9f9f9;
        }

        #nearest-cities-panel {
            width: 100%;
            max-height: 700px;
            overflow-y: auto;
            border-left: 1px solid #ccc;
            padding-left: 10px;
        }

        footer {
            background-color: #333;
            color: white;
            padding: 10px;
        }

        h2 {
            font-size: 2rem;
            font-weight: 600;
            color: rgb(27, 27, 27);
            text-shadow: 0 1px 1px rgb(255, 255, 255);
        }

        i {
            color: rgb(118, 118, 216);
        }

        .nav-item {
            color: white;
            margin-right: 20px;
        }

        .nav-item a {
            color: white;
        }

        .nav-item a:hover {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="{{ route('index') }}">GeoEvent<i class='bx bxs-map'></i></a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <button class="btn btn-success"><a href="{{ route('profile') }}">Account</a></button>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-7">
                <h2>Locations Currently Monitoring<i class='bx bx-current-location'></i></h2>
                <div class="form-group">
                    <label for="map-type">Map Type:</label>
                    <select id="map-type" class="form-control w-50">
                        <option value="roadmap">Roadmap</option>
                        <option value="satellite">Satellite</option>
                        <option value="hybrid">Hybrid</option>
                        <option value="terrain">Terrain</option>
                    </select>
                </div>
                <div id="map" class="mb-4"></div>
            </div>
            <div class="col-lg-5" style="margin-top: 30px;">
                <div class="row">
                    <div class="col-lg-10" style="margin-left: 40px;">
                        <div id="side-panel">
                            <h3>List of Locations and Events</h3>
                            @foreach ($locations as $location)
                                <div class="location-block mb-3">
                                    <div class="collapsible">
                                        <h4>Location: {{ $location->address }}</h4>
                                        <p>{{ $location->description }}</p>
                                    </div>
                                    <div class="collapsible-content">
                                        <ul id="event-list-{{ $location->locid }}"></ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    {{-- <div class="col-lg-4">
                        <div id="nearest-cities-panel" class="mt-4">
                            <h3>Nearest Cities</h3>
                            <p>2 Degree on all sides</p>
                            <div id="nearest-cities-list" class="scrollable"></div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        const locations = @json($locations);
        const events = @json($events);
        let map; // Make the map variable global

        function initMap() {
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 2,
                center: {
                    lat: 0,
                    lng: 0
                },
            });

            const infoWindow = new google.maps.InfoWindow();
            const locationMarkers = [];
            const locationCircles = {};

            events.forEach(event => {
                const coords = event.geometries[0].coordinates;
                const position = {
                    lat: coords[1],
                    lng: coords[0]
                };
                const marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    title: event.title
                });

                marker.addListener('click', () => {
                    infoWindow.setContent(`
                        <div>
                            <h3>${event.title}</h3>
                            <a href="${event.link}" target="_blank">More info</a>
                        </div>
                    `);
                    infoWindow.open(map, marker);
                });
            });

            locations.forEach(location => {
                const position = {
                    lat: parseFloat(location.latitude),
                    lng: parseFloat(location.longitude)
                };
                const marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    icon: {
                        url: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'
                    }
                });
                locationMarkers.push(marker);

                marker.addListener('click', () => {
                    if (locationCircles[location.locid]) {
                        locationCircles[location.locid].setMap(null);
                        delete locationCircles[location.locid];
                    } else {
                        const circle = new google.maps.Circle({
                            map: map,
                            radius: location.range * 1000,
                            fillColor: '#AA0000',
                            strokeColor: '#AA0000',
                            strokeOpacity: 0.8,
                            strokeWeight: 2,
                            fillOpacity: 0.35,
                            center: position
                        });
                        locationCircles[location.locid] = circle;
                    }
                });

                showNearbyEvents(location);
            });

            document.querySelectorAll('.collapsible').forEach(item => {
                item.addEventListener('click', function() {
                    this.classList.toggle("active");
                    const content = this.nextElementSibling;
                    if (content.style.display === "block") {
                        content.style.display = "none";
                    } else {
                        content.style.display = "block";

                    }
                });
            });

            // Change map type when the dropdown value changes
            document.getElementById('map-type').addEventListener('change', function() {
                map.setMapTypeId(this.value);
            });
        }

        function showNearbyEvents(location) {
            const eventList = document.getElementById(`event-list-${location.locid}`);
            const rangeKm = location.range;

            const nearbyEvents = events.filter(event => {

                const eventCoords = event.geometries[0].coordinates;

                //**************************************************************************
                //itong part yung dinidisplay nya yung data sa 'nearest cities ....'. ayusin mo nalang kung saan ilalagay para pag pinidoot yung panel doon lang lalabas. 

                getNearestCities(eventCoords[1], eventCoords[0]);

                //*************************************************************************

                const eventPosition = {
                    lat: eventCoords[1],
                    lng: eventCoords[0]
                };
                return calculateDistance({
                    lat: parseFloat(location.latitude),
                    lng: parseFloat(location.longitude)
                }, eventPosition) <= rangeKm;
            });

            nearbyEvents.forEach(event => {
                const li = document.createElement("li");
                li.innerHTML =
                    `<strong>${event.title}</strong> <br>- <strong> Event Type: ${event.categories[0].title}</strong><br> -<a href="${event.link}" target="_blank">More info</a>`;
                eventList.appendChild(li);
            });
        }



        function getNearestCities(latitude, longitude) {
            var min_lat = latitude - 2;
            var max_lat = latitude + 2;
            var min_long = longitude - 2;
            var max_long = longitude + 2;

            const url =
                `https://api.api-ninjas.com/v1/city?min_lat=${min_lat}&max_lat=${max_lat}&min_lon=${min_long}&max_lon=${max_long}&limit=30`; // Construct API URL with latitude, longitude, and limit
            $.ajax({
                method: 'GET',
                url: url,
                headers: {
                    'X-Api-Key': 'gzTp5bf9/KedpWibLhvk2Q==ybU097RIGjtJWT7q'
                },
                contentType: 'application/json',
                success: function(result) {
                    displayNearestCities(result);
                },
                error: function ajaxError(jqXHR) {
                    console.error('Error: ', jqXHR.responseText);
                }
            });
        }

        function displayNearestCities(cities) {
            const nearestCitiesList = document.getElementById('nearest-cities-list');
            nearestCitiesList.innerHTML = '';
            cities.forEach(city => {
                const cityInfo = document.createElement('div');
                cityInfo.classList.add('city-info');
                cityInfo.textContent = `${city.name}, ${city.country}`;
                nearestCitiesList.appendChild(cityInfo);
            });
        }

        function calculateDistance(pos1, pos2) {
            const R = 6371;
            const dLat = (pos2.lat - pos1.lat) * Math.PI / 180;
            const dLng = (pos2.lng - pos1.lng) * Math.PI / 180;
            const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(pos1.lat * Math.PI / 180) * Math.cos(pos2.lat * Math.PI / 180) *
                Math.sin(dLng / 2) * Math.sin(dLng / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        }

        window.initMap = initMap;
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <footer class="text-center" style="margin-top: 50px;">
        <div class="container">
            <p>&copy; 2024 GEOEVENT. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
