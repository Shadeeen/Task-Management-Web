<?php
include("db.php.inc.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $taskId = $_POST['taskId'];
    $memberId = $_POST['memberID'];
    $memberRole = $_POST['memberRole'];
    $percentage = $_POST['percentage'];
    $startDate = $_POST['startDate'];


    $query = "SELECT SUM(percentage) AS total_percentage FROM user_tasks WHERE task_id = :taskId";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':taskId', $taskId);
    $stmt->execute();
    $result = $stmt->fetch();
    $totalPercentage = $result['total_percentage'] + $percentage;

    if ($totalPercentage > 100) {
        $_SESSION['percentageError'] = "The total percentage cannot exceed 100%. Current total: " . $result['total_percentage'] . "%.";
        header('Location: ' . $_SERVER['PHP_SELF'] . '?id=' . urlencode($taskId));
        exit();
    }

    $checkQuery = "SELECT 1 FROM user_tasks WHERE task_id = :taskId AND user_id = :memberId";
    $checkStmt = $pdo->prepare($checkQuery);
    $checkStmt->bindValue(':taskId', $taskId);
    $checkStmt->bindValue(':memberId', $memberId);
    $checkStmt->execute();
    if ($checkStmt->fetch()) {
        $_SESSION['memberError'] = $memberId . " ID Member is already assigned to this task.";
        header('Location: ' . $_SERVER['PHP_SELF'] . '?id=' . urlencode($taskId));
        exit();
    }

    $date = $_POST['date'];
    if ($date > $startDate) {
        $_SESSION['dateError'] = "The date cant be before: " . $date;
        header('Location: ' . $_SERVER['PHP_SELF'] . '?id=' . urlencode($taskId));
        exit();
    }

    $insertQuery = "INSERT INTO user_tasks (task_id, user_id, member_role, start_date, percentage) VALUES (:taskId, :memberId, :memberRole, :startDate, :percentage)";
    $insertStmt = $pdo->prepare($insertQuery);
    $insertStmt->bindValue(':taskId', $taskId);
    $insertStmt->bindValue(':memberId', $memberId);
    $insertStmt->bindValue(':memberRole', $memberRole);
    $insertStmt->bindValue(':startDate', $startDate);
    $insertStmt->bindValue(':percentage', $percentage);
    if ($insertStmt->execute()) {
        $_SESSION['currTaskId'] = $taskId;
        $_SESSION['currMemberRole'] = $memberRole;
        header('Location: confirmMemberAlloc.php');
        exit();
    } else {
        $_SESSION['SQLerror'] = "Failed to allocate member";
        header('Location: ' . $_SERVER['PHP_SELF'] . '?id=' . urlencode($taskId));
        exit();
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <title>Team Allocate</title>
    <?php include('leaderMenu.html'); ?>

<body>
    <main>
        <div class="container">
            <h2>Select Team member</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <?php
                $taskId = $_GET['id'] ?? '';
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
                    }
                }
                ?>

                <div class="allocationBox">
                    <label for="members">Member`s To Allocate:</label>
                    <select name="memberID" id="memberID" required>
                        <option value="" disabled selected style="display:none;">Select an option</option>
                        <?php
                        $sql = "SELECT u.id, u.name 
                            FROM users u 
                            WHERE u.role = 'Team-Member' ";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        $members = $stmt->fetchAll();
                        foreach ($members as $member) {
                            echo '<option value="' . ($member['id']) . '">' . ($member['name']) . " " . ($member['id']) . '</option>';
                        }
                        ?>
                    </select>
                    <span class="error-message"><?php echo isset($_SESSION['memberError']) ? $_SESSION['memberError'] : ''; ?></span>

                    <label for="memberRole">Member Role:</label>
                    <select name="memberRole" id="memberRole" required>
                        <option value="developer">Developer</option>
                        <option value="designer">Designer</option>
                        <option value="tester">Tester</option>
                        <option value="analyst">Analyst</option>
                        <option value="support">Support</option>
                    </select>

                    <?php
                    $taskId = $_GET['id'] ?? '';
                    if (!empty($taskId)) {
                        $query = "SELECT start_date FROM tasks WHERE task_id = :taskId";
                        $statement = $pdo->prepare($query);
                        $statement->bindValue(':taskId', $taskId);
                        $statement->execute();
                        $task = $statement->fetch();
                        $date = '';
                        if ($task) {
                            $date = $task['start_date'];
                        }
                    }
                    ?>

                    <label for="startDate">Start Date</label>
                    <input type="date" value="<?php echo $date; ?>" name="startDate" required>
                    <span class="error-message"><?php echo isset($_SESSION['dateError']) ? $_SESSION['dateError'] : ''; ?></span>

                    <label for=" persantage">Contribution Percentage</label>
                    <input type="number" name="percentage" min='1' max='100' required>
                    <span class="error-message"><?php echo $_SESSION['percentageError'] ?? ''; ?></span>

                    <input type='hidden' name='taskId' value="<?php echo ($taskId); ?>">
                    <input type='hidden' name='date' value="<?php echo ($date); ?>">


                    <input type="submit" value="Allocate ">
                    <span class="error-message"><?php echo isset($_SESSION['SQLerror']) ? $_SESSION['SQLerror'] : ''; ?></span>
                </div>
            </form>
        </div>
    </main>
    <?php
    unset($_SESSION['SQLerror']);
    unset($_SESSION['percentageError']);
    unset($_SESSION['dateError']);
    unset($_SESSION['memberError']);


    ?>
    <footer>
        <p>Contact us on <a href="tel:+97224568466">+972 2 456 8466</a> | <a href="mailto:TAP.company@gmail.com">TAP.company@gmail.com</a></p>
        <p>©2024 Shadeen Hassan Hamda - ID 1220169 | <a href="aboutUs.php">About Us</a></p>
    </footer>
</body>

</html>