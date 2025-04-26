<?php
session_start();
include("db.php.inc.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Allocation Completed</title>
    <?php include('managerMenu.html'); ?>
</head>

<body>
    <main>
        <div class="container">
            <h3>ALLOCATE LEADER COMPLETED</h3>
            <p>The project leader was added successfully!</p>
            <p>Team Leader successfully allocated to Project ID: <?php echo $_SESSION["currentProID"]; ?></p>
        </div>
    </main>
    <footer>
        <p>Contact us on <a href="tel:+97224568466">+972 2 456 8466</a> | <a href="mailto:TAP.company@gmail.com">TAP.company@gmail.com</a></p>
        <p>©2024 Shadeen Hassan Hamda - ID 1220169 | <a href="aboutUs.php">About Us</a></p>
    </footer>
</body>

</html>