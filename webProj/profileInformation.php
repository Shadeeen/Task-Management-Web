<?php
session_start();
include("db.php.inc.php");

if (!isset($_SESSION['userName'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['userName'];
$query = "SELECT u.name, u.id, a.houseNo, a.street, a.city, a.country, u.birthDate, u.idNumber, u.email, u.phone, u.qualification, u.skills, u.role ,u.photo
          FROM users u
          JOIN address a ON u.address_id = a.address_id
          WHERE u.userName = :username";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':username', $username);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo 'No user found.';
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<?php if ($_SESSION['role'] == 'Manager') {
    include('managerMenu.html');
}
if ($_SESSION['role'] == 'Project-Leader') {
    include('leaderMenu.html');
}

if ($_SESSION['role'] == 'Team-Member') {
    $memberId = $_SESSION['id'];

    try {
        $query = "SELECT COUNT(*) 
          FROM user_tasks ut
          JOIN tasks t ON ut.task_id = t.task_id
          WHERE ut.user_id = :memberId AND t.status = 'Pending'";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':memberId', $memberId, PDO::PARAM_INT);
        $stmt->execute();
        $newTasksCount = $stmt->fetchColumn();
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
        exit;
    }

    $highlightAssignments = $newTasksCount > 0;
    include('memberMenu.html');
}
?>
<main class="profile-container">
    <h3><?php echo ($user['name']); ?> Information</h3>
    <div class="profile-card">
        <img src="<?php echo ($user['photo']); ?>" alt="<?php echo ($user['name']) . ' Photo'; ?>" class="user-photo">
        <div class="info-item"><strong>Name:</strong> <?php echo ($user['name']); ?></div>
        <div class="info-item"><strong>ID:</strong> <?php echo ($user['id']); ?></div>
        <div class="info-item"><strong>Address:</strong> <?php echo ($user['houseNo'] . " " . $user['street'] . ", " . $user['city'] . ", " . $user['country']); ?></div>
        <div class="info-item"><strong>Birth Date:</strong> <?php echo ($user['birthDate']); ?></div>
        <div class="info-item"><strong>ID Number:</strong> <?php echo ($user['idNumber']); ?></div>
        <div class="info-item"><strong>Email:</strong> <?php echo ($user['email']); ?></div>
        <div class="info-item"><strong>Phone:</strong> <?php echo ($user['phone']); ?></div>
        <div class="info-item"><strong>Qualification:</strong> <?php echo ($user['qualification']); ?></div>
        <div class="info-item"><strong>Skills:</strong> <?php echo ($user['skills']); ?></div>
        <div class="info-item"><strong>Role:</strong> <?php echo ($user['role']); ?></div>
    </div>
</main>
<footer>
    <p>Contact us on <a href="tel:+97224568466">+972 2 456 8466</a> | <a href="mailto:TAP.company@gmail.com">TAP.company@gmail.com</a></p>
    <p>©2024 Shadeen Hassan Hamda - ID 1220169 | <a href="aboutUs.php">About Us</a></p>
</footer>
</body>

</html>