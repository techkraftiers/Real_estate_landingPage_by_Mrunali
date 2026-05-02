<?php
include "db.php";
session_start();


if(isset($_POST['submit'])){
    $name = $_POST['parent_name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $message = $_POST['message'];
    if(!empty($email) && !empty($message)){
        $sql = "INSERT INTO messages, email, message, number) VALUE('$name', '$email', '$message', '$number')";
        $result = mysqli_query($conn, $sql);

        if($result){
            $_SESSION['success'] = "Message send successfully!";
        } else{
            $_SESSION['error'] = "Failed to send message!";
        }
        header("Location: index.php");
         exit();

    }
    else{
        echo ("Please fill all the input filed");
    }
}

?>