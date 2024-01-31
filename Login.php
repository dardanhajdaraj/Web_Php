<?php
session_start();
include 'connect.php';

class User {
    public $email;
    public $password;

    public function __construct($email, $password) {
        $this->email = $email;
        $this->password = $password;
    }
}

class LoginManager {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function attemptLogin($email, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Compare plain text passwords
            if ($password === $user['password']) {
                $this->setSession(new User($user['email'], $user['password']));
                
                // Check if the logged-in user is an admin
                if ($user['role'] == 'admin') {
                    $_SESSION['admin'] = true;
                } else {
                    $_SESSION['admin'] = false;
                }

                return true;
            }
        }

        return false;
    }

    private function setSession(User $user) {
        $_SESSION['Username'] = $user->email;
        $_SESSION['time'] = date("d/m/Y H:i", time());
    
        // Check if the user has the 'admin' role
        $_SESSION['admin'] = ($user->role == 'admin');
    }
    public function destroySession() {
        session_destroy();
    }
}


if (isset($_POST['submit'])) {
    $email = $_POST['Email'];
    $password = $_POST['Password'];

    $loginManager = new LoginManager($conn);
    $logged = $loginManager->attemptLogin($email, $password);

    if (!$logged) {
        echo "Te dhenat jane gabim";
        $loginManager->destroySession();
    } else {
        header('Location: Home_Signed.php');
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Sign_Up.css">
    <title>Log In</title>
</head>
<body>
    <style>
    .button {
        display: flex;
        align-items: center;
    }

    .signup-link {
        margin-left: 20px; 
        text-decoration: none; 
        color: #3498db; 
    }

    </style>
    <div class="container">
        <div class="form-box">
            <form action="" method="post" name="Formfill" onsubmit="return validation()">
                <h2>Log In</h2>
                <p id="result"></p>
                <div class="input-box">
                    <i class='bx bxs-envelope'></i>
                    <input type="email" name="Email" placeholder="Email">
                </div>
                <div class="input-box">
                    <i class='bx bxs-lock-alt'></i>
                    <input type="password" name="Password" placeholder="Password">
                </div>

                <div class="button">
                    <input type="submit" name="submit" class="btn" value="LogIn">
                    <a href="Sign_Up.php" class="signup-link">Sign Up</a>
                </div>
            </form>
        </div>
    </div>
    <script>
        function validation() {
            var email = document.forms["Formfill"]["Email"].value;
            var password = document.forms["Formfill"]["Password"].value;

            if (email === "") {
                document.getElementById("result").innerHTML = "Please enter your email.";
                return false;
            }

            if (password === "") {
                document.getElementById("result").innerHTML = "Please enter your password.";
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
