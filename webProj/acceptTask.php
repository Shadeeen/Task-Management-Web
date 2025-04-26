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

$query = "SELECT  t.task_id,p.project_title ,t.task_name,ut.start_date , ut.member_role FROM user_tasks ut JOIN tasks t ON ut.task_id = t.task_id JOIN 
      projects p ON t.project_id = p.project_id WHERE ut.user_id = :memberId and t.status='pending'  ;";
$statement = $pdo->prepare($query);
$statement->bindValue(':memberId', $memberId);
$statement->execute();
$tasks = $statement->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Assignments</title>
    <?php include('memberMenu.html'); ?>
</head>

<body>
    <main>
        <div class="container">
            <h2>Tasks:</h2>

            <?php
            if (!empty($tasks)): ?>
                <table>
                    <tr>
                        <th>Task ID</th>
                        <th>Task Name</th>
                        <th>Project Name</th>
                        <th>Start Date</th>
                        <th>Confirm</th>
                    </tr>

                    <?php foreach ($tasks as $task) : ?>
                        <tr>
                            <td><?php echo ($task['task_id']); ?></td>
                            <td><?php echo ($task['task_name']); ?></td>
                            <td><?php echo ($task['project_title']); ?></td>
                            <td><?php echo ($task['start_date']); ?></td>
                            <td>
                                <a href="memberConfirm.php?taskId=<?php echo urlencode($task['task_id']); ?>&memberRole=<?php echo urlencode($task['member_role']); ?>&memberId=<?php echo urlencode($memberId); ?>">Confirm</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </table>

                <?php
                if (empty($tasks)): ?>
                    <p>There is no tasks to Assign</p>
                <?php endif; ?>
        </div>
    </main>
    <footer>
        <p>Contact us on <a href="tel:+97224568466">+972 2 456 8466</a> | <a href="mailto:TAP.company@gmail.com">TAP.company@gmail.com</a></p>
        <p>©2024 Shadeen Hassan Hamda - ID 1220169 | <a href="aboutUs.php">About Us</a></p>
    </footer>
</body>

</html>