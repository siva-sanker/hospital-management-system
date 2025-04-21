<?php 
  session_start();
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
        <a href="dashboard.php">Dashboard</a>
        <a href="viewpatient.php">View Patient</a>
        <a href="logout.php">Log Out</a>
    </div>
    <h1>Register Patient</h1>
    <div class="main">
        <form action="" method="post">
            <div class="inputs">
                <input type="text" name="name" placeholder="name of patient" required>
                <input type="number" name="age" placeholder="age" min='5' max='150' required>
                <select name="bg" id="" required>
                    <option value="" disabled selected>Select blood group</option>
                    <option value="a+">A+</option>
                    <option value="a-">A-</option>
                    <option value="b+">B+</option>
                    <option value="b-">B-</option>
                    <option value="o+">O+</option>
                    <option value="o-">O-</option>
                    <option value="ab+">AB+</option>
                    <option value="ab-">AB-</option>
                </select>
                <input type="tel" name="phone" placeholder="Phone no." maxlength="10" required>
                <input type="email" name="mail" placeholder="Mail ID" required>
                <textarea name="address" id="" rows="5" cols="30" placeholder="Address" required></textarea>

                <input type="submit" name="register" value="Register">
            </div>
        </form>
    </div>

    <?php
    
    $host='localhost';
    $user='root';
    $password='';
    $db='sivadb';
    $conn=mysqli_connect($host,$user,$password,$db);
    if($conn){
        echo'<br>';
    }
    else{
        echo'not connected';
    }

    if(!empty($_POST['register'] )){
        $name= $_POST['name'];
        $age=$_POST['age'];
        $bloodgroup=$_POST['bg'];
        $address=$_POST['address'];
        $mob=$_POST['phone'];
        $mail=$_POST['mail'];
        // echo "$name<br>$age<br>$bloodgroup<br>$address<br>$mob<br>$mail";
        $sql2="select * from patient where email='$mail'";
        $result=mysqli_query($conn,$sql2);
        if(mysqli_num_rows($result)>0){
            echo "<p style='text-align:center;color:red; font-weight:700;'>User already exists!</p>";
        }
        else{
            $sql="insert into patient(name,age,bloodgroup,phone,email,address) values('$name',$age,'$bloodgroup',$mob,'$mail','$address')";
            try{
                if(mysqli_query($conn,$sql)){
                    echo "<p style='text-align:center;color:green; font-weight:700;'>Added to table</p>";
                }
                else{
                    echo 'not added';
                }
            }
            catch(mysqli_sql_exception){
                echo'problem';
            }
        }


        

    }
    mysqli_close($conn);
    ?>

    <?php
        $host='localhost';
        $user='root';
        $password='';
        $db='sivadb';
        $conn=mysqli_connect($host,$user,$password,$db);
        if($conn){
            echo'<br>';
        }
        else{
            echo'not connected';
        }

        $query="select id,name,phone,address,email,amount from patient";
        $ans=mysqli_query($conn,$query);
        if(mysqli_num_rows($ans)>0){
            echo"<h2 class='heading'>Patient details</h2>";
            echo "<table border='1'>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Email</th>
                <th>Total Bill(s) Amount</th>
                <th>Actions</th>
            </tr>";
            while($row=mysqli_fetch_assoc($ans)){
                echo "<tr>
                        <td>{$row['name']}</td>
                        <td>{$row['phone']}</td>
                        <td>{$row['address']}</td>
                        <td style='text-transform:lowercase;'>{$row['email']}</td>
                        <td>{$row['amount']}</td>
                        <td><form action='addbill.php'method='post' class='modify'>
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <input type='submit' name='bill' value='Add Bill'>
                            </form>
                            <form action='billpage.php' method='get' class='modify'>
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <input type='submit' value='View Bills'>
                            </form>
                    </tr>";}
                echo"</table>";

        }
        else{
            echo'no record to show';
        }
        mysqli_close($conn);
    ?>

</body>
</html>