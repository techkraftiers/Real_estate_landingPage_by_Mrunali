<?php include "db.php"; 
$id = intval($_GET['id']); // important
// Fetch existing data
$result = mysqli_query($conn, "SELECT * FROM properties WHERE id=$id");
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Property</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-color: #f4fbff;">
    <div class="view-content">
        <div class="img-box">
            <img src="./uploads/<?= $row['image']; ?>" alt="house image">
        </div>
        <div class="details">
            <h1><?= $row['name']; ?></h1>
            <p class="loaction"><i class="fa-solid fa-location-dot"></i> <?= $row['location']; ?>, <?= $row['city']; ?></p>
            <h2 class="pro-price"><i class="fa-solid fa-indian-rupee-sign"></i><?= number_format($row['price']); ?></h2>
            <span class="type"><?= ucfirst($row['type']); ?></span>
            <div class="pro-info">
                <p><i class="fa-solid fa-bed"></i> <span><?= $row['rooms']; ?> Beds</span></p>
                <p><i class="fa-solid fa-bath"></i> <span><?= $row['bathrooms']; ?> Baths</span></p>
                <p><i class="fa-solid fa-ruler-combined"></i> <span><?= $row['area'] ?> sqft</span></p>
            </div>
            <div class="description">
                <h2>Description</h2>
                <p><?= $row['description']; ?></p>
            </div>
            <div class="actions">
                <button>Book Slot</button>
                <button class="hart"><i class="fa-regular fa-heart"></i></button>
                <button><i class="fa-solid fa-share-nodes"></i></button>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>