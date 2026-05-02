<?php include "./db.php";
session_start();

if(isset($_SESSION['success'])){
    echo "<div class='toast success'>{$_SESSION['success']}</div>";
    unset($_SESSION['success']);
}

if(isset($_SESSION['error'])){
    echo "<div class='toast error'>{$_SESSION['error']}</div>";
    unset($_SESSION['error']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Property</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-color: #fafcff;">
    <div class="post">
        <a href="index.php" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
        <h1>Post Your Property Here</h1>
        <form action="property.php" method="post" class="post-form" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Property name" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <input type="text" name="location" placeholder="Location" required>
            <input type="text" name="city" placeholder="City" required>
            <select name="type" required>
                <option value="">Select Type</option>
                <option value="buy">For Buy</option>
                <option value="rent">For Rent</option>
            </select>
            <input type="number" name="rooms" placeholder="Rooms" required>
            <input type="number" name="bathrooms" placeholder="Bathrooms" required>
            <input type="number" name="area" placeholder="Area (sq ft)">
            <input type="number" name="price" placeholder="Price" required>
            <label class="custom-file-upload">
                <input type="file" name="image" required />
                <span class="upload-button">Choose File</span>
                <span class="file-name">No file chosen</span>
            </label>
            <button type="submit" name="submit" class="form-btn">Post Property</button>
        </form>
    </div>
    <script>
        const fileInput = document.querySelector('input[type="file"]');
        const fileNameDisplay = document.querySelector('.file-name');

        fileInput.addEventListener('change', function() {
        if (this.files && this.files.length > 0) {
            fileNameDisplay.textContent = this.files[0].name;
        } else {
            fileNameDisplay.textContent = "No file chosen";
        }
        });
    </script>
</body>
</html>