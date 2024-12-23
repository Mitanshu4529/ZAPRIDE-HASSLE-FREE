<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OPTION AND PRICE</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.maptiler.com/maptiler-sdk-js/v2.3.0/maptiler-sdk.umd.js"></script>
    <link href="https://cdn.maptiler.com/maptiler-sdk-js/v2.3.0/maptiler-sdk.css" rel="stylesheet" />
    <script src="https://cdn.maptiler.com/leaflet-maptilersdk/v2.0.0/leaflet-maptilersdk.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .Container {
            display: flex;
            width: 90%;
            max-width: 1200px;
            border-radius: 8px;
            background-color: transparent;
        }

        .FormSection {
            width: 40%;
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
        }

        .Heading {
            color: #333;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .RideOptions {
            list-style-type: none;
            padding: 0;
            width: 100%;
        }

        .Options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 30px; 
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 25px;
            background-color: transparent;
            transition: background-color 0.3s, color 0.3s;
            font-size: 18px; 
            cursor: pointer;
            min-height: 90px;
        }

        .Options:hover {
            background-color: #000;
            color: white;
            border-color: #000;
        }

        .OptionDetails {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .OptionName {
            font-weight: bold;
            color: #333;
        }

        .OptionPrice {
            font-weight: bold;
            color: #555;
            margin-left: auto;
        }

        .OptionImage {
            width: 50px;
            height: 50px;
            margin-right: 20px;
            border-radius: 50%;
        }

        .MAPWALALOCHA {
            width: 60%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: transparent;
            padding: 20px;
            height: 400px;
            margin-top: 200px;
        }

        #map {
            width: 100%;
            height: 100%;
            background-color: #d3d3d3;
            color: #777;
            font-size: 18px;
            text-align: center;
            border-radius: 8px;
        }

        @media (max-width: 1024px) {
            .Container {
                flex-direction: column;
            }

            .FormSection,
            .MAPWALALOCHA {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="Container">
        <div class="FormSection">
            <h2 class="Heading">Choose Your Ride</h2>
            <ul class="RideOptions">
                <a href="riding.php">
                    <li class="Options">
                        <img src="images/cab.png" alt="Cab" class="OptionImage">
                        <div class="OptionDetails">
                            <span class="OptionName">Cab</span>
                            <span class="OptionPrice">₹200</span>
                        </div>
                    </li>
                </a>
                <a href="riding.php">
                    <li class="Options">
                        <img src="images/autorikshaw.png" alt="Auto" class="OptionImage">
                        <div class="OptionDetails">
                            <span class="OptionName">Auto</span>
                            <span class="OptionPrice">₹150</span>
                        </div>
                    </li>
                </a>
                <a href="riding.php">
                    <li class="Options">
                        <img src="images/moto.png" alt="Moto" class="OptionImage">
                        <div class="OptionDetails">
                            <span class="OptionName">Moto</span>
                            <span class="OptionPrice">₹100</span>
                        </div>
                    </li>
                </a>
                <a href="riding.php">
                    <li class="Options">
                        <img src="images/xlcab.png" alt="XL Cab" class="OptionImage">
                        <div class="OptionDetails">
                            <span class="OptionName">XL Cab</span>
                            <span class="OptionPrice">₹300</span>
                        </div>
                    </li>
                </a>
            </ul>
        </div>

        <div class="MAPWALALOCHA">
            <div id="map" class="MAPKIJAGAH">Loading Map...</div>
        </div>
    </div>

    <script>

        function generateRandomPrice(min, max) {
            return Math.floor(Math.random() * (max - min + 1) + min);
        }

        function updatePrices() {
    const motoPrice = generateRandomPrice(80, 200);
    const autoPrice = generateRandomPrice(motoPrice + 20, motoPrice + 50);
    const cabPrice = generateRandomPrice(autoPrice + 20, autoPrice + 50);
    const xlCabPrice = generateRandomPrice(cabPrice + 50, cabPrice + 100);

    document.querySelectorAll('.Options')[2].querySelector('.OptionPrice').textContent = `₹${motoPrice}`;
    document.querySelectorAll('.Options')[1].querySelector('.OptionPrice').textContent = `₹${autoPrice}`;
    document.querySelectorAll('.Options')[0].querySelector('.OptionPrice').textContent = `₹${cabPrice}`;
    document.querySelectorAll('.Options')[3].querySelector('.OptionPrice').textContent = `₹${xlCabPrice}`;
}

document.querySelectorAll('.Options').forEach((option) => {
    option.addEventListener('click', () => {
        const ridePrice = option.querySelector('.OptionPrice').textContent;

        localStorage.setItem('selectedPrice', ridePrice);

        window.location.href = 'riding.php';
    });
});


// Call updatePrices when the page loads
window.onload = updatePrices;


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
