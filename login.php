    <?php
        $errorMsg="";
        $host = 'localhost';
        $user = 'root';
        $password = '';
        $dbname = 'sivadb';
        $conn = mysqli_connect($host, $user, $password, $dbname);
        if ($conn) {
            echo "<br>";
        } else {
            $errorMsg="Failed to Connect DB";
        }

        if (isset($_POST['login'])) {
            $uname = $_POST['username'];
            $pwd = $_POST['password'];

            $sql = "SELECT * FROM users WHERE name='$uname' AND password='$pwd'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $role = $row['role'];

                session_start();
                $_SESSION['username'] = $uname;
                $_SESSION['role'] = $role;

                if ($role == 'admin') {
                    header("Location: dashboard.php");
                    exit();
                } elseif ($role == 'doctor') {
                    header("Location: doctor_dashboard.php");
                    exit();
                } else {
                    $errorMsg='Unkonwn role';
                }
            } else {
                $errorMsg="Invalid username or password.";
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
        @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap');
        *{
            font-family:"Quicksand", sans-serif;
        }
        body {
            background:url('./images/login.jpg');
            background-repeat: no-repeat;
            backdrop-filter: blur(15px);
            background-size:cover;
            /* background-position-x: 3em; */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .main {
            /* display: block; */
            /* background: #ffffff; */
            padding: 2.5rem;
            border-radius: 8px;
            /* box-shadow: 0 4px 500px rgba(219, 216, 22, 0.59); */
            /* border: 1px solid red; */
            width: 100%;
            max-width: 700px;
            margin:auto;
        }

        form h1 {
            text-align: center;
            text-transform: uppercase;
            font-size: 3.5rem;
            /* margin-bottom: 1.5rem; */
            color: white;
        }
        form h1:hover{
            color: greenyellow;
            transition: 0.4s;
        }

        .inputs {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        input[type="text"],
        input[type="password"] {
            padding: 0.75rem 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            background-color: #fafafa;
            transition:border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: blue;
            outline: none;
        }

        input[type="submit"] {
            padding: 0.75rem 1rem;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #555;
        }
        .message {
            /* background-color: rgba(255, 0, 0, 0.2);  */
            /* border: 1px solid red; */
            padding: 1rem;
            /* margin-bottom: 1rem; */
            color: red;
            text-align: center;
            font-weight: bold;
            font-size: 2em;
            border-radius: 5px;
            max-width: 700px;
            width: 100%;
            position: absolute;
            top: 5%;
        }

        .role{
            color: white;
            /* border: 1px solid white; */
            text-align: center;
        }
        .role input{
            margin-left: 5%;
        }
        .admin,.doctor{
            display: inline;
            /* border: 1px solid black; */
        }
    </style>
</head>
<body>
    <div class="message">
        <?php echo $errorMsg; ?>
    </div>
    <div class="main">
        
        <form action="" method="post">
            <h1>Login</h1>

            <div class="inputs">

                <input type="text" name="username" placeholder="Username"> 
                <input type="password" name="password" placeholder="Password">

                <!-- <div class="role">
                    <div class="admin"><input type="radio" name="role" value="admin" >Admin</div>
                    <div class="doctor"><input type="radio" name="role" value="doctor">Doctor</div>
                </div> -->

                <input type="submit" name=login value="Login">
            </div>

        </form>
    </div>


</body>
</html>
