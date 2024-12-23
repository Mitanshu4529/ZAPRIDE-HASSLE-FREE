<?php
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $userType = isset($_POST['userType']) ? $_POST['userType'] : 'user';

    if ($userType == 'user') {
        $stmt = $conn->prepare("INSERT INTO users (name, email, phone , password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $phone, $password);
    } else {
        $carNumber = $_POST['carNumber'];
        $upiId = $_POST['upiId'];
        $stmt = $conn->prepare("INSERT INTO drivers (name, email, phone, password, car_number, upi_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $email, $phone, $password, $carNumber, $upiId);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Sign up successful!');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZapRide - Sign Up</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            height: 100%;
            background-color: white;
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
        .main-content {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100% - 60px);
            padding: 20px;
        }
        .signup-form {
            width: 100%;
            max-width: 500px;
        }
        .user-type {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            gap: 40px;
        }
        .user-type button {
            padding: 12px 20px;
            border: 1px solid #ccc;
            border-radius: 25px;
            background-color: transparent;
            font-size: 18px;
            cursor: pointer;
            width: 45%;
            text-align: center;
            transition: background-color 0.3s, color 0.3s;
        }
        .user-type button:hover {
            background-color: #000;
            color: white;
        }
        .user-type button:active {
            color: #FAC71E;
        }
        .user-type button.selected {
            background-color: #000;
            color: white;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        input[type="text"], input[type="email"], input[type="tel"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        .sign-up-btn {
            padding: 12px 20px;
            border: 1px solid #ccc;
            border-radius: 25px;
            background-color: transparent;
            font-size: 18px;
            cursor: pointer;
            text-align: center;
            width: 45%;
            transition: background-color 0.3s, color 0.3s;
            margin: 12px auto;
            display: block;
        }
        .sign-up-btn:hover {
            background-color: #000;
            color: white;
        }
        .sign-up-button:active {
            color: #FAC71E;
        }
        .login-link {
            margin-top: 20px;
            font-size: 14px;
            text-align: center;
            color: #666;
        }
        .login-link a {
            color: #4800ff;
            text-decoration: none;
            font-weight: bold;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            ⚡ ZapRide
        </div>
        <div class="nav-links">
            <a href="#">Home</a>
            <a href="services.php">Services</a>
            <a href="contact.php">Contact</a>
        </div>
    </nav>

    <div class="main-content">
        <div class="signup-form">
            <form id="signupForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
                <div class="user-type">
                    <button type="button" id="userBtn" class="active selected">User</button>
                    <button type="button" id="driverBtn">Driver</button>
                </div>
                
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div id="driverFields" style="display: none;">
                    <div class="form-group">
                        <label for="carNumber">Car Number</label>
                        <input type="text" id="carNumber" name="carNumber">
                    </div>
                    <div class="form-group">
                        <label for="upiId">UPI ID</label>
                        <input type="text" id="upiId" name="upiId">
                    </div>
                </div>
                <input type="hidden" id="userType" name="userType" value="user">
                <button type="submit" class="sign-up-btn">Sign Up</button>
            </form>
            <div class="login-link">
                Already have an account? <a href="signin.php">Log in</a>
            </div>
        </div>
    </div>
    <?php
        include("footer.php") ;
    ?>
    <script>
        const userBtn = document.getElementById('userBtn');
        const driverBtn = document.getElementById('driverBtn');
        const driverFields = document.getElementById('driverFields');
        const signupForm = document.getElementById('signupForm');
        const userTypeInput = document.getElementById('userType');

        userBtn.addEventListener('click', () => {
            userBtn.classList.add('active', 'selected');
            driverBtn.classList.remove('active', 'selected');
            driverFields.style.display = 'none';
            userTypeInput.value = 'user';
        });

        driverBtn.addEventListener('click', () => {
            driverBtn.classList.add('active', 'selected');
            userBtn.classList.remove('active', 'selected');
            driverFields.style.display = 'block';
            userTypeInput.value = 'driver';
        });
        
    </script>
<!-- Code injected by live-server -->
<script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>
</script>
</body>
</html>