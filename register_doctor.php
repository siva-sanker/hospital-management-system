<?php 
  session_start();
?>

<?php
  $errormessage="";
  $host='localhost';
  $user='root';
  $password='';
  $db='sivadb';
  $conn=mysqli_connect($host,$user,$password,$db);
  if($conn){
    //   echo'<br>';
  }
  else{
      echo'not connected';
  }
  
  if(isset($_POST['register'])){
      $name=$_POST['name'];
      $age=$_POST['age'];
      $phone=$_POST['phone'];
      $mail=$_POST['mail'];
      $education=$_POST['education'];
      $pwd=$_POST['password'];
      $cpwd=$_POST['cpassword'];
      $role='doctor';
      if($pwd!=$cpwd){
        $errormessage="password do not match";
      }
      else{
        $sql3="select * from doctor where mail='$mail'";
        $result=mysqli_query($conn,$sql3);
        if(mysqli_num_rows($result)>0){
            $errormessage="user already exists!";
        }
        else{
        $sql="insert into doctor(name,age,phone,mail,education) values('$name',$age,$phone,'$mail','$education')";
        $sql2="insert into users(name,password,role) values('$name','$pwd','$role')";
        try{
            if(mysqli_query($conn,$sql)){
                $errormessage="added to table";
            }
            if(mysqli_query($conn,$sql2)){
                // echo '';
            }
        }
        catch(mysqli_sql_exception){
            $errormessage="problem in addng data";
        }
      }}
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
<style>

    @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap');

    body {
        font-family:"Quicksand", sans-serif;
        margin: 18px;
        background-color: #f4f7f8;
        color: #333;
    }

    h1 ,h2{
        text-align: center;
        color: #2c3e50;
        text-transform: uppercase;
    }

    .main {
        max-width: 600px;
        margin: 0 auto;
        padding: 25px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    form .inputs input,
    form .inputs select,
    form .inputs textarea {
        width: 100%;
        text-transform: capitalize;
        font-family:"Quicksand", sans-serif;
        margin-bottom: 15px;
        padding: 12px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }
    form .inputs input[type='email']{
        text-transform: none;
    }
    form .inputs textarea{
        max-height: 120px;
        min-height: 70px;
        min-width: 70px;
        max-width: 100%;
    }

    form input[type="submit"] {
        background-color: #2ecc71;
        color: white;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
        background-color: #27ae60;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 40px;
        text-transform: uppercase;
    }

    th, td {
        padding: 12px;
        text-align: center;
        border: 1px solid #ddd;
    }

    th {
        background-color: #3498db;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #e0f7fa;
        transition: 0.2s ease;
    }
    .modify{
        display: inline;
        /* border: 1px solid black; */
        width: fit-content;
        height: fit-content;
    }
    .modify input[type='submit']{
        font-family:"Quicksand", sans-serif;
        padding: 10px;
        outline: none;
        gap: 10px;
        margin-left: 5%;
    }
    .home{
        text-align: right;
        width:100%;  
    }
    .home a{
        text-decoration: none; color: black;
        font-weight: 600;
        margin-right: 10px;
    }
    span{
        float: left;
        text-transform: uppercase;
        font-weight: 600;
        font-size: larger;
    }  
    .message{
        /* border: 1px solid black; */
        margin-top: 2%;
        text-align: center;
        text-transform: capitalize;
        color: red;
        font-weight: 600;
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
                    echo "<script>alert('Please Login');window.location.href='login.php';</script>";
                }
        ?>
    </span>
        <a href="dashboard.php">Dashboard</a>
        <!-- <a href="viewpatient.php">View Patient</a> -->
        <a href="logout.php">Log Out</a>
</div>

    <h1>Register Doctor</h1>
    
    <div class="main">
        <form action="" method="post">
            <div class="inputs">
                <input type="text" name="name" placeholder="name of doctor" required>
                <input type="number" name="age" placeholder="age" min='5' max='150' required>
                <input type="tel" name="phone" placeholder="Phone no." maxlength="10" required>
                <input type="email" name="mail" placeholder="Mail ID" required>
                <input type="text" name="education" placeholder="education">
                <input type="password" name="password" placeholder="password">
                <input type="password" name="cpassword" placeholder="confirm password">
                
                <input type="submit" name="register" value="Register">
            </div>
        </form>
    </div>

    <div class="message">
        <?php  echo $errormessage; ?>
    </div>

</body>
</html>