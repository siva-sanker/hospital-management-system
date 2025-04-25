<?php
$host = 'localhost';
$user = 'root';
$password = '';
$db = 'sivadb';
$conn = mysqli_connect($host, $user, $password, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$pid = $_GET['pid'];
$bid = $_GET['bid'];
if (isset($pid) && isset($bid)) {
    $bill_id = $bid;
    $patient_id = $pid;

    // Step 1: Get the bill amount
    $query = "SELECT amount FROM bills WHERE id = $bill_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $bill = mysqli_fetch_assoc($result);
        $amount = $bill['amount'];

        // Step 2: Update patient's total amount
        $update = "UPDATE patient SET amount = amount - $amount WHERE id = $patient_id";
        mysqli_query($conn, $update);

        // Step 3: Delete the bill
        $delete = "DELETE FROM bills WHERE id = $bill_id";
        mysqli_query($conn, $delete);

        echo "<script>alert('Bill deleted successfully'); window.location.href='billpage.php?id=$patient_id';</script>";
    } else {
        echo "<script>alert('Bill not found.'); window.location.href='register.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href='register.php';</script>";
}

mysqli_close($conn);
?>
