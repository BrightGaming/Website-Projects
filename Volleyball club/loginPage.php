<?php
$hostname = 'localhost';
$user = 'root';
$password = '';
$database = 'vbdb';

$connection = mysqli_connect($hostname, $user, $password, $database);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = ''; // For storing any login error messages

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];

    // Simple form validation
    if (empty($Email) || empty($Password)) {
        $message = 'Please enter your details.';
    } else {
        // Query to check if email and password match any entry in the database
        $query = "SELECT * FROM vbdb WHERE Email = '$Email' AND Password = '$Password'";
        $result = mysqli_query($connection, $query);

        // If a match is found, login is successful
        if (mysqli_num_rows($result) == 1) {
            $message = 'Login successful!';
            // Redirect or start session, etc.
            header('Location: Homepage.html');
            exit();
        } else {
            $message = 'Invalid email or password. Please try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box; /*This makes the div same size although one may have 50px padding and the other don't (Regardless of padding, border)*/
        }

        body {
            font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 55px;
            background-color: floralwhite;
        }

        /* Header styling */
        header {
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background-color: bisque;
            padding: 10px 0;
            z-index: 1000; /*This makes so header is 1000 page infornt*/
        }

        nav {
            display: flex; /* example: https://www.w3schools.com/cssref/playdemo.php?filename=playcss_display&preval=flex*/
            justify-content: space-between; /* example: https://www.w3schools.com/cssref/playdemo.php?filename=playcss_display&preval=flex*/
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo img{
            width: 200px;
            height: auto;          
        }

        .nav-links {
            list-style: none;
            display: flex;
            position: relative;
        }

        .nav-links li {
            margin-left: 20px;
            position: relative;
        }

        .nav-links a {
            font-weight: bold;
            color: black;
            text-decoration: none;
            font-size: 10pt;
            padding: 8px 15px;
            transition: all 1s ease;
        }

        .nav-links a:hover {
            color: darkkhaki;          
        }

        .dropdown {
            position: absolute;
            top: calc(100% + 5px);
            left: 0;
            display: none;
            background-color: bisque;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            list-style: none;
            padding: 0;
            width: 120px;
            margin: 0;
            z-index: 1000
        }

        .dropdown li {
            margin: 0;
        }

        .dropdown a {
            display: block;
            padding: 5px 10px;
            font-size: 9pt;
            text-align: left;
            transition: all 1s ease;
        }

        .dropdown a:hover {
            color: darkkhaki;
        }

        /* Show the dropdown when hovering on desktop */
        .nav-links li:hover .dropdown {
            display: block;
        }

        .cta {
            display: flex;
            align-items: center;
        }

        .cta img {
            width: 17px;           
            margin-right: 2px;
        }
        
        .cta .cartbtn {
            background-color: bisque;
            padding: 8px 15px;
            color: #fff;
            display: flex;
            margin-right: 4px;
            align-items: center;
        }

        .cta .shopbtn {
            background-color: orangered;
            padding: 8px 15px;
            color: black;
            font-weight: bold;
            font-size: 9pt;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 1s ease;
        }

        .cta-button {
            margin-bottom: 20px;
            background-color: lemonchiffon; /* Your preferred color */
            color: black;
            padding: 14px 28px;
            font-size: 12pt;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }
        
        footer{
            background-color: #333;
            color: white;
            text-align: left;
            padding: 16px;
            margin: 0;
            width: 100%;
            clear: both;
        }

        footer p{
            font-size: 20pt;
        }
        /* Responsive styling */
        /* Responsive Layout: Desktop and Larger Devices */
        @media (min-width: 1024px) {
            nav {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
                padding: 0 15px;
            }

            .logo img {
                width: 180px; 
            }

            .nav-links li {
                margin-left: 15px; 
            }

            .nav-links a {
                font-size: 9pt; 
                padding: 8px 12px;
            }

            .cta .cartbtn {
                padding: 6px 12px;
                font-size: 9pt;
            }
        }

        /* Tablet Layout */
        @media (min-width: 768px) and (max-width: 1023px) {
            nav {
                flex-direction: column;
                align-items: flex-start;
                padding: 0 10px;
            }

            .nav-links {
                flex-direction: column;
                width: 100%;
                margin-top: 10px;
            }

            .nav-links li {
                margin: 10px 0;
            }

            .nav-links a {
                width: 100%;
                padding: 10px 0;
                text-align: center;
                font-size: 12pt;
            }

            .cta {
                margin-top: 10px;
            }
        }

         /*Mobile Layout*/
        @media (max-width: 767px) {
            .logo img {
                width: 150px;
            }
            
            nav {
                flex-direction: column;
                align-items: flex-start;
                padding: 10px;
            }

            .nav-links { 
                flex-direction: column;
                width: 100%;
            }

            .nav-links li {
                margin: 10px 0;
            }

            .nav-links a {
                width: 100%;
                padding: 10px;
                text-align: center;
                font-size: 12pt;
            }

            .cta {
                margin-top: 10px;
            }

            .cta .cartbtn {
                font-size: 14px;
                padding: 10px;
            }
        } 
    
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            /* padding: 10px; */
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 140px);
            flex-direction: column;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            overflow-y: auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        /* Form Styles */
        form {
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        label {
            margin-bottom: 10px;
            font-weight: bold;
            color: #555;
        }

        input[type="email"],
        input[type="password"],
        select {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: bisque;
            color: black;
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        /* Message Box */
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            font-size: 14px;
            text-align: center;
        }

        /* Media Query for Responsive Design */
        @media (max-width: 480px) {
            .container {
                width: 100%;
                padding: 15px;
                box-sizing: border-box;
            }
        }
    </style>
</head>

<body>
    <!-- Header Nav -->
    <header>
        <nav>
            <div class="logo">
                <a href="Homepage.html">
                    <img src="Images/Logo.png" alt="Logo Icon">
                </a>
            </div>

            <ul class="nav-links">
                <li><a href="Homepage.html">Homepage</a></li>
                <li>
                    <a href="AboutUs.html">About Us</a>
                    <ul class="dropdown">
                        <li><a href="CoachLC.html">Coach Chrollo</a></li>
                        <li><a href="CoachJS.html">Coach Smith</a></li>
                    </ul>
                </li>
                <li><a href="#contactus">Contact Us</a></li>
                <li><a href="#program">Program</a></li>
                <li><a href="#calendar">Calendar</a></li>
                <li><a href="#faq">FAQ</a></li>
                <li><a href="#testimonials">Testimonials</a></li>
            </ul>

            <div class="cta">
                <a href="#shop" class="shopbtn">Shop</a>
                <a href="#cart" class="cartbtn"><img src="Images/Cart.png" alt="Cart Icon"></a>
            </div>
        </nav>
    </header>
    <main>
        <div class="container">
            <h2>Log In</h2>
            <?php if (!empty($message)): ?>
                <div class="message">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <form action="" method="POST">
                <label for="Email">Email:</label>
                <input type="Email" id="Email" name="Email" required>

                <label for="Password">Password:</label>
                <input type="Password" id="Password" name="Password" required>
                <br><br> <input type="submit" value="Login">
            </form>
        </div>
    </main>
    <!-- Footer -->
    <footer>
        <p>&copy; Tobe Volleyball Club</p>
        <div id="Footer"></div>
            <h3>CONTACT INFO</h3>
            <label>
            <table>
                <tr>
                    <td><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS4vtphMtxRWfK6nO2CIbGfSETyEs79Dr6oPw&s" alt="Gmail Picture" 
                        height="30" width="45"></td>
                    <td>Email Address:</td>
                    <td><a href="mailto:TobeVC@gmail.com" target="_blank">TobeVC@gmail.com</a></td>
                </tr>
                <tr>
                    <td><img src="https://seeklogo.com/images/W/whatsapp-logo-0DBD89C8E2-seeklogo.com.png" alt="Whatsapp Logo"
                        height="30" width="45"></td>
                    <td>Phone Number:</td>
                    <td>
                        <a href="https://wa.me/+60128894667" target="_blank"></a>
                        <a href="tel:+60128894667" target="_blank">+60128894667</a>
                    </td>
                </tr>
            </table>
            </label>
        </div>
    </footer>

</body>

</html>