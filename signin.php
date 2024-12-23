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
    $email = $_POST['email'];
    $password = $_POST['password'];
    $userType = $_POST['userType'];

    if ($userType == 'user') {
        $table = 'users';
    } else {
        $table = 'drivers';
    }

    $stmt = $conn->prepare("SELECT * FROM $table WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_type'] = $userType;
            $_SESSION['user_name'] = $user['name'];

            echo "<script>alert('Sign in successful!'); window.location.href = 'pickup.php';</script>";
        } else {
            echo "<script>alert('Invalid password!');</script>";
        }
    } else {
        echo "<script>alert('User not found!');</script>";
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
    <title>ZapRide - Sign In</title>
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
        .logoPART {

            
                flex-shrink: 0;
                text-align: center;
                width: 40%;
                
            }

            .logo2 {
                width: 300px;
                display:block;
                margin: auto;
            }

            .tagline {
                font-size: 30px;
                color: #334;
                font-weight: bold;
                line-height: 1.4;
                margin-left: 15px;
                padding-bottom: 10px;
            }
        .signin-form {
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
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        .sign-in-btn {
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
        .sign-in-btn:hover {
            background-color: #000;
            color: white;
        }
        .sign-in-btn:active {
            color: #FAC71E;
        }
        .signup-link {
            margin-top: 20px;
            font-size: 14px;
            text-align: center;
            color: #666;
            background-color: white;
        }
        .signup-link a {
            color: #4800ff;
            text-decoration: none;
            font-weight: bold;
        }
        .signup-link a:hover {
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
            <a href="home.php">Home</a>
            <a href="services.php">Services</a>
            <a href="contact.php">Contact</a>
        </div>
    </nav>

    <div class="main-content">

    <div class="logoPART">
            <img src="images/ZapRide.png" class="logo2">
            <p class="tagline">
                Quick Rides<br>
                Zero Hassle!
            </p>
        </div>

        <div class="signin-form">
            <div class="user-type">
                <button id="userBtn" class="active selected">User</button>
                <button id="driverBtn">Driver</button>
            </div>
            <form id="signinForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="hidden" id="userType" name="userType" value="user">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="sign-in-btn">Sign In</button>
            </form>
            <div class="signup-link">
                Don't have an account? <a href="signup.php">Sign up</a>
            </div>
        </div>
    </div>
    <?php
include("footer.php") ;
?>
    <script>
        const userBtn = document.getElementById('userBtn');
        const driverBtn = document.getElementById('driverBtn');
        const userTypeInput = document.getElementById('userType');

        userBtn.addEventListener('click', () => {
            userBtn.classList.add('active', 'selected');
            driverBtn.classList.remove('active', 'selected');
            userTypeInput.value = 'user';
        });

        driverBtn.addEventListener('click', () => {
            driverBtn.classList.add('active', 'selected');
            userBtn.classList.remove('active', 'selected');
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