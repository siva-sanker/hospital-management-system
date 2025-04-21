<?php
$host = 'localhost';
$user = 'root';
$pwd = '';
$db = 'sivadb';
$conn = mysqli_connect($host, $user, $pwd, $db);
?>

<?php 
  session_start();?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Patient Bills</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap');

        body {
            font-family: "Quicksand", sans-serif;
            margin: 10px;
            background-color: #f4f7f8;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
        }

        table {
            width: 98%;
            margin: 0 auto;
            border-collapse: collapse;
            margin-top: 30px;
            text-align: center;
        }

        th,
        td {
            text-transform: uppercase;
            padding: 12px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        a.back {
            display: block;
            text-align: center;
            margin-top: 30px;
            font-size: 16px;
            text-decoration: none;
            color: #3498db;
        }

        .name {
            text-transform: uppercase;
            font-weight: 700;
        }
        input[type='submit']{
            padding: 10px 10px;
            background-color:rgba(255, 0, 0, 0.64);
            outline: none;
            border-radius: 10px;
            border: none;
            color: white;
        }
        input[type='submit']:hover{
            background-color:red;
            transition: 0.5s ease;
        }
        .session{
        float: left;
        text-transform: uppercase;
        font-weight: 600;
        font-size: larger;
        }
    </style>
</head>

<body>
    <span class="session"><?php   
                if (isset($_SESSION['username'])) {
                    echo $_SESSION['username'];
                } 
                else {
                    echo "Please log in.";
                }
        ?>
    </span>
    <?php
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $sql = "SELECT name FROM patient WHERE id = $id";
        $result = mysqli_query($conn, $sql);
        if ($row = mysqli_fetch_assoc($result)) {
            echo "<h1>Bills for <span class='name'> {$row['name']}</span></h1>";

            $bill_query = "SELECT * FROM bills WHERE patient_id = $id ORDER BY date_added DESC";
            $bills = mysqli_query($conn, $bill_query);

            if (mysqli_num_rows($bills) > 0) {
                echo "<table>
                        <tr>
                            <th>Bill Name</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>";
                $total = 0;
                while ($bill = mysqli_fetch_assoc($bills)) {
                    $total += $bill['amount'];
                    echo "<tr>
                            <td>{$bill['bill_name']}</td>
                            <td>{$bill['amount']}</td>
                            <td>{$bill['date_added']}</td>
                            <td>
                            <form action='deletebill.php' method='post' onsubmit='return removePatient()'>
                                <input type='hidden' name='bid' value='{$bill['id']}'>
                                <input type='hidden' name='pid' value='{$id}'>
                                <input type='submit' name='delete' value='Delete Bill'>
                            </form></td>
                          </tr>";
                }

                echo "<tr>
                        <td colspan=3 style='background-color:black;color:white;'><b>Total</b></td>
                        <td style='background-color:black;color:white;'><span class='name'>{$total}</span> /-</td>
                        </tr>";
                echo "</table>";
            } else {
                echo "<p style='text-align:center;color:red'>No bills found for this patient.</p>";
            }
        }
    } else {
        echo "<p style='text-align:center;color:red'>No patient ID provided.</p>";
    }
    ?>

    <a href="register.php" class="back">← Back to Home</a>

    <script>
        function removePatient(){
            let confirmMessage=confirm('Did the patient pay the bill?');
            if(confirmMessage){
                confirmMessage2=confirm('Can I delete this bill?');
            }
        }
    </script>
</body>

</html>