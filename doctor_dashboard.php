<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 1rem;
        }
        .container {
            max-width: 800px;
            text-align: center;
            font-size: 1.5em;
            margin: auto;
            margin-top: 10%;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
        }
        a {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.75rem 1.5rem;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        a:hover {
            background-color: #0056b3;
        }
        .main{
            /* border: 1px solid black; */
            margin: 0;
            padding: 0;
        }
        .main a{
            float: right;
            background-color: transparent;
            color: black;
            padding: 0px;
            margin: 0px;
            margin-right: 15px;
            font-weight: 500;
            /* border: 1px solid black; */
        }
    </style>
</head>
<body>
    <div class="main">
        <a href="logout.php">LogOut</a>
    </div>
    <div class="container">
        <h1 style="display: inline;">Welcome</h1>
        <h1 style="display: inline;">
            <?php 
                if(isset($_SESSION['username'])){
                    echo"<span style='text-transform:uppercase;'>". $_SESSION['role'].' '. $_SESSION['username']."</span>";
                    }
                    else{
                        echo "<script>alert('Please Login');window.location.href='login.php';</script>";
                    }
            ?>
        </h1>
        <p>To your dashboard.</p>
        <a href="view_patients.php">👨‍⚕️ View Patients</a>
    </div>
</body>
</html>
