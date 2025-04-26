<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<?php include('leaderMenu.html'); ?>
<main>
    <div class="container">
        <h3>CREATE TASK COMPLETED</h3>
        <p>Task added successfully!</p>
        <p>The task name is <?php echo $_SESSION['task_name']; ?></p>
    </div>
</main>
<footer>
    <p>Contact us on <a href="tel:+97224568466">+972 2 456 8466</a> | <a href="mailto:TAP.company@gmail.com">TAP.company@gmail.com</a></p>
    <p>©2024 Shadeen Hassan Hamda - ID 1220169 | <a href="aboutUs.php">About Us</a></p>
</footer>
</body>

</html>