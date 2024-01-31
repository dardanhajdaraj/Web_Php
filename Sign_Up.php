<?php
class UserRegistration {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function registerUser($email, $username, $password) {
        if ($this->validateInput($email, $username, $password)) {
            // Prepare and bind the statement
            $stmt = $this->conn->prepare("INSERT INTO users (email, username, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $email, $username, $password);

            // Execute the statement
            $stmt->execute();

            // Close the statement
            $stmt->close();

            // Redirect to a success page or perform any other actions
            header('Location: Login.php');
            exit();
        } else {
            echo 'All fields are required.';
        }
    }

    private function validateInput($email, $username, $password) {
        return !empty($email) && !empty($username) && !empty($password);
    }
}

// Include the database connection file
include('connect.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user input from the form
    $email = $_POST['Email'];
    $username = $_POST['Username'];
    $password = $_POST['Password'];


    // Create UserRegistration instance and pass the database connection
    $userRegistration = new UserRegistration($conn);

    // Register the new user
    $userRegistration->registerUser($email, $username, $password);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Sign_Up.css">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <title>Sign Up</title>
</head>
<body>
    <div class="container">
        <div class="form-box">
            <form action="" method="post" name="Formfill" onsubmit="return validation()">
                <h2>Sign Up</h2>
                <div class="input-box">
                    <i class='bx bxs-user'></i>
                    <input type="text" name="Username" placeholder="Username" id="Username">
                </div>
                <div class="input-box">
                    <i class='bx bxs-envelope'></i>
                    <input type="email" name="Email" placeholder="Email" id="Email">
                </div>
                <div class="input-box">
                    <i class='bx bxs-lock-alt'></i>
                    <input type="password" name="Password" placeholder="Password" id="Password">
                </div>
                <div class="input-box">
                    <i class='bx bxs-lock-alt'></i>
                    <input type="password" name="CPassword" placeholder="Confirm Password" id="CPassword">
                </div>
                <div class="button">
                    <input type="submit" name="create" class="btn" onclick="validation()" value="Register">
                </div>
                <div class="group">
                    <span><a href="#">Forget Password</a></span>
                    <span><a href="login.php">Login</a></span>
                </div>
            </form>
        </div>
        <div class="popup" id="popup">
            <ion-icon name="checkmark-circle-outline"></ion-icon>
            <h2>Thank you!</h2>
            <p>Your registration was successful. Thank you!</p>
            <a href="#"><button onclick="CloseSlide()">OK</button></a>
        </div>
    </div>

    <script src="Sign_Up.js"></script>
</body>
</html>
