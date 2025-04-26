<?php
session_start();
include("db.php.inc.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

    $progress = $_POST['progress'];
    $memberId = $_SESSION['id'];
    $taskId = $_GET['taskId'];
    $status = $_POST['status'];
    $selectedStatus = $_POST['status'] ?? 'pending';

    $perc = isset($_GET['perc']) ? $_GET['perc'] : 100;

    if (isset($_POST['progress'])) {
        if ($progress == 0) {
            $_SESSION['progressError'] = ' *you cant update the progress to 0';
            header('Location: ' . ($_SERVER['PHP_SELF']) . '?id=' . urlencode($taskId) . '&tname=' . urlencode($_POST['taskName']) . '&pname=' . urlencode($_POST['projectName']) . '&perc=' . urlencode($_GET['perc']) . '&progress=' . urlencode($_GET['progress']));
            exit();
        }
    }

    $progQuery = "SELECT t.progress FROM tasks t WHERE t.task_id = :taskId";
    $progStmt = $pdo->prepare($progQuery);
    $progStmt->bindValue(':taskId', $taskId, PDO::PARAM_INT);

    if ($progStmt->execute()) {
        $progs = $progStmt->fetch(PDO::FETCH_ASSOC);
        if ($progs['progress'] + $progress == 100) {
            $status = 'completed';
        }
        if ($progs['progress']  + $progress > 0 && $progs['progress']  + $progress < 100) {
            $status = 'in progress';
        }
        if ($progs['progress']  + $progress == 0) {
            $status = 'pending';
        }
    }
    if ($selectedStatus == 'completed') {
        $status = 'completed';
        $progress = $perc;
    } elseif ($selectedStatus == 'In Progress') {
        $status = 'in Progress';
    } elseif ($selectedStatus == 'Pending') {
        $status = 'pending';
        $progress = $progs['progress']  - $perc;
    } else {
        $status = $selectedStatus;
    }



    $updateQuery = "UPDATE tasks 
    SET progress = :progress , status = :status
    WHERE task_id IN (
        SELECT task_id 
        FROM user_tasks 
        WHERE user_id = :memberId
    ) AND task_id = :taskId";

    $stmt = $pdo->prepare($updateQuery);
    $stmt->bindValue(':status', $status);
    $stmt->bindValue(':progress', $progress);
    $stmt->bindValue(':taskId', $taskId);
    $stmt->bindValue(':memberId', $memberId);

    if ($stmt->execute()) {
        header("Location: successUpdate.php");
        exit();
    } else {
        $_SESSION['errorSQL'] = ' *there is sth wrong try again ';
    }
}


if (isset($_POST['cancel'])) {
    header("Location: searchUpdateTask.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Tasks</title>
    <?php include('memberMenu.html'); ?>

</head>

<body>
    <main>
        <div class="container">
            <form action="<?php echo $_SERVER['PHP_SELF'] . '?taskId=' . urldecode($_GET['id']) . '&perc=' . urldecode($_GET['perc']) . '&progress=' . urldecode($_GET['perc']) ?>" method="post">

                <lable id="taskID">Task ID</lable>
                <input type="text" name=taskId id="taskID" value="<?php echo ($_GET['id']) ?>" readonly>

                <lable id="taskName">Task Name</lable>
                <input type="text" name="taskName" value="<?php echo ($_GET['tname']) ?>" readonly>

                <lable id="projectName">Project Name</lable>
                <input type="text" name="projectName" value="<?php echo ($_GET['pname']) ?>" readonly>

                <lable>Current Status</lable>
                <select name="status">
                    <option value="in Progress">In Progress</option>
                    <option value="completed">Complete</option>
                    <option value="pending">Pending</option>

                </select>


                <label>Current Progress</label>
                <div>
                    <div class="range-slider">
                        <span>0%</span>
                        <input type="range" name="progress" id="progress" min="0" max="<?php echo ($_GET['perc']); ?>" value="<?php echo ($_GET['progress']); ?>">
                        <span><?php echo ($_GET['perc']); ?>%</span>
                        <span class="error-message"><?php echo isset($_SESSION['progressError']) ? $_SESSION['progressError'] : ''; ?></span>
                    </div>
                </div>
                <input type="hidden" name="perc" max="<?php echo ($_GET['perc']); ?>">
                <button type="submit" value="submit" name="submit">submit</button>
                <button value="Cancel" name="cancel">Cancel</button>
                <span class="error-message"><?php echo isset($_SESSION['errorSQl']) ? $_SESSION['errorSQl'] : ''; ?></span>
            </form>
        </div>
    </main>
    <?php
    unset($_SESSION['errorSQl']);
    unset($_SESSION['progressError']);
    ?>
    <footer>
        <p>Contact us on <a href="tel:+97224568466">+972 2 456 8466</a> | <a href="mailto:TAP.company@gmail.com">TAP.company@gmail.com</a></p>
        <p>©2024 Shadeen Hassan Hamda - ID 1220169 | <a href="aboutUs.php">About Us</a></p>
    </footer>

</body>

</html>