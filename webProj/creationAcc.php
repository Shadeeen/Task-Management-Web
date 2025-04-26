<?php
include("db.php.inc.php");
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userName = $_POST['userName'];
    $password = $_POST['password'];
    $conpassword = $_POST['conpassword'];



    if ($password != $conpassword) {
        $_SESSION['passError'] = "*The passwords didnt match.";
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    $query = "SELECT * FROM users WHERE userName = :userName";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':userName', $userName);
    $statement->execute();
    $user = $statement->fetch();

    if ($user) {
        $_SESSION['nameError'] = "*The userName already used.";
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    $_SESSION["userName"] = $_POST['userName'];
    $_SESSION["password"] = $_POST['password'];
    header('Location: confirmation.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include("registerheader.html");
?>
<main>
    <section>
        <div class="box">

            <form class="creatAcc" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                <div>
                    <label id="name">User Name:</label>
                    <input type="text" name="userName" id="userName" pattern="[A-Za-z]+" placeholder="user name (just letters)" minlength="6" maxlength="13" required>
                    <span class="error"><?php echo isset($_SESSION['nameError']) ? $_SESSION['nameError'] : ''; ?></span>
                </div>
                <div>
                    <label id="Password">Password:</label>
                    <input type="password" name="password" id="pass" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,12}$" placeholder="password (letters/numbers)" minlength="8" maxlength="12" required>
                </div>
                <div>
                    <label id="conPassword">Password:</label>
                    <input type="password" name="conpassword" id="pass" placeholder="enter the password again" minlength="8" maxlength="12" required>
                    <span class="error"><?php echo isset($_SESSION['passError']) ? $_SESSION['passError'] : ''; ?></span>
                </div>
                <div class="button">
                    <button type="submit">PROCEED TO CONFIRMATION</button>
                    <p id="note"><a href="register.php">Back</a></p>
                </div>
            </form>
        </div>
    </section>
</main>
<?php
unset($_SESSION['passError']);
unset($_SESSION['nameError']);

?>

<?php include("footer.html"); ?>

</body>

</html>