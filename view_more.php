<?php include "db.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View More Products</title>
</head>
<body>
    <div class="view-more">
        <a href="index.php" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
        <h1>Find Your Dream Apartment</h1>
        <div class="latest-pro">
            <div class="listing-cards">
            <?php
            $result = mysqli_query($conn, "SELECT * FROM properties");
            while($row = mysqli_fetch_assoc($result)){ ?>
            <div class="cards">
                <div class="img-box">
                    <img src="../uploads/<?= $row['image']; ?>" alt="house image">
                </div>
                <h2><?= $row['name']; ?></h2>
                <span><i class="fa-solid fa-location-dot"></i> <?= $row['location']; ?></span>
                <p class="price"><?= number_format($row['price']); ?></p>
                <div class="sell-rent">
                    <p><?= ucfirst($row['type']); ?></p>
                </div>
            </div>
            <?php } ?>
        </div>
        </div>
        <div class="buy-pro">

        </div>
        <div class="on-rent"></div>
        <div class="mumbai-based"></div>
        <div class="Tow-BHK"></div>
        <div class="one-bhk"></div>
    </div>
</body>
</html>