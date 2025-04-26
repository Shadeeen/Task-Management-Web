<?php
session_start();
include("db.php.inc.php");

$username = $_SESSION['userName'];
$query = "SELECT u.name, u.id 
FROM users u
JOIN address a ON u.address_id = a.address_id
WHERE u.userName = :username";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':username', $username);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$memberId = $user['id'];

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
?>

<!DOCTYPE html>
<html lang="en">
<?php include("memberMenu.html") ?>
<main>

</main>
<footer>
    <p>Contact us on <a href="tel:+97224568466">+972 2 456 8466</a> | <a href="mailto:TAP.company@gmail.com">TAP.company@gmail.com</a></p>
    <p>©2024 Shadeen Hassan Hamda - ID 1220169 | <a href="aboutUs.php">About Us</a></p>
</footer>
</body>

</html>