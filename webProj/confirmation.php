<?php
include("db.php.inc.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $houseNo = $_SESSION["houseNo"];
    $country = $_SESSION["country"];
    $city = $_SESSION["city"];
    $street = $_SESSION["street"];

    $addressQuery = "INSERT INTO address (houseNo, street, city, country) VALUES (:houseNo, :street, :city, :country)";
    $addressStatement = $pdo->prepare($addressQuery);
    $addressStatement->bindValue(':houseNo', $houseNo);
    $addressStatement->bindValue(':street', $street);
    $addressStatement->bindValue(':city', $city);
    $addressStatement->bindValue(':country', $country);
    $addressStatement->execute();


    $name = $_SESSION["name"];
    $birthDate = $_SESSION["birthDate"];
    $idNumber = $_SESSION["idNumber"];
    $email = $_SESSION["email"];
    $phone = $_SESSION["phone"];
    $qualification = $_SESSION["qualification"];
    $skills = $_SESSION["skills"];
    $role = $_SESSION["role"];
    $userName = $_SESSION["userName"];
    $pass = $_SESSION["password"];
    $photo = $_SESSION["photo"];

    $addressId = $pdo->lastInsertId();
    $userQuery = "INSERT INTO users (name, email, birthDate, idNumber, phone, qualification, skills,role, address_id, userName, pass,photo) 
                  VALUES (:name, :email, :birthDate, :idNumber, :phone, :qualification, :skills,:role, :address_id, :userName, :pass,:photo)";

    $statement = $pdo->prepare($userQuery);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':address_id', $addressId);
    $statement->bindValue(':birthDate', $birthDate);
    $statement->bindValue(':idNumber', $idNumber);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':phone', $phone);
    $statement->bindValue(':qualification', $qualification);
    $statement->bindValue(':skills', $skills);
    $statement->bindValue(':role', $role);
    $statement->bindValue(':userName', $userName);
    $statement->bindValue(':pass', $pass);
    $statement->bindValue(':photo', $photo);

    $statement->execute();

    $idquery = "SELECT id FROM users WHERE idNumber = :idNumber";
    $idstatement = $pdo->prepare($idquery);
    $idstatement->bindValue(':idNumber', $idNumber);
    $idstatement->execute();
    $id = $idstatement->fetch();
    $_SESSION["id"] = $id["id"];

    header('Location: finishRegister.php');
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="image/Icon.png">
    <link rel="stylesheet" href="RegeStyle.css">
    <title>confirmation</title>
</head>

<body>
    <header>
        <div id="logo">
            <img src="image/logo.png" alt="Company logo" width="60" height="60">
        </div>
    </header>
    <main>
        <div class="box">
            <h3 id="registration-completed">REGISTRATION COMPLETED</h3>
            <table>
                <tr>
                    <td>Name:</td>
                    <td><?php echo $_SESSION["name"]; ?></td>
                </tr>
                <tr>
                    <td>address:</td>
                    <td><?php echo $_SESSION["houseNo"] . " " . $_SESSION["country"] . " " . $_SESSION["city"] . " " . $_SESSION["street"]; ?></td>
                </tr>
                <tr>
                    <td>Birth Date:</td>
                    <td><?php echo $_SESSION["birthDate"]; ?></td>
                </tr>
                <tr>
                    <td>ID Number:</td>
                    <td><?php echo $_SESSION["idNumber"]; ?></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><?php echo $_SESSION["email"]; ?></td>
                </tr>
                <tr>
                    <td>Phone:</td>
                    <td><?php echo $_SESSION["phone"]; ?></td>
                </tr>
                <tr>
                    <td>Qualification:</td>
                    <td><?php echo $_SESSION["qualification"]; ?></td>
                </tr>
                <tr>
                    <td>Skills:</td>
                    <td><?php echo $_SESSION["skills"]; ?></td>
                </tr>
                <tr>
                    <td>Role:</td>
                    <td><?php echo $_SESSION["role"]; ?></td>
                </tr>
                <tr>
                    <td>User Name:</td>
                    <td><?php echo $_SESSION["userName"]; ?></td>
                </tr>

            </table>

            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="button">
                    <button type="submit">CONFIRM</button>
                    <p id="note"><a href="register.php">Back</a></p>
                </div>
            </form>
        </div>
    </main>
    <?php include("footer.html"); ?>
</body>

</html>