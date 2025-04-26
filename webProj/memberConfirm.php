<?php
session_start();
include("db.php.inc.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $taskId = $_GET['taskId'];
    $memberId = $_GET['memberId'];



    if ($_POST['action'] == 'Accept') {
        $updateQuery = "UPDATE tasks SET status = 'in Progress' WHERE task_id = :taskId ";
        $stmt = $pdo->prepare($updateQuery);
        $stmt->bindValue(':taskId', $taskId);
        if ($stmt->execute()) {
            header("location: accept.php");
            exit();
        }
    } elseif ($_POST['action'] == 'Reject') {
        $deleteQuery = "DELETE FROM user_tasks WHERE task_id = :taskId AND user_id = :memberId";
        $stmt = $pdo->prepare($deleteQuery);
        $stmt->bindValue(':taskId', $taskId);
        $stmt->bindValue(':memberId', $memberId);
        if ($stmt->execute()) {
            header("location: reject.php");
            exit();
        }
    }
}

$taskId = $_GET['taskId'];
$memberId = $_GET['memberId'];
$memberRole = $_GET['memberRole'];

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
            <form action="<?php echo $_SERVER['PHP_SELF'] . '?taskId=' . urlencode($taskId) . '&memberId=' . urlencode($memberId) . '&memberRole=' . urlencode($memberRole); ?>" method="post">
                <?php
                $taskId = $_GET['taskId'] ?? '';
                if (!empty($taskId)) {

                    $query = "SELECT * FROM tasks WHERE task_id = :taskId";
                    $statement = $pdo->prepare($query);
                    $statement->bindValue(':taskId', $taskId);
                    $statement->execute();
                    $task = $statement->fetch();

                    if ($task) {
                        echo '<label for="taskId">Task ID:</label>';
                        echo "<input type='text' id='taskId' name='taskId' value='" . ($task['task_id']) . "' disabled>";

                        echo '<label for="taskName">Task Name:</label>';
                        echo "<input type='text' id='taskName' value='" . ($task['task_name']) . "' disabled>";

                        echo '<label for="description">Task Description:</label>';
                        echo "<textarea id='description' disabled>" . ($task['description']) . "</textarea>";

                        echo '<label for="priority">Priority:</label>';
                        echo "<input type='text' id='priority' value='" . ($task['priority']) . "' disabled>";

                        echo '<label for="status">Status:</label>';
                        echo "<input type='text' id='status' value='" . ($task['status']) . "' disabled>";

                        echo '<label for="effort">Effort:</label>';
                        echo "<input type='text' id='effort' value='" . ($task['effort']) . "' disabled>";

                        echo '<label for="role">member Role:</label>';
                        echo "<input type='text' id='role' value='" . ($memberRole) . "' disabled>";

                        echo '<label for="start_date">Start Date:</label>';
                        echo "<input type='date' id='start_date' value='" . ($task['start_date']) . "' disabled>";

                        echo '<label for="end_date">End Date:</label>';
                        echo "<input type='date' id='end_date' value='" . ($task['end_date']) . "' disabled>";
                    }
                }
                ?>
                <input type='hidden' name='taskId' value="<?php echo htmlspecialchars($taskId); ?>">
                <input type='hidden' name='memberId' value="<?php echo htmlspecialchars($memberId); ?>">
                <div class="button-container">
                    <input type="submit" class="button accept" name="action" value="Accept">
                    <span class="error-message"><?php echo isset($_SESSION['SQLerror']) ? $_SESSION['SQLerror'] : ''; ?></span>
                    <input type="submit" class="button reject" name="action" value="Reject">
                </div>
        </div>
        </form>
        </div>
    </main>
    <footer>
        <p>Contact us on <a href="tel:+97224568466">+972 2 456 8466</a> | <a href="mailto:TAP.company@gmail.com">TAP.company@gmail.com</a></p>
        <p>©2024 Shadeen Hassan Hamda - ID 1220169 | <a href="aboutUs.php">About Us</a></p>
    </footer>
</body>

</html>