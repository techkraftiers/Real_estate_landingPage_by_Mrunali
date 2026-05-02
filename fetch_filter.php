<?php
include "db.php";

$type = $_POST['type'] ?? 'buy';
$location = $_POST['location'] ?? '';
$price = $_POST['price'] ?? '';

// Build Query
$query = "SELECT * FROM properties WHERE type = '$type'";
if(!empty($location)) { $query .= " AND location = '".mysqli_real_escape_string($conn, $location)."'"; }
if(!empty($price)) { $query .= " AND price <= ".intval($price); }

$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        // Echo your card HTML here
        echo '<div class="filter-box-content">';
        echo '  <img src="./uploads/'.$row['image'].'" style="width:100%; height:180px; object-fit:cover;">';
        echo '  <div style="padding:15px;">';
        echo '    <h3 style="font-size:16px;">'.$row['name'].'</h3>';
        echo '    <p style="margin-top:1rem; font-size:1.2rem; font-weigth:500; ">₹ '.number_format($row['price']).'</p>';
        echo '    <a href="view_details.php?id='.$row['id'].'" class="filter-view-btn">View Details</a>';
        echo '  </div>';
        echo '</div>';
    }
} else {
    echo '<p class="placeholder-text">No properties found matching those filters.</p>';
}
?>