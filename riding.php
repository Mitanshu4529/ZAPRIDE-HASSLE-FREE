<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZapRide - Your Ride</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script src="https://cdn.maptiler.com/maptiler-sdk-js/v2.3.0/maptiler-sdk.umd.js"></script>
    <link href="https://cdn.maptiler.com/maptiler-sdk-js/v2.3.0/maptiler-sdk.css" rel="stylesheet" />
    <script src="https://cdn.maptiler.com/leaflet-maptilersdk/v2.0.0/leaflet-maptilersdk.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            background-color: white;
            color: #fff;
            min-height: 100vh;
        }

        .navbar {
            background-color: #000;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            font-size: 24px;
            font-weight: bold;
            color: #FFD700;
        }

        .content {
            display: flex;
            flex-wrap: wrap;
            padding: 20px;
            gap: 20px;
            max-width: 1400px;
            margin: 0 auto;
        }

        #map {
            flex: 2;
            min-height: 400px;
            background-color: #222;
            border-radius: 12px;
            min-width: 300px;
        }

        .dashboard {
            flex: 1;
            min-width: 300px;
            background-color: #222;
            padding: 2rem;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .weather {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            padding: 1.5rem;
            background-color: #333;
            border-radius: 8px;
        }

        #icon {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }

        #temperature {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #temp {
            font-size: 2rem;
            font-weight: bold;
            color: #FFD700;
        }

        #weath {
            font-size: 1.2rem;
            color: #fff;
            opacity: 0.8;
        }

        .text {
            text-align: center;
            padding: 1.5rem;
            background-color: #333;
            border-radius: 8px;
        }

        .text p {
            font-size: 1.2rem;
            color: #fff;
            line-height: 1.5;
        }

        .highlight {
            color: #FFD700;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .content {
                padding: 10px;
            }
            
            #map {
                min-height: 300px;
            }

            .dashboard {
                padding: 1rem;
            }

            .weather, .text {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            ⚡ ZapRide
        </div>
    </nav>

    <div class="content">
        <div id="map"></div>

        <div class="dashboard">
            <div class="weather">
                <img id="icon" src="images/cloud.png" alt="Weather Icon">
                <div id="temperature">
                    <p id="temp">--°c</p>
                    <p id="weath"></p>
                </div>
            </div>

            <div class="text">
                <p>Sit back and relax, you will reach your destination in <span class="highlight">16 minutes</span></p>
            </div>
        </div>
    </div>
    <?php
include("footer.php") ;
?>
    <script>
        const weatherimg = document.getElementById("icon");
        const temperature = document.getElementById("temp");
        const weath = document.getElementById("weath");
        let city = "noida"; //get current location from gps, we need some geolocation api here!!!

        const apikey = "54ed12a17ceaa7d3bc3d0cbf1b3a12f2";
        const apiURL = "https://api.openweathermap.org/data/2.5/weather?units=metric&q=";

        async function checkWeather(city) {
            const response = await fetch(apiURL + city + `&appid=${apikey}`);
            var data = await response.json();

            temperature.innerText = `${parseInt(data.main.temp)}°c`;

            const weather = data.weather[0].main;
            weath.innerText = weather;

            if(weather === "Clouds"){
                weatherimg.src="images/cloud.png";
            }
            else if(weather === "Clear"){
                weatherimg.src="images/clear.png";
            }
            else if(weather === "Snow"){
                weatherimg.src="images/snow.png";
            }
            else if(weather === "Rain"){
                weatherimg.src="images/rain.png";
            }
            else if(weather === "Thunderstorm"){
                weatherimg.src="images/thunder.png";
            }
            else if(weather === "Mist"){
                weatherimg.src="images/mist.png";
            }
            else if(weather === "Drizzle"){
                weatherimg.src="images/drizzle.png";
            }
            else{
                weatherimg.src="images/clear.png";
            }
        }

        checkWeather(city);

        setTimeout(function() {
            window.location.href = 'payments.php';
        }, 8000);
    </script>

<script>
      const key = '5iy2C72ZpyCTMZtku5vz';
        const map = L.map('map').setView([28.519423, 77.365340], 10);
        const mtLayer = L.maptilerLayer({ apiKey: key }).addTo(map);

        const pickupLocation = JSON.parse(localStorage.getItem('pickupLocation')) || { lat: 28.7041, lng: 77.1025 };
        const dropoffLocation = JSON.parse(localStorage.getItem('dropoffLocation')) || { lat: 28.4595, lng: 77.0266 };

        if (pickupLocation && dropoffLocation) {
            const pickupMarker = L.marker([pickupLocation.lat, pickupLocation.lng])
                .addTo(map)
                .bindPopup('Pickup Location');

            const dropoffMarker = L.marker([dropoffLocation.lat, dropoffLocation.lng])
                .addTo(map)
                .bindPopup('Dropoff Location');

            async function fetchRoadPath() {
                const osrmBaseUrl = 'https://router.project-osrm.org/route/v1/driving/';
                const response = await fetch(`${osrmBaseUrl}${pickupLocation.lng},${pickupLocation.lat};${dropoffLocation.lng},${dropoffLocation.lat}?overview=full&geometries=geojson`);
                const data = await response.json();

                if (data && data.routes && data.routes.length > 0) {
                    const coordinates = data.routes[0].geometry.coordinates;
                    const routeCoordinates = coordinates.map(coord => [coord[1], coord[0]]);
                    L.polyline(routeCoordinates, {
                        color: 'blue',
                        weight: 4,
                        opacity: 0.8,
                    }).addTo(map);
                    map.fitBounds(L.latLngBounds(routeCoordinates), { padding: [50, 50] });
                } else {
                    console.error('Failed to fetch the road path.');
                }
            }

            fetchRoadPath();
        }
    </script>
</body>
</html>