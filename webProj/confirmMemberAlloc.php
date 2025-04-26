<?php
include("db.php.inc.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Confirmation Team Member</title>
    <?php include('leaderMenu.html'); ?>
</head>

<body>
    <main>
        <div class="container">
            <h3>ALLOCATE MEMBER COMPLETED</h3>
            <p>Team member successfully assigned to Task [<?php echo $_SESSION['currTaskId']; ?>] as
                [<?php echo $_SESSION['currMemberRole']; ?>].</p>

            <button class="button"><a href="teamAllocation.php?id=<?php echo urlencode($_SESSION['currTaskId']); ?>">Add Another Team Member</a></button>
            <button class="button"> <a href="taskDetails.php" class="button">Finish Allocation</a></button>
        </div>
    </main>
    <footer>
        <p>Contact us on <a href="tel:+97224568466">+972 2 456 8466</a> | <a href="mailto:TAP.company@gmail.com">TAP.company@gmail.com</a></p>
        <p>©2024 Shadeen Hassan Hamda - ID 1220169 | <a href="aboutUs.php">About Us</a></p>
    </footer>
</body>


</html>