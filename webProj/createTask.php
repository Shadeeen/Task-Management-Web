<?php
include("db.php.inc.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $projectID = $_POST['project'];

    $query = "SELECT start_date, end_date FROM projects WHERE project_id = :project_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':project_id', $projectID);
    $stmt->execute();
    $project = $stmt->fetch();

    if ($startDate < $project['start_date'] || $endDate > $project['end_date']) {
        $_SESSION['dateError'] = "*The Task dates must be within " . $project['start_date'] . " to " . $project['end_date'] . ".";
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    $taskName = $_POST['taskName'];
    $taskID = $_POST['taskID'];
    $description = $_POST['taskDescription'];
    $effort = $_POST['effort'];
    $status = $_POST['status'];
    $priority = $_POST['priority'];

    if (!empty($taskID)) {
        $checkTaskID = $pdo->prepare("SELECT task_id FROM tasks WHERE task_id = :task_id");
        $checkTaskID->bindValue(':task_id', $taskID);
        $checkTaskID->execute();
        if ($checkTaskID->fetch()) {
            $_SESSION['TIDerror'] = "Task ID already exists.";
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        }
    }

    $checkTaskName = $pdo->prepare("SELECT task_name FROM tasks WHERE task_name = :task_name");
    $checkTaskName->bindValue(':task_name', $taskName);
    $checkTaskName->execute();
    if ($checkTaskName->fetch()) {
        $_SESSION['nameTaskError'] = "Task Name already exists.";
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    $insertQuery = "INSERT INTO tasks (task_id, task_name, description, project_id, start_date, end_date, effort, status, priority) VALUES (:task_id, :task_name, :description, :project_id, :start_date, :end_date, :effort, :status, :priority)";
    $insertStmt = $pdo->prepare($insertQuery);
    $insertStmt->bindValue(':task_id', $taskID);
    $insertStmt->bindValue(':task_name', $taskName);
    $insertStmt->bindValue(':description', $description);
    $insertStmt->bindValue(':project_id', $projectID);
    $insertStmt->bindValue(':start_date', $startDate);
    $insertStmt->bindValue(':end_date', $endDate);
    $insertStmt->bindValue(':effort', $effort);
    $insertStmt->bindValue(':status', $status);
    $insertStmt->bindValue(':priority', $priority);

    if ($insertStmt->execute()) {
        $_SESSION['task_name'] = $taskName;
        header('Location: confirmTask.php');
        exit();
    } else {
        $_SESSION['errorData'] = 'Failed to add the task. Please try again.';
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}

$username = $_SESSION['userName'];
$query = "SELECT project_id, project_title FROM projects JOIN users ON projects.leaderId = users.id WHERE users.username = :username";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':username', $username);
$stmt->execute();
$projects = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<?php include('leaderMenu.html'); ?>
<main>
    <div class="container">
        <h3>Create Task:</h3>
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="form-group">
                <label for="taskID">Task ID:</label>
                <input type="text" id="taskID" name="taskID" placeholder="task ID" required>
                <span class="error"><?php echo isset($_SESSION['TIDerror']) ? $_SESSION['TIDerror'] : ''; ?></span>
            </div>
            <div class="form-group">
                <label for="taskName">Task Name:</label>
                <input type="text" id="taskName" name="taskName" placeholder="Task Title" required>
                <span class="error"><?php echo isset($_SESSION['nameTaskError']) ? $_SESSION['nameTaskError'] : ''; ?></span>
            </div>
            <div class="form-group">
                <label for="taskDescription">Task Description:</label>
                <textarea id="taskDescription" name="taskDescription" required placeholder="Task Description"></textarea>
            </div>

            <div class="form-group">
                <label for="project">Project:</label>
                <select name="project" id="project" required>
                    <option value="" disabled selected>Select project</option>
                    <?php foreach ($projects as $project): ?>
                        <option value="<?php echo ($project['project_id']); ?>">
                            <?php echo ($project['project_title']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="startDate">Start Date:</label>
                <input type="date" id="startDate" name="startDate" required>
            </div>
            <div class="form-group">
                <label for="endDate">End Date:</label>
                <input type="date" id="endDate" name="endDate" required>
            </div>
            <span class="error"><?php echo isset($_SESSION['dateError']) ? $_SESSION['dateError'] : ''; ?></span>
            <div class="form-group">
                <label id="effort">Effort:</label>
                <input type="number" id="effort" name="effort" min="1" placeholder="effort in month">
            </div>
            <div class="form-group">
                <label id="status">Status:</label>
                <select name="status">
                    <option value="pending">Pending</option>
                    <option value="in Progress">Progress</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
            <div class="form-group">
                <label id="priority">Priority:</label>
                <select name="priority">
                    <option value="low">Low</option>
                    <option value="high">High</option>
                    <option value="medium">Medium</option>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" value="Create Task" class="submit-button">
                <span class="error"><?php echo isset($_SESSION['errorData']) ? $_SESSION['errorData'] : ''; ?></span>
            </div>
        </form>
    </div>
</main>
<?php
unset($_SESSION['dateError']);
unset($_SESSION['nameTaskError']);
unset($_SESSION['TIDerror']);
unset($_SESSION['errorData']);

?>
<footer>
    <p>Contact us on <a href="tel:+97224568466">+972 2 456 8466</a> | <a href="mailto:TAP.company@gmail.com">TAP.company@gmail.com</a></p>
    <p>©2024 Shadeen Hassan Hamda - ID 1220169 | <a href="aboutUs.php">About Us</a></p>
</footer>
</body>

</html>