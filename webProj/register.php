<?php
include("db.php.inc.php");
session_start();

$idNumberError = $emailError = $phoneError = "";
$idNumberClass = $emailClass = $phoneClass = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idNumber = $_POST['idNumber'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $query = "SELECT idNumber, email, phone FROM users WHERE idNumber = :idNumber OR email = :email OR phone = :phone";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':idNumber', $idNumber);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':phone', $phone);
    $statement->execute();

    $user = $statement->fetch();

    if ($user) {
        if ($user["idNumber"] == $idNumber) {
            $_SESSION['idNumberError'] = "*ID-Number already exists.";
        }
        if ($user["email"] == $email) {
            $_SESSION['emailError'] = "*Email already exists.";
        }
        if ($user["phone"] == $phone) {
            $_SESSION['phoneError'] = "*Phone already exists.";
        }

        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    $_SESSION["name"] = $_POST['name'];
    $_SESSION["birthDate"] = $_POST['birthDate'];
    $_SESSION["houseNo"] = $_POST['houseNo'];
    $_SESSION["street"] = $_POST['street'];
    $_SESSION["city"] = $_POST['city'];
    $_SESSION["country"] = $_POST['country'];
    $_SESSION["qualification"] = $_POST['qualification'];
    $_SESSION["skills"] = $_POST['skills'];
    $_SESSION["role"] = $_POST['role'];
    $_SESSION["idNumber"] = $_POST['idNumber'];
    $_SESSION["email"] = $_POST['email'];
    $_SESSION["phone"] = $_POST['phone'];
    $_SESSION["photo"] = $_POST['photo'];


    header('Location: creationAcc.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include("registerheader.html"); ?>

<main>
    <div class="box1">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <fieldset>
                <legend>
                    <h2>Profile Information</h2>
                </legend>
                <section class="container">

                    <div class="d1">
                        <label id="name">Name:</label>
                        <input type="text" name="name" id="name" placeholder="Enter your name" required>

                    </div>
                    <div class="d7">
                        <label id="IdNumber">ID-Number:</label>
                        <input type="number" id="idNumber" name="idNumber" min="10000000" max="99999999" placeholder="Enter 8-digit ID" required class="<?php echo $idNumberClass; ?>">
                        <span class="error-message"><?php echo isset($_SESSION['idNumberError']) ? $_SESSION['idNumberError'] : ''; ?></span>

                    </div>
                    <div class="d8">
                        <label id="email">Email:</label>
                        <input type="email" name="email" id="email" placeholder="Enter your email" required class="<?php echo $emailClass; ?>">
                        <span class="error-message"><?php echo isset($_SESSION['emailError']) ? $_SESSION['emailError'] : ''; ?></span>
                    </div>
                    <div class="d6">
                        <label id="birthDate">Birth-Date:</label>
                        <input type="date" name="birthDate" id="birthDate" placeholder="select your birth Date" max="<?php echo date('Y-m-d'); ?>" required>
                    </div>

                    <div class="d2">
                        <label id="houseNo">House-No:</label>
                        <input type="text" name="houseNo" id="houseNo" placeholder="Enter your house-No" required>
                    </div>
                    <div class="d3">
                        <label id="street">Street:</label>
                        <input type="text" name="street" id="street" placeholder="Enter the street" required>
                    </div>
                    <div class="d4">
                        <label id="city">City:</label>
                        <input type="text" name="city" id="city" placeholder="Enter the city" required>
                    </div>
                    <div class="d5">
                        <label id="country">Country:</label>
                        <input type="text" name="country" id="country" placeholder="Enter the country" required>
                    </div>

                    <div class="d9">
                        <label id="phone">Phone:</label>
                        <input type="tel" name="phone" id="phone" placeholder="Enter your phone" maxlength="10" minlength="10" required class="<?php echo $phoneClass; ?>">
                        <span class="error-message"><?php echo isset($_SESSION['phoneError']) ? $_SESSION['phoneError'] : ''; ?></span>
                    </div>

                    <div class="d11">
                        <label id="qualification">Qualification:</label>
                        <input type="text" name="qualification" id="qualification" placeholder="Enter the qualification" required>
                    </div>
                    <div class="d12">
                        <label id="skills">Skills:</label>
                        <input type="text" name="skills" id="skills" placeholder="Enter your skills" required>
                    </div>
                    <div class="d10">
                        <label>Role:</label>
                        <select id="role" class="role" name="role" required>
                            <option value="Manager">Manager</option>
                            <option value="Project-Leader">Project Leader</option>
                            <option value="Team-Member">Team Member</option>
                        </select>
                    </div>

                </section>
                <div>
                    <label>Your Photo:</label>
                    <input type="file" name="photo">
                </div>
                <div class="signup">
                    <button type="submit">PROCEED</button>
                    <p id="note">Do you already have an account? <a href="login.php">Login</a></p>
                </div>
            </fieldset>
        </form>
    </div>
</main>
<?php
unset($_SESSION['idNumberError'], $_SESSION['emailError'], $_SESSION['phoneError']);
unset($_SESSION['idNumberClass'], $_SESSION['emailClass'], $_SESSION['phoneClass']);
?>
<?php include("footer.html"); ?>
</body>

</html>