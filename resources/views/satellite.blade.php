<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Satellite Image</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            flex-direction: row;
        }

        #map {
            border-radius: 10px;
            height: 100%;
            width: 100%;
            margin-left: 30px;
            padding: 10px;
        }

        #sidebar {
            height: 100%;
            width: 100%;
            background-color: #f8f9fa;
            padding: 15px;
            box-sizing: border-box;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        h1,
        hr {
            margin: 10px 0;
        }

        .color-scale {
            margin: 10px 0;
        }

        .color-scale div {
            height: 20px;
            width: 100%;
            margin-bottom: 5px;
        }

        .color-scale p {
            margin: 0;
        }

        .color-scale .percent {
            text-align: right;
            font-size: 0.9em;
            color: #555;
        }





        .clouds {
            background: linear-gradient(to right,
                    rgba(255, 255, 255, 0.0) 0%,
                    rgba(253, 253, 255, 0.1) 10%,
                    rgba(252, 251, 255, 0.2) 20%,
                    rgba(250, 250, 255, 0.3) 30%,
                    rgba(249, 248, 255, 0.4) 40%,
                    rgba(247, 247, 255, 0.5) 50%,
                    rgba(246, 245, 255, 0.75) 60%,
                    rgba(244, 244, 255, 1) 70%,
                    rgba(243, 242, 255, 1) 80%,
                    rgba(242, 241, 255, 1) 90%,
                    rgba(240, 240, 255, 1) 100%);
        }

        .precipitation {
            background: linear-gradient(to right,
                    rgba(225, 200, 100, 0) 0%,
                    rgba(200, 150, 150, 0) 10%,
                    rgba(150, 150, 170, 0) 20%,
                    rgba(120, 120, 190, 0) 50%,
                    rgba(110, 110, 205, 0.3) 100%,
                    rgba(80, 80, 225, 0.7) 100%,
                    rgba(20, 20, 255, 0.9) 140%);
        }

        .temperature {
            background: linear-gradient(to right,
                    rgba(130, 22, 146, 1) -65%,
                    rgba(130, 22, 146, 1) -55%,
                    rgba(130, 22, 146, 1) -45%,
                    rgba(130, 22, 146, 1) -40%,
                    rgba(130, 87, 219, 1) -30%,
                    rgba(32, 140, 236, 1) -20%,
                    rgba(32, 196, 232, 1) -10%,
                    rgba(35, 221, 221, 1) 0%,
                    rgba(194, 255, 40, 1) 10%,
                    rgba(255, 240, 40, 1) 20%,
                    rgba(255, 194, 40, 1) 25%,
                    rgba(252, 128, 20, 1) 30%);
        }

        .pressure {
            background: linear-gradient(to right,
                    rgba(130, 22, 146, 1) -65%,
                    rgba(130, 22, 146, 1) -55%,
                    rgba(130, 22, 146, 1) -45%,
                    rgba(130, 22, 146, 1) -40%,
                    rgba(130, 87, 219, 1) -30%,
                    rgba(32, 140, 236, 1) -20%,
                    rgba(32, 196, 232, 1) -10%,
                    rgba(35, 221, 221, 1) 0%,
                    rgba(194, 255, 40, 1) 10%,
                    rgba(255, 240, 40, 1) 20%,
                    rgba(255, 194, 40, 1) 25%,
                    rgba(252, 128, 20, 1) 30%);
        }

        .wind {
            background: linear-gradient(to right,
                    rgba(255, 255, 255, 0) 1%,
                    rgba(238, 206, 206, 0.4) 5%,
                    rgba(179, 100, 188, 0.7) 15%,
                    rgba(179, 100, 188, 0.7) 15%,
                    rgba(63, 33, 59, 0.8) 25%,
                    rgba(116, 76, 172, 0.9) 50%,
                    rgba(70, 0, 175, 1) 100%,
                    rgba(13, 17, 38, 1) 200%);
        }

        .navbar {
            background-color: grey;
            margin-bottom: 20px;
        }

        .card {
            padding: 20px;
        }

        footer {
            background-color: #333;
            color: white;
            padding: 10px;
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
    <div class="row">
        <div class="col-lg-7">
            <div id="map"></div>
        </div>
        <div class="col-lg-5">
            <div class="card">
                <div id="sidebar">
                    <h1>Athmospheric Phenomena Layer</h1>
                    <hr>
                    <div class="color-scale">
                        <p>Clouds</p>
                        <div class="clouds"><span class="min">0% to</span> <span class="max">100%</span></div>
                    </div>
                    <div class="color-scale">
                        <p>Precipitation</p>
                        <div class="precipitation"><span class="min">0 to</span> <span class="max">140 </span>
                        </div>
                    </div>
                    <div class="color-scale">
                        <p>Pressure</p>
                        <div class="pressure"><span class="min">-65hPa to</span> <span class="max">30hPa</span>
                        </div>
                    </div>
                    <div class="color-scale">
                        <p>Wind</p>
                        <div class="wind"><span class="min">1 m/s to</span> <span class="max">200 m/s</span>
                        </div>
                    </div>
                    <div class="color-scale">
                        <p>Temperature</p>
                        <div class="temperature"><span class="min">-65 &deg; to</span> <span class="max">50
                                &deg;</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        // Your OpenWeatherMap API key. Get from the website. 
        const apiKey = 'API KEY'; 

        // Create a map centered at a particular location and zoom level
        const map = L.map('map').setView([0, 0], 5);

        // Add the base tile layer (OpenStreetMap)
        const baseLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Define the tile layer URL with placeholders for layer, z, x, y, and API key
        const tileLayerUrl = 'https://tile.openweathermap.org/map/{layer}/{z}/{x}/{y}.png?appid={API key}';

        // Define the different weather layers
        const layers = {
            'Clouds': L.tileLayer(tileLayerUrl.replace('{layer}', 'clouds_new').replace('{API key}', apiKey), {
                maxZoom: 18,
                attribution: '&copy; <a href="https://www.openweathermap.org/">OpenWeatherMap</a>'
            }),
            'Precipitation': L.tileLayer(tileLayerUrl.replace('{layer}', 'precipitation_new').replace('{API key}',
                apiKey), {
                maxZoom: 18,
                attribution: '&copy; <a href="https://www.openweathermap.org/">OpenWeatherMap</a>'
            }),
            'Pressure': L.tileLayer(tileLayerUrl.replace('{layer}', 'pressure_new').replace('{API key}', apiKey), {
                maxZoom: 18,
                attribution: '&copy; <a href="https://www.openweathermap.org/">OpenWeatherMap</a>'
            }),
            'Wind': L.tileLayer(tileLayerUrl.replace('{layer}', 'wind_new').replace('{API key}', apiKey), {
                maxZoom: 18,
                attribution: '&copy; <a href="https://www.openweathermap.org/">OpenWeatherMap</a>'
            }),
            'Temperature': L.tileLayer(tileLayerUrl.replace('{layer}', 'temp_new').replace('{API key}', apiKey), {
                maxZoom: 18,
                attribution: '&copy; <a href="https://www.openweathermap.org/">OpenWeatherMap</a>'
            })
        };

        // Add the default weather overlay tile layer to the map
        layers['Precipitation'].addTo(map);

        // Add layer control to toggle layers
        L.control.layers({
            'Base Map': baseLayer
        }, layers).addTo(map);
    </script>
    <footer class="text-center" style="margin-top: 50px;">
        <div class="container">
            <p>&copy; 2024 GEOEVENT. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
