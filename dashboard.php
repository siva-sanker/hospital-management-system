<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap');
    * {
      font-family:"Quicksand", sans-serif;
      box-sizing: border-box;
    }
    
    body {
      width: 100%;
      height: 100vh;
      background:url('./images/bg.jpg');
      background-size: cover;
      backdrop-filter: blur(10px);
      background-position-y: -10em;
      margin: 0;
      padding: 10px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    h1 {
      margin-top: 60px;
      color: #2c3e50;
      font-size: 3rem;
      text-align: center;
    }

    .main {
      margin-top: 10%;
      background-color: transparent;
      padding: 50px;
      /* border: 1px solid black; */
      border-radius: 12px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
      justify-content: center;
      width: 90%;
      max-width: 700px;
    }

    .main-a {
      background-color: #3498db;
      text-decoration: none;
      color: #fff;
      padding: 14px 24px;
      border-radius: 6px;
      font-size: 1.1rem;
      font-weight: 500;
      text-align: center;
      min-width: 160px;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .main-a:hover {
      background-color: #2980b9;
      transform: translateY(-2px);
    }
    span{
      /* border: 1px solid black; */
        float: left;
        text-transform: uppercase;
        font-weight: 600;
        font-size: larger;
    }
    .home{
      /* border: 1px solid white; */
        text-align: right;
        color: wheat;
        font-size: 1.2em;
        width:100%;  
    }
    .home .logout{
        text-decoration: none; 
        color: wheat;
        font-size: 1.2em;
        font-weight: 600;
        margin-right: 10px;
    }
  </style>
</head>
<body>
    <div class="home">
      <span><?php    
                      if (isset($_SESSION['username'])) {
                          echo $_SESSION['username'];
                      } 
                      else {
                          echo "Please log in.";
                      }
              ?>
      </span>
      <a href="logout.php" class="logout">Log Out</a>
    </div>
    <h1>Admin Page</h1>
    <div class="main">
      <a href="register.php" class="main-a">Register Patient</a>
      <a href="viewpatient.php" class="main-a">View Patient</a>
  </div>
</body>
</html>
