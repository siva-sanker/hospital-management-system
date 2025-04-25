<?php
    $host = 'localhost';
    $user = 'root';
    $pwd = '';
    $db = 'sivadb';
    $conn = mysqli_connect($host, $user, $pwd, $db);
?>
<?php 
  session_start();
  if (!isset($_SESSION['username'])) {
    echo "<script>alert('Please Login');window.location.href='login.php';</script>";
    } 
?>
  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Bill</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap');

        body {
            font-family:"Quicksand", sans-serif;
            margin: 40px;
            background-color: #f4f7f8;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            padding: 25px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form input[type="text"],
        form input[type="number"] {
            font-family:"Quicksand", sans-serif;
            width: 95%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        form input[type="submit"] {
            font-family:"Quicksand", sans-serif;
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        form input[type="submit"]:hover {
            background-color: #2980b9;
        }

        .home-link {
            font-family:"Quicksand", sans-serif;
            display: block;
            text-align: center;
            margin-top: 30px;
            font-size: 16px;
            text-decoration: none;
            color: #3498db;
        }

        .home-link:hover {
            text-decoration: underline;
        }

        .message {
            text-align: center;
            font-size: 18px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<h1>Add Bill</h1>

<div class="container">
<?php
if ($conn) {
    echo "<div class='message'>.</div>";
} else {
    die("<div class='message'>!</div>");
}

if (isset($_POST['bill'])) {
    $id = $_POST['id'];
    $sql = "SELECT * FROM patient WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    try {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo "
            <form action='' method='post'>
                <input type='hidden' name='id' value='{$row['id']}'>
                <input type='text' name='name' value='{$row['name']}' readonly>
                <input type='text' name='desc' placeholder='Enter bill name' required>
                <input type='number' name='amt' placeholder='Enter bill amount' step=0.01 required>
                <input type='submit' name='addbill' value='Add Bill'>
            </form>";
        } else {
            echo "<div class='message'>No record found for ID $id.</div>";
        }
    } catch (mysqli_sql_exception) {
        echo "<div class='message'>DB Error occurred</div>";
    }
}

if (isset($_POST['addbill'])) {
    $id = $_POST['id'];
    $bname = $_POST['desc'];
    $amount = floatval($_POST['amt']);

    $sql = "INSERT INTO bills (patient_id, bill_name, amount) VALUES ($id, '$bname', $amount)";
    if (mysqli_query($conn, $sql)) {
        $update_total = "UPDATE patient SET amount = amount + $amount WHERE id = $id";
        mysqli_query($conn, $update_total);

        echo "<script>alert('Bill added successfully'); window.location.href='register.php';</script>";
    } else {
        echo "<div class='message'>Failed to add bill.</div>";
    }
}

?>
</div>

<a href="register.php" class="home-link">← Go back to Home</a>

</body>
</html>
