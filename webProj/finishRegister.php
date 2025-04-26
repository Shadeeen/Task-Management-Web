<?php
session_start();

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="image/Icon.png">
    <link rel="stylesheet" href="RegeStyle.css">
    <title>Welcome</title>
</head>

<body>
    <header>
        <div id="logo">
            <img src="image/logo.png" alt="Company logo" width="60" height="60">
            <h1>Welcome <?php echo $_SESSION["name"] ?></h1>
        </div>
    </header>
    <main>
        <div class="box">
            <section>
                <h2>Thank you for joining us</h2>
                <p>your ID will be <?php echo $_SESSION["id"] ?> </p>
                <p>you can login from here! <a href="login.php">login</a></p>
            </section>
        </div>
    </main>
    <?php include("footer.html"); ?>

</body>

</html>