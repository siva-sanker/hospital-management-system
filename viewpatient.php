<?php 
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patient</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap');
        *{
            font-family:"Quicksand", sans-serif;
        }
        body{
            margin: 18px;
        }
        h2{
        text-align: center;
        color: #2c3e50;
        text-transform: uppercase;
        }
        table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 4px;
        text-transform: capitalize;
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
        .home{
        text-align: right;
        width:100%;  
        }
        .home a{
            text-decoration: none; color: black;
            font-weight: 600;
            margin-right: 10px;
        }
        input[type='submit']{
            padding: 4px;
            margin: 3px;
            background-color: lightgreen;
            outline: none;
            border: none;
            color: black;
        }
        span{
        float: left;
        text-transform: uppercase;
        font-weight: 600;
        font-size: larger;
        }
        .legend{
            float: right;
            margin-right: 15px;
        }
        .legend p{
            color: darkblue;
            text-align: justify;
        }
        .filter{
            display: flex;
            justify-content: flex-end;
            height: 30px;
            /* border: 1px solid black; */
            margin-bottom: 10px;
        }
        .filter form select{
            padding: 7px;
        }
        .filter form button{
            padding: 10px;
            /* margin: 3px; */
            background-color: lightgreen;
            border-radius: 10px;
            outline: none;
            border: none;
            color: black;
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
        <a href="register.php">Go Back</a>
</div>

<?php
$host='localhost';
$user='root';
$password='';
$db='sivadb';
$conn=mysqli_connect($host,$user,$password,$db);

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Default query
$query = "SELECT * FROM patient";

// Check if filter is applied
if (isset($_POST['getfilter'])) {
    $bg = $_POST['bg'];
    if($bg!='all'){
        $query = "SELECT * FROM patient WHERE bloodgroup='$bg'";
    }
}

$ans = mysqli_query($conn, $query);

echo"<h2 class='heading'>Patient Details</h2>";
echo"    <div class='filter'>
        <form action='' method='post'>
            <select name='bg' required>
                <option value='' selected disabled>Select Blood Group</option>
                <option value='all'>All</option>
                <option value='a+'>A+</option>
                <option value='b+'>B+</option>
                <option value='a-'>A-</option>
                <option value='b-'>B-</option>
                <option value='o+'>O+</option>
                <option value='o-'>O-</option>
                <option value='ab+'>AB+</option>
                <option value='ab-'>AB-</option>
            </select>
            <button type='submit' name='getfilter'>Go</button>
        </form>
    </div>";
if (mysqli_num_rows($ans) > 0) {    
    echo "<table>
    <tr>
        <th>Name</th>
        <th>Age</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Blood group</th>
        <th>Email</th>
        <th>Total Bill Amount</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>";
    while ($row = mysqli_fetch_assoc($ans)) {
        echo "<tr>
                <td>{$row['name']}</td>
                <td>{$row['age']}</td>
                <td>{$row['phone']}</td>
                <td>{$row['address']}</td>
                <td>{$row['bloodgroup']}</td>
                <td style='text-transform:lowercase;'>{$row['email']}</td>
                <td>{$row['amount']}</td>
                <td>{$row['status']}</td>
                <td>
                    <form action='updatestatus.php' method='post' class='modify'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <input type='submit' name='status' value='Update Status'>
                    </form>
                    <form action='deletepatient.php' method='post' class='modify' onsubmit='return confirmDelete();'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <input type='submit' name='status' value='Discharge Patient'>
                    </form>
                </td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "<p style='text-align:center; color:red;'>No records to show</p>";
}

mysqli_close($conn);
?>

<script>
function confirmDelete() {
    let confirmResult = confirm("Are you sure you want to delete this patient?");
    return confirmResult; // Submits form only if true
}
</script>
<div class="legend">
    <p>Status</p>
    <p>0 - Discharged ; 1 - Admitted</p>
</div>
</body>
</html>