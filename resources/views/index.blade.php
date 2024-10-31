<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GeoEvent - Event Map</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style type="text/css">
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
            height: 800px;
            width: 100%;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .feature-card .icon {
            /* color: rgb(1, 19, 3); */
            font-size: 3rem;
            margin-bottom: 15px;
        }

        #side-panel,
        #nearest-cities-panel {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 5px 5px 5px 5px rgba(0, 0, 0, 0.1);
            /* border: solid 0.1px black; */
            margin-bottom: 20px;
        }

        #side-panel {
            overflow-y: auto;
        }

        #nearest-cities-panel {
            overflow-y: auto;
        }

        #distance-input {
            width: 80px;
        }

        .container-fluid {
            padding: 40px;
            margin-top: 20px;
        }

        #event-list {
            max-height: 1000px;
            overflow-y: auto;
        }

        #nearest-cities-list {
            max-height: 430px;
        }

        .nav-link {
            color: #007bff;
        }

        .event-info,
        .city-info {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #e9ecef;
            border-radius: 5px;
            background: #e6f7ff;
        }

        .event-info a {
            color: #007bff;
        }

        .event-info strong {
            display: block;
            margin-bottom: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        footer {
            background-color: #333;
            color: white;
            padding: 10px;
        }

        .btn-secondary {
            background-color: #28a745;
            border-color: #28a745;
        }

        .form-group label {
            font-weight: bold;
            color: #007bff;
        }

        h1 {
            font-size: 2rem;
            font-weight: 600;
            color: rgb(0, 26, 255);
            text-shadow: 0 2px 3px rgb(20, 20, 20);
        }

        h3 {
            color: #000000;
            font-size: 20px;
        }

        #map-type {
            width: 750px;
        }

        .navbar {
            background-color: grey;
            margin-bottom: 20px;
            /* color: white; */
        }

        .card {
            height: 220px;
            border: thin 2px rgb(43, 42, 42);
            box-shadow: 0 4px 8px rgba(48, 47, 47, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-decoration: none;
            color: inherit;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(48, 47, 47, 0.2);
        }

        .feature-card a {
            text-decoration: none;
            color: inherit;
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
        <a class="navbar-brand" href="#">GeoEvent<i class='bx bxs-map'></i></a>
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
        <div class="text-center mb-5">
            <h1 class="display-4">GeoEvent<i class='bx bxs-map'></i></h1>
            <p class="lead">Monitor and view surrounding geoevents of a chosen location</p>
        </div>
        <section id="features" class="py-4" style="margin-top: 10px; margin-bottom: 20px;">
            <div class="container">
                <div class="row text-center">
                    <div class="col-md-8 col-lg-4 feature-card">
                        <a href="{{ route('add') }}">
                            <div class="card">
                                <div class="card-body">
                                    <div class="icon" style="color: rgb(3, 85, 3);">
                                        <i class='bx bx-location-plus'></i>
                                    </div>
                                    <h5 class="card-title">Add a location to monitor</h5>
                                    <p class="card-text">Mark locations in the GeoEvent Map you want to monitor</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-8 col-lg-4 feature-card">
                        <a href="{{ route('satellite') }}">
                            <div class="card">
                                <div class="card-body">
                                    <div class="icon" style="color: rgb(26, 106, 112);">
                                        <i class='bx bxl-soundcloud'></i>
                                    </div>
                                    <h5 class="card-title">View Atmospheric Layers</h5>
                                    <p class="card-text">Get a look on the atmospheric layers</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-8 col-lg-4 feature-card">
                        <a href="{{ route('monitor') }}">
                            <div class="card">
                                <div class="card-body">
                                    <div class="icon" style="color: rgb(0, 0, 0);">
                                        <i class='bx bx-map-alt'></i>
                                    </div>
                                    <h5 class="card-title">View GeoEvent Monitoring Map</h5>
                                    <p class="card-text">See the events you have added</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        {{-- <div class="d-flex justify-content-between mb-4">
            <a href="/add" class="btn btn-primary">Add a location to monitor</a>
            <a href="/monitor" class="btn btn-secondary">Go to Monitor Page</a>
        </div> --}}

        <div>
            @if (session('alert'))
                <script>
                    Swal.fire({
                        icon: '{{ session('alert.type') }}',
                        title: '{{ session('alert.title') }}',
                        text: '{{ session('alert.text') }}',
                    });
                </script>
            @endif
        </div>

        <div class="row" style="margin-top: 10px;">
            <div class="col-md-6">

                <div id="map"></div>

                <label for="map-type">Map Type:</label>
                <select id="map-type" class="form-control">
                    <option value="roadmap">Roadmap</option>
                    <option value="satellite">Satellite</option>
                    <option value="hybrid">Hybrid</option>
                    <option value="terrain">Terrain</option>
                </select>

            </div>
            <div class="col-md-3">
                <div id="side-panel">
                    <div class="form-group">
                        <label for="distance-input">Distance (km):</label>
                        <input type="number" id="distance-input" class="form-control" value="3000" min="1">
                    </div>
                    <h3>Events within <span id="distance-label">3000</span> km</h3>
                    <ul id="event-list" class="scrollable"></ul>
                </div>

            </div>
            <div class="col-md-3">
                <div id="side-panel">

                    <h3>Nearest Cities</h3>
                    <p>2 Degree on all sides</p>
                    <div id="nearest-cities-list" class="scrollable"></div>
                </div>

            </div>
        </div>


    </div>

    <script type="text/javascript">
        const events = @json($events);
        let currentMarker = null;
        let circle = null;
        let map;

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 2,
                center: {
                    lat: 0,
                    lng: 0
                },
            });

            const infoWindow = new google.maps.InfoWindow();

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

            map.addListener('click', function(e) {
                const latitude = e.latLng.lat();
                const longitude = e.latLng.lng();
                getNearestCities(latitude, longitude);
            });

            map.addListener('click', function(e) {
                const position = {
                    lat: e.latLng.lat(),
                    lng: e.latLng.lng()
                };

                if (currentMarker) {
                    currentMarker.setMap(null);
                }
                if (circle) {
                    circle.setMap(null);
                }

                currentMarker = new google.maps.Marker({
                    position: position,
                    map: map,
                    icon: {
                        url: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'
                    }
                });

                const distanceKm = document.getElementById('distance-input').value;
                circle = new google.maps.Circle({
                    strokeColor: '#0000FF',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#0000FF',
                    fillOpacity: 0.2,
                    map: map,
                    center: position,
                    radius: distanceKm * 1000,
                });

                showNearbyEvents(position);
            });

            document.getElementById('distance-input').addEventListener('input', function() {
                document.getElementById('distance-label').textContent = this.value;
                if (circle) {
                    const distanceKm = this.value;
                    circle.setRadius(distanceKm * 1000);
                }
            });

            document.getElementById('map-type').addEventListener('change', function() {
                map.setMapTypeId(this.value);
            });
        }

        function showNearbyEvents(position) {
            const eventList = document.getElementById("event-list");
            eventList.innerHTML = "";

            const distanceKm = document.getElementById('distance-input').value;

            const nearbyEvents = events.filter(event => {
                const eventCoords = event.geometries[0].coordinates;
                const eventPosition = {
                    lat: eventCoords[1],
                    lng: eventCoords[0]
                };
                return calculateDistance(position, eventPosition) <= distanceKm;
            });

            nearbyEvents.forEach(event => {
                const eventInfo = document.createElement("div");
                eventInfo.classList.add("event-info");
                eventInfo.innerHTML =
                    `<strong>${event.title}</strong><br>
                    <p>Category: ${event.categories[0].title}</p>
                    <p>Sources:</p>
                    <ul>
                        ${event.sources.map(source => `<li><a href="${source.url}" target="_blank">${source.id}</a></li>`).join('')}
                    </ul>
                    <p>Coordinates: ${event.geometries[0].coordinates[1]}, ${event.geometries[0].coordinates[0]}</p>
                    <a href="${event.link}" target="_blank">More info</a>`;
                eventList.appendChild(eventInfo);
            });
        }

        function getNearestCities(latitude, longitude) {
            var min_lat = latitude - 2;
            var max_lat = latitude + 2;
            var min_long = longitude - 2;
            var max_long = longitude + 2;

            const url =
                `https://api.api-ninjas.com/v1/city?min_lat=${min_lat}&max_lat=${max_lat}&min_lon=${min_long}&max_lon=${max_long}&limit=30`;
            $.ajax({
                method: 'GET',
                url: url,
                headers: {
                    'X-Api-Key': 'FbPUDpKC0hNjj6R6IF7K3Q==E7uArQ4P4ZzAMeLX'
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

    <script type="text/javascript"
        src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap"></script>
    <footer class="text-center" style="margin-top: 50px;">
        <div class="container">
            <p>&copy; 2024 GEOEVENT. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
