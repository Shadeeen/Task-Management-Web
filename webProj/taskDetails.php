<?php
include("db.php.inc.php");
session_start();

$selectedProjectId = $_POST['project'] ?? null;
$tasks = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $selectedProjectId) {
    $sql = "SELECT t.*, 
                   (SELECT COUNT(*) FROM user_tasks ut WHERE ut.task_id = t.task_id) AS member_count
            FROM tasks t
            WHERE t.project_id = :project_id
            ORDER BY member_count ASC, t.task_id ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':project_id', $selectedProjectId);
    $stmt->execute();
    $tasks = $stmt->fetchAll();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Assign members</title>
    <?php include('leaderMenu.html'); ?>
</head>

<body>

    <main>
        <div class="container">

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <label for="project">Projects:</label>
                <select name="project" id="project" onchange="this.form.submit()" required>
                    <option value="" disabled selected>Select project</option>
                    <?php
                    $leaderId = $_SESSION['id'];
                    $sql = "SELECT project_id, project_title FROM projects WHERE leaderId = :leaderId";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':leaderId', $leaderId);
                    $stmt->execute();
                    $projects = $stmt->fetchAll();
                    foreach ($projects as $project) {
                        echo '<option value="' . ($project['project_id']) . '"' . (isset($selectedProjectId) && $selectedProjectId == $project['project_id'] ? ' selected' : '') . '>' . ($project['project_title']) . " / " . ($project['project_id']) . '</option>';
                    }
                    ?>
                </select>

            </form>

        </div>

        <?php if ($tasks): ?>
            <h3>Tasks for <?php echo ($_POST['project']) ?> Project</h3>
            <table>
                <tr>
                    <th>Task ID</th>
                    <th>Task Name</th>
                    <th>Start Date</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Team Allocation</th>
                </tr>
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?php echo ($task['task_id']); ?></td>
                        <td><?php echo ($task['task_name']); ?></td>
                        <td><?php echo ($task['start_date']); ?></td>
                        <td><?php echo ($task['status']); ?></td>
                        <td><?php echo ($task['priority']); ?></td>
                        <td><a href="teamAllocation.php?id=<?php echo ($task['task_id']); ?>">Assign Team Members </a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
        <?php
        if (isset($_POST['project'])) {
            if (!$tasks) {
                echo "<h3>there is no tasks to the " . $_POST['project'] . " project</h3>";
            }
        }
        ?>
        </div>
    </main>
    <footer>
        <p>Contact us on <a href="tel:+97224568466">+972 2 456 8466</a> | <a href="mailto:TAP.company@gmail.com">TAP.company@gmail.com</a></p>
        <p>©2024 Shadeen Hassan Hamda - ID 1220169 | <a href="aboutUs.php">About Us</a></p>
    </footer>
</body>

</html>