<?php 

session_start();
if(!isset($_SESSION['username'])){
    echo "<script>alert('Please Login');window.location.href='login.php';</script>";
}

$host = 'localhost';
$user = 'root';
$password = '';
$db = 'sivadb';
$conn = mysqli_connect($host, $user, $password, $db);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


// Check if the form is submitted for updating
if (isset($_POST['update_patient'])) {
    $patientId = $_POST['id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $age = (int)$_POST['age'];
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $medicine = mysqli_real_escape_string($conn, $_POST['medicine']);
    $bloodgroup = mysqli_real_escape_string($conn, $_POST['bloodgroup']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    // $amount = (float)$_POST['amount'];
    $symptoms = mysqli_real_escape_string($conn, $_POST['symptoms']);

    $updateQuery = "
        UPDATE patient SET 
            name = '$name',
            age = '$age',
            medicine='$medicine',
            phone = '$phone',
            bloodgroup = '$bloodgroup',
            email = '$email',
            symptoms = '$symptoms'
        WHERE id = '$patientId'
    ";

    if (mysqli_query($conn, $updateQuery)) {
        $message = "Patient updated successfully.";
    } else {
        $message = "Failed to update patient: " . mysqli_error($conn);
    }
    // Fetch updated data
    $sql = "SELECT * FROM patient WHERE id = '$patientId'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
} else {
    // First-time load: check if ID was sent
    if (!isset($_POST['id'])) {
        echo "No patient selected.";
        exit();
    }
    $patientId = $_POST['id'];

    $sql = "SELECT * FROM patient WHERE id = '$patientId'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Patient not found.";
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap');
        *{
            font-family:"Quicksand", sans-serif;
        }
        body {
        background-color: #f0f4f8;
        margin: 0;
        padding: 2rem;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background-color: #ffffff;
            border-radius: 10px;
            padding: 2rem 2.5rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 1.5rem;
        }

        form p {
            margin-bottom: 1rem;
            font-size: 1rem;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 0.7rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            box-sizing: border-box;
            transition: border 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="number"]:focus,
        textarea:focus {
            border-color: #007bff;
            outline: none;
        }

        textarea {
            resize: vertical;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .back-link {
            text-align: center;
            margin-top: 2rem;
        }

        .back-link a {
            color: #007bff;
            text-decoration: none;
            font-weight: 600;
        }

        .back-link a:hover {
            color: #0056b3;
        }

        p em {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>
<h2>Patient: <span style="text-transform: capitalize;"><?= htmlspecialchars($row['name']) ?></span></h2>

<?php if (isset($message)) : ?>
    <p style="color: green;"><em><?= $message ?></em></p>
<?php endif; ?>

<form method="POST">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">

    <p><strong>Name:</strong><br>
    <input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>"readonly></p>

    <p><strong>Age:</strong><br>
    <input type="number" name="age" value="<?= $row['age'] ?>" require></p>

    <p><strong>Phone:</strong><br>
    <input type="text" name="phone" value="<?= htmlspecialchars($row['phone']) ?>" readonly></p>

    <!-- <p><strong>Address:</strong><br>
    <input type="text" name="address" value="<?= htmlspecialchars($row['address']) ?>" readonly></p> -->

    <p><strong>Blood Group:</strong><br>
    <input type="text" name="bloodgroup" value="<?= htmlspecialchars($row['bloodgroup']) ?>" require></p>

    <p><strong>Email:</strong><br>
    <input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" readonly></p>

    <!-- <p><strong>Total Bill (₹):</strong><br>
    <input type="number" step="0.01" name="amount" value="<?= $row['amount'] ?>" readonly></p> -->

    <p><strong>Symptoms:</strong><br>
    <textarea name="symptoms" rows="4" style="width:100%;"><?= htmlspecialchars($row['symptoms']) ?></textarea></p>

    <p><strong>Prescription:</strong><br>
    <textarea name="medicine" rows="4" style="width:100%;"><?= htmlspecialchars($row['medicine']) ?></textarea></p>

    <input type="submit" name="update_patient" value="Update Patient" style="padding: 0.5rem 1rem;">
</form>

<div class="back-link">
    <a href="view_patients.php">← Back to Patient List</a>
</div>

</body>
</html>