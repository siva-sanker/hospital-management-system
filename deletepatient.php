<?php

    $host='localhost';
    $user='root';
    $password='';
    $db='sivadb';
    $conn=mysqli_connect($host,$user,$password,$db);
    if($conn){
        echo'connected';
    }
    else{
        echo'problem';
    }
    if(isset($_POST['id'])){
        $id=$_POST['id'];
        // echo"<br>". $id;
        $sql="delete from patient where id='$id'";
        try{
            if(mysqli_query($conn,$sql)){
                header("Location: viewpatient.php");
                exit();
            }
            else{
                echo'error while deleting data';
            }
        }
        catch(mysqli_sql_exception){
            echo"<script>alert('Patient bills pending');window.location.href='viewpatient.php';</script>";
        }
    }
    else{
        echo'no id found';
    }
?>