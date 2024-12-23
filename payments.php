<?php

// $servername = "localhost:3306";
// $username = "root";
// $password = "";
// $dbname = "project";

$host = 'localhost';
$dbname = 'ghumakkad';
$username = 'root';
$password = 'shubhraaaa';


$conn = new mysqli($host, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$driverId = 1; 


$sql = "SELECT upi_id FROM drivers WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $driverId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $upiId = $row['upi_id'];
} else {
    $upiId = "sourishmusib@oksbi";
}

session_start();
$userId = $_SESSION['user_id'] ?? null; 
if (!$userId) {
    die("User not logged in.");
}

// Fetch the current wallet balance
$sql = "SELECT wallet_balance FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$walletBalance = $row['wallet_balance'] ?? 0.00;

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZapRide - Payment Page</title>
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
        
        #heading {
            margin: 50px 0;
            text-align: center;
            color: #181C14;
        }
        .payment-methods {
            margin: 0 10%;
        }
        .payment-methods button {
            font-size: 20px;
            width: 100%;
            padding: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            border: none;
            border-radius: 5px;
            background-color: white;
            margin-bottom: 10px;
        }
        .payment-methods button img {
            height: 40px;
            margin-right: 40px;
            transition: transform 0.2s ease;
        }
        .payment-methods button:hover {
            background-color: rgb(226, 226, 226);
        }
        .payment-methods button:hover img {
            transform: scale(1.2);
        }
        .payment-methods button:active img {
            transform: scale(0.9);
        }
        #QR {
            width: 250px;
            border-radius: 5px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
            margin: 0 auto;
        }
        #QR img {
            margin-top: 10px;
            width: 90%;
            padding: 10px;
        }
        #QR.show-img {
            max-height: 300px;
            margin-bottom: 40px;
        }
        #QR p {
            margin: 0 20px;
            text-align: center;
        }
        #form {
            display: flex;
            justify-content: center;
            overflow: hidden;
            margin-left: -10px;
        }
        #form form {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            border-radius: 10px;
        }
        #form form label {
            font-size: 12px;
            color: black;
            display: block;
            margin-top: 10px;
            margin-bottom: 5px;
        }
        #form form input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            color: #333;
            border: 1px solid #909090;
            border-radius: 8px;
        }
        .expiry-cvv {
            display: flex;
            gap: 40px;
        }
        .expiry-cvv > span:first-child {
            flex: 2;
        }
        .expiry-cvv > span:last-child {
            flex: 1;
        }
        #form form input[type="text"]:focus {
            outline: none;
            border-color: black;
        }
        .pay {
            display: flex;
            justify-content: center;
        }
        #form form button, #submit-button {
            display: flex;
            justify-content: center; 
            align-items: center;
            width: 45%;
            padding: 12px;
            font-weight: bold;
            background-color: #909090;
            color: white;
            border: 1px solid #E2E2E2;
            border-radius: 25px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        #form form button:hover, #submit-button:hover {
            background-color: #191919;
            color: white;
        }
        #cashText {
            text-align: center;
            font-size: 18px;
            margin-top: 10px;
            font-weight: bold;
        }

        .wallet {
            margin-left: auto;
        }

        #wallet-button {
            background-color: #FFD700;
            color: black;
            border: none;
            border-radius: 20px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #wallet-button:hover {
            background-color: #FFC107;
        }


        @media (max-width: 768px) {
            .payment-methods {
                margin: 0 5%;
            }
            #form form {
                padding: 10px;
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

        <div class="wallet">
            <a href="wallet.php" id="wallet-button">
                Wallet: <span id="wallet-amount">₹<?php echo number_format($walletBalance, 2); ?></span>
            </a>
        </div>

    </nav>

    <h2 id="heading">SELECT PAYMENT</h2>

    <div class="payment-methods">
        <button onclick="generateText()">   
            <img src="images/dollar.png" alt="Cash">
            Cash
        </button>
        <p id="cashText"></p>
        
        <button onclick="generateQR()">
            <img src="images/qr.png" alt="UPI">
            UPI
        </button>
        <div id="QR">
            <img id="QRimage" alt="QR Code">
            <p>Please scan this QR to pay</p>
        </div>
        <br>

        <button onclick="generateForm()">
            <img src="images/visa.png" alt="Card">
            Card
        </button>
        <div id="form"></div>
        <br>
    </div>
    
    <script>
        let cashText = document.getElementById("cashText");
        let amount = localStorage.getItem('selectedPrice') || "0";
        let textflag = 0;

        function generateText(){
            if(textflag === 0){
                cashText.innerHTML = "Please pay the driver " + amount;
                textflag = 1;

                // Close others
                QRimage.src = "";
                QR.classList.remove("show-img");
                QRflag = 0;

                form.innerHTML = ``;
                formflag = 0;

                setTimeout(() => {
                    window.location.href = 'feedback.php';
                }, 30000);
            }
            else{
                cashText.innerHTML = "";
                textflag = 0;
            }
        }

        let QR = document.getElementById("QR");
        let QRimage = document.getElementById("QRimage");
        let UPI = "<?php echo $upiId; ?>"; // Use the UPI ID fetched from the database
        let QRflag = 0;

        function generateQR(){
            if(QRflag === 0){
                QRimage.src = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" + "upi://pay?pa=" + UPI + "&am=" + amount;
                QR.classList.add("show-img");
                QRflag = 1;

                // Close others
                cashText.innerHTML = "";
                textflag = 0;

                form.innerHTML = ``;
                formflag = 0;

                setTimeout(() => {
                    window.location.href = 'feedback.php';
                }, 30000);
            }
            else{
                QRimage.src = "";
                QR.classList.remove("show-img");
                QRflag = 0;
            }
        }

        let form = document.getElementById("form");
        let formflag = 0;

        function generateForm(){
            if(formflag === 0){
                form.innerHTML = `<form id="paymentForm" onsubmit="submitForm(event)">
                                    <label for="cnumber">Card Number</label>
                                    <input type="text" id="cnumber" name="cnumber" placeholder="XXXX XXXX XXXX XXXX" maxlength="19" required>

                                    <label for="cholder">Name On Card</label>
                                    <input type="text" id="cholder" name="cholder" placeholder="Cardholder name" maxlength="255" required>

                                    <div class="expiry-cvv">
                                        <span>
                                            <label for="cexpiry">Expiry Date</label>
                                            <input type="text" id="cexpiry" name="cexpiry" placeholder="MM/YY" maxlength="5" required>
                                        </span>

                                        <span>
                                            <label for="cvv">CVV</label>
                                            <input type="text" id="cvv" name="cvv" placeholder="XXX" maxlength="3" required>
                                        </span>
                                    </div><br>

                                    <div class="pay">
                                        <button type="submit" id="pay-now">Pay Now</button>
                                    </div>
                                </form>`;
                formflag = 1;

                // Close others
                cashText.innerHTML = "";
                textflag = 0;

                QRimage.src = "";
                QR.classList.remove("show-img");
                QRflag = 0;
            }
            else{
                form.innerHTML = ``;
                formflag = 0;
            }
        }

        function submitForm(event) {
            event.preventDefault();
            
            setTimeout(() => {
                window.location.href = 'feedback.php';
            }, 30000);
        }

        function lastinput() {
            const price = localStorage.getItem('selectedPrice');
            if(price) {
                amount = price;
                document.getElementById('cashText').textContent = `Price: ₹${price}`;
            }
            else {
                document.getElementById('cashText').textContent = 'NO RIDE SELECTED';
            }
        }
        window.onload = lastinput;
    </script>
</body>
</html>

