<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZapRide - Book Your Ride</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.maptiler.com/maptiler-sdk-js/v2.3.0/maptiler-sdk.umd.js"></script>
    <link href="https://cdn.maptiler.com/maptiler-sdk-js/v2.3.0/maptiler-sdk.css" rel="stylesheet" />
    <script src="https://cdn.maptiler.com/leaflet-maptilersdk/v2.0.0/leaflet-maptilersdk.js"></script>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f7f7;
        }

        .navbar {
            background-color: black;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo {
            display: flex;
            align-items: center;
            font-size: 24px;
            font-weight: bold;
            color: #FFD700;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            transition: color 0.3s;
        }
        .nav-links a:hover {
            color: #FFD700;
        }

        .container {
            display: flex;
            width: 90%;
            max-width: 1200px;
            border-radius: 8px;
            background-color: transparent;
            margin: 20px auto;
        }
        .formsection {
            width: 40%;
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
        }
        .heading {
            color: #333;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .inputgroup {
            margin-bottom: 15px;
            width: 100%;
        }
        .inputgroup label {
            display: block;
            font-weight: bold;
            color: #555;
            margin-bottom: 5px;
        }
        .inputy {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            background-color: transparent;
        }
        .inputy:focus {
            border-color: #000;
            outline: none;
        }
        .optionbutton {
            padding: 12px 20px;
            border: 1px solid #ccc;
            border-radius: 25px;
            background-color: transparent;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            width: 100%;
            transition: background-color 0.3s, color 0.3s;
        }
        .optionbutton.pricebutton:hover {
            background-color: #000;
            color: white;
        }
        .MAPWALALOCHA {
            width: 60%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: transparent;
            padding: 20px;
        }
        #map {
            width: 100%;
            height: 400px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #d3d3d3;
            color: #777;
            font-size: 18px;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .loader {
            display: none;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 10px auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 1024px) {
            .container {
                flex-direction: column;
            }
            .formsection,
            .MAPWALALOCHA {
                width: 100%;
            }
        }
        @media (max-width: 768px) {
            .formsection {
                padding: 20px;
            }
            .heading {
                font-size: 20px;
            }
            .inputy {
                font-size: 14px;
            }
            .optionbutton {
                font-size: 14px;
            }
            .navbar-menu {
                display: none;
            }
        }
    </style>
</head>
<body>
<nav class="navbar">
    <div class="logo">
        ⚡ ZapRide
    </div>
    <div class="nav-links">
        <a href="home.php">Home</a>
        <a href="services.php">Services</a>
        <a href="contact.php">Contact</a>
    </div>
</nav>

<div class="container">
    <div class="formsection">
        <h2 class="heading">Book Your Ride</h2>
        <form id="locationForm">
            <div class="inputgroup">
                <label for="pickup" aria-label="Pickup Location">Pickup Location</label>
                <input type="text" id="pickup" class="inputy" placeholder="Enter pickup location" required>
            </div>
            <div class="inputgroup">
                <label for="destination" aria-label="Destination">Destination</label>
                <input type="text" id="destination" class="inputy" placeholder="Enter destination" required>
            </div>
            <button type="button" class="optionbutton pricebutton" id="seePricesBtn" disabled aria-label="See Prices">See Prices</button>
            <div class="loader" id="loader"></div>
        </form>
    </div>

    <div class="MAPWALALOCHA">
        <div id="map" class="MAPKIJAGAH"></div>
    </div>
</div>

<?php include("footer.php"); ?>

<script>
const key = '5iy2C72ZpyCTMZtku5vz';
const map = L.map('map').setView([28.519423, 77.365340], 10);
const mtLayer = L.maptilerLayer({
    apiKey: key,
}).addTo(map);

let pickupMarker = null;
let dropoffMarker = null;
let locations = {
    pickup: null,
    dropoff: null
};

function updateSeePricesButton() {
    const seePricesBtn = document.getElementById('seePricesBtn');
    seePricesBtn.disabled = !(locations.pickup && locations.dropoff);
}

function handleLocationInput(inputId, type) {
    const input = document.getElementById(inputId);
    input.addEventListener('change', function() {
        if (input.value.trim() === '') {
            alert('Please enter a valid location.');
            return;
        }

        const randomLat = 28.519423 + (Math.random() - 0.5) * 0.5;
        const randomLng = 77.365340 + (Math.random() - 0.5) * 0.5;

        if (type === 'pickup' && pickupMarker) {
            map.removeLayer(pickupMarker);
        } else if (type === 'dropoff' && dropoffMarker) {
            map.removeLayer(dropoffMarker);
        }

        const marker = L.marker([randomLat, randomLng]).addTo(map);
        if (type === 'pickup') {
            pickupMarker = marker;
            locations.pickup = { lat: randomLat, lng: randomLng };
        } else {
            dropoffMarker = marker;
            locations.dropoff = { lat: randomLat, lng: randomLng };
        }

        updateSeePricesButton();
    });
}

handleLocationInput('pickup', 'pickup');
handleLocationInput('destination', 'dropoff');

const loader = document.getElementById('loader');

function showLoader() {
    loader.style.display = 'block';
}

function hideLoader() {
    loader.style.display = 'none';
}

const seePricesBtn = document.getElementById('seePricesBtn');
seePricesBtn.addEventListener('click', function() {
    showLoader();
    setTimeout(() => {
        localStorage.setItem('pickupLocation', JSON.stringify(locations.pickup));
        localStorage.setItem('dropoffLocation', JSON.stringify(locations.dropoff));
        window.location.href = 'rideoptions.php';
    }, 1000);
});
</script>
</body>
</html>


