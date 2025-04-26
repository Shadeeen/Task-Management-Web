<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<?php include('managerMenu.html'); ?>
<main>
    <div class="container">
        <h3>ADD PROJECT COMPLETED</h3>
        <p>Project added successfully!</p>
        <p>the project ID is <?php echo $_SESSION['project_id'] ?> </p>
    </div>
</main>
<footer>
    <p>Contact us on <a href="tel:+97224568466">+972 2 456 8466</a> | <a href="mailto:TAP.company@gmail.com">TAP.company@gmail.com</a></p>
    <p>©2024 Shadeen Hassan Hamda - ID 1220169 | <a href="aboutUs.php">About Us</a></p>
</footer>
</body>

</html>