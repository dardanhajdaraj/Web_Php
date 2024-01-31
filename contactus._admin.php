<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* Add your CSS styles here */

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .header {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 15px;
        }

        .logout {
            float: right;
            margin-right: 20px;
        }

        aside {
            width: 200px;
            height: 100%;
            position: fixed;
            background-color: #f1f1f1;
            padding-top: 20px;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        li a {
            display: block;
            color: #000;
            padding: 8px 16px;
            text-decoration: none;
        }

        li a:hover {
            background-color: #555;
            color: white;
        }

        .content {
            margin-left: 220px;
            padding: 16px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: white;
        }
        a{
            color:white;
            text-decoration:none;
        }
    </style>
</head>
<body>

    <header class="header">
        <a href="adminhome.php">Admin Dashboard</a>
        <div class="logout">
            <a href="logout.php" class="btn btn-primary">Logout</a>
        </div>
    </header>

    <aside>
        <ul>
            <li>
                <a href="admisson.php">Coontact Us</a>
            </li>
            <li>
                <a href="">Products</a>
            </li>
            <li>
                <a href="">View Student</a>
            </li>
            <li>
                <a href="">Add Teacher</a>
            </li>
            <li>
                <a href="">View Teacher</a>
            </li>
            <li>
                <a href="">Add Course</a>
            </li>
            <li>
                <a href="">View Course</a>
            </li>
        </ul>
    </aside>

    <div class="content">
        <h1>Applied for Admission</h1>

        <?php
        $host = "localhost";
        $user = "root";
        $password = "";
        $db = "projekt";

        $data = mysqli_connect($host, $user, $password, $db);

        if ($data === false) {
            die("Connection error: " . mysqli_connect_error());
        }

        $sql = "SELECT * FROM contactus";
        $result = mysqli_query($data, $sql);

        if ($result === false) {
            die("Error in SQL query: " . mysqli_error($data));
        }

        if ($result->num_rows > 0) {
            ?>
            <table border="1px">
                <tr>
                    <th style="padding: 20px; font-size: 15px;">Name</th>
                    <th style="padding: 20px; font-size: 15px;">Email</th>
                    <th style="padding: 20px; font-size: 15px;">Message</th>
                </tr>
                <?php
                while ($info = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td style="padding: 20px;"><?php echo $info['name']; ?></td>
                        <td style="padding: 20px;"><?php echo $info['email']; ?></td>
                        <td style="padding: 20px;"><?php echo $info['message']; ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <?php
        } else {
            echo "No records found.";
        }
        ?>
    </div>
</body>
</html>
