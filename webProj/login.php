<?php
include("db.php.inc.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $userName = $_POST['userName'];
    $pass = $_POST['password'];
    $query = "SELECT userName, pass , role ,id  FROM users WHERE userName = :userName AND pass = :pass";

    $statement = $pdo->prepare($query);
    $statement->bindValue(':userName', $userName);
    $statement->bindValue(':pass', $pass);

    $statement->execute();

    $user = $statement->fetch();

    if (!$user) {
        $_SESSION['passNameError'] = "*The Username or Password is incorrect.";
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    if ($user) {

        $_SESSION["userName"] = $userName;
        $_SESSION["role"] = $user['role'];
        $_SESSION["id"] = $user['id'];


        if ($user['role'] == 'Manager') {
            header('Location:profileInformation.php');
            exit();
        } else if ($user['role'] == 'Project-Leader') {
            header('Location:profileInformation.php');
            exit();
        } else if ($user['role'] == 'Team-Member') {
            header('Location:profileInformation.php');
            exit();
        }

        header('Location: home.php');
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="image/Icon.png">
    <link rel="stylesheet" href="RegeStyle.css">
    <title>Login</title>
</head>

<body>
    <header>
        <div id="logo">
            <img src="image/logo.png" alt="Company logo" width="60" height="60">
            <h1>Welcome to TAP Company</h1>
        </div>
    </header>

    <main>
        <div class="box">
            <form class="logInForm" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form-row">
                    <label id="name">User Name:</label>
                    <input type="text" name="userName" id="userName" placeholder="enter the user name" required>
                </div>
                <div class="form-row">
                    <label id="Password">Password:</label>
                    <input type="password" name="password" id="pass" placeholder="enter your password" required>
                </div>
                <span class="error-message"><?php echo isset($_SESSION['passNameError']) ? $_SESSION['passNameError'] : ''; ?></span>
                <div class="button">
                    <button type="submit">LOGIN</button>
                    <p id="note">Dont Have an Account? <a href="register.php">sign up</a></p>
                </div>
            </form>
        </div>
    </main>

    <?php
    unset($_SESSION['passNameError']);
    unset($_SESSION['passNameClass']);
    ?>
    <?php include("footer.html"); ?>

</body>

</html>