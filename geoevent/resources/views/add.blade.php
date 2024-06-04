<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GeoEvent - Event Map</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            height: 100vh;
            margin: 0;
        }

        .card {
            padding: 20px;
            border-radius: 10px;
            margin: 20px;
        }

        #map {
            height: 100%;
            width: 100%;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        #form-panel {
            width: 30%;
            padding: 20px;
            box-sizing: border-box;
            border-left: 1px solid #ccc;
            overflow-y: auto;
        }

        h2 {
            font-size: 2rem;
            font-weight: 600;
            color: rgb(67, 84, 235);
            text-shadow: 0 1px 1px rgb(0, 0, 0);
        }

        #event-panel {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border-left: 1px solid #ccc;
            overflow-y: auto;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        #nearest-cities-panel {
            width: 100%;
            padding: 20px;
            overflow-y: auto;
        }

        button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .container-fluid {
            width: 100%;
            padding: 40px;
            box-sizing: border-box;
        }

        .navbar {
            background-color: grey;
            margin-bottom: 10px;
        }

        #nearby-events {
            padding: 30px;
            max-height: 400px;
        }

        #nearby-cities-list {
            max-height: 400px;
        }

        footer {
            margin-top: 50px;
            color: white;
            background-color: #333;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="{{ route('index') }}">GeoEvent<i class='bx bxs-map'></i></a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </li>


                <p> ' '</p>
                <li class="nav-item">
                    <a href="{{ route('profile') }}"><button type="submit" class="btn btn-success">Profile &
                            Data</button></a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container-fluid">
        <h2>GeoEvent Monitoring Map<i class='bx bx-map-alt'></i></h2><br>
        <div class="row">
            <div class="col-md-8">
                <div id="map"></div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Add Event</h3>
                        <form action="/submitAdd" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" id="address" name="address" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" id="description" name="description" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="range">Range (km)</label>
                                <input type="number" id="range" name="range" class="form-control" value="3000"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="latitude">Latitude</label>
                                <input type="text" id="latitude" name="latitude" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="longitude">Longitude</label>
                                <input type="text" id="longitude" name="longitude" class="form-control" readonly>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Event</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div id="event-panel">
                        <h3>Nearby Events</h3>
                        <ul id="nearby-events" class="scrollable"></ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div id="nearest-cities-panel">
                        <h3>Nearest Cities</h3>
                        <p>2 Degree on all sides</p>
                        <ul id="nearest-cities-list" class="scrollable"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        let map;
        let marker;
        let circle;
        const events = @json($events);
        const geocoder = new google.maps.Geocoder();


        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 2,
                center: {
                    lat: 0,
                    lng: 0
                },
            });

            // Fetch event data from the API
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

                const infowindow = new google.maps.InfoWindow({
                    content: `<div><strong>${event.title}</strong><br><a href="${event.link}" target="_blank">More info</a></div>`
                });

                marker.addListener('click', function() {
                    infowindow.open(map, marker);
                });
            });

            map.addListener('click', function(e) {
                const latitude = e.latLng.lat();
                const longitude = e.latLng.lng();
                getNearestCities(latitude, longitude); // Call function to get nearest cities
            });

            // Add a click listener on the map
            map.addListener('click', function(event) {
                placeMarkerAndCircle(event.latLng);
                document.getElementById('latitude').value = event.latLng.lat();
                document.getElementById('longitude').value = event.latLng.lng();
            });

            map.addListener('click', function(event) {
                document.getElementById('latitude').value = event.latLng.lat();
                document.getElementById('longitude').value = event.latLng.lng();
                getAddress(event.latLng);
            });

            // map.addListener('click', function(event) {
            // const location = event.latLng;
            // placeMarkerAndCircle(location);
            // document.getElementById('latitude').value = location.lat();
            // document.getElementById('longitude').value = location.lng();
            // getAddress(location);
            // getNearestCities(location.lat(), location.lng());

            // Change map type when the dropdown value changes
            document.getElementById('map-type').addEventListener('change', function() {
                map.setMapTypeId(this.value);
            });
        }

        function placeMarkerAndCircle(location) {
            const range = document.getElementById('range').value || 3000;

            if (marker) {
                marker.setMap(null);
            }
            if (circle) {
                circle.setMap(null);
            }

            marker = new google.maps.Marker({
                position: location,
                map: map,
                title: 'Selected Location',
                icon: {
                    path: google.maps.SymbolPath.CIRCLE,
                    scale: 7,
                    fillColor: '#007bff',
                    fillOpacity: 1,
                    strokeColor: '#007bff',
                    strokeOpacity: 1,
                },
            });

            circle = new google.maps.Circle({
                strokeColor: '#007bff',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#007bff',
                fillOpacity: 0.35,
                map: map,
                center: location,
                radius: range * 1000, // Convert km to meters
            });

            showNearbyEvents(location, range);
        }

        // function showNearbyEvents(location, range) {
        //     const nearbyEvents = events.filter(event => {
        //         const eventCoords = event.geometries[0].coordinates;
        //         const eventPosition = {
        //             lat: eventCoords[1],
        //             lng: eventCoords[0]
        //         };
        //         return google.maps.geometry.spherical.computeDistanceBetween(new google.maps.LatLng(location.lat(),
        //                 location.lng()), new google.maps.LatLng(eventPosition.lat, eventPosition.lng)) <= range *
        //             1000;
        //     });

        //     const eventList = document.getElementById('nearby-events');
        //     eventList.innerHTML = '';
        //     nearbyEvents.forEach(event => {
        //         const listItem = document.createElement('li');
        //         listItem.textContent = event.title;
        //         eventList.appendChild(listItem);
        //     });
        // }

        function getAddress(latlng) {
            geocoder.geocode({
                'location': latlng
            }, function(results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        document.getElementById('address').value = results[0].formatted_address;
                    } else {
                        window.alert('No results found');
                    }
                } else {
                    window.alert('Geocoder failed due to: ' + status);
                }
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

        function showNearbyEvents(location, range) {
            const nearbyEvents = events.filter(event => {
                const eventCoords = event.geometries[0].coordinates;
                const eventPosition = {
                    lat: eventCoords[1],
                    lng: eventCoords[0]
                };
                return google.maps.geometry.spherical.computeDistanceBetween(new google.maps.LatLng(location.lat(),
                        location.lng()), new google.maps.LatLng(eventPosition.lat, eventPosition.lng)) <= range *
                    1000;
            });

            const eventList = document.getElementById('nearby-events');
            eventList.innerHTML = '';
            nearbyEvents.forEach(event => {
                const listItem = document.createElement('li');
                listItem.innerHTML =
                    `<strong>${event.title}</strong> - Category: ${event.categories[0].title} - <a href="${event.sources[0].url}" target="_blank">${event.sources[0].id}</a>`;
                eventList.appendChild(listItem);
            });
        }
        window.initMap = initMap;
    </script>

    <script type="text/javascript"
        src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap&libraries=geometry">
    </script>
    <footer class="text-center" style="margin-top: 50px;">
        <div class="container">
            <p style="padding: 20px;">&copy; 2024 GEOEVENT. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
