<?php
include "../db.php";
session_start();

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $city = $_POST['city'];
    $type = $_POST['type'];
    $rooms = $_POST['rooms'];
    $bathrooms = $_POST['bathrooms'];
    $area = $_POST['area'];
    $price = $_POST['price'];
    $featured = isset($_POST['featured']) ? 1 : 0;
    // IMAGE UPLOAD
    $image_name = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];

    $upload_path = "../uploads/" . $image_name;

    move_uploaded_file($tmp_name, $upload_path);
    $sql = "INSERT INTO properties (name, description, location, city, type, rooms, bathrooms, area, price, image, featured) VALUES ('$name', '$description', '$location', '$city', '$type', '$rooms', '$bathrooms', '$area', '$price', '$image_name', '$featured')";
    if(mysqli_query($conn, $sql)){
        $_SESSION['success'] = "Property added successfully!";
    } else {
        $_SESSION['error'] = "Failed to add property!";
    }

    header("Location: index.php");
    exit();
    }

?>