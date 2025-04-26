<?php
session_start();
include("db.php.inc.php");

$tasks = [];
$filters = [
    'priority' => $_POST['priority'] ?? $_GET['priority'] ?? '',
    'status' => $_POST['status'] ?? $_GET['status'] ?? '',
    'start_date' => $_POST['start_date'] ?? $_GET['start_date'] ?? '',
    'end_date' => $_POST['end_date'] ?? $_GET['end_date'] ?? '',
    'projectName' => $_POST['projectName'] ?? $_GET['projectName'] ?? ''
];

$_SESSION['filters'] = $filters;

$query = "SELECT t.*, p.project_title FROM tasks t JOIN projects p ON t.project_id = p.project_id";
$conditions = [];
$params = [];

if ($_SESSION['role'] == 'Team-Member') {
    $conditions[] = "ut.user_id = :memberId";
    $params[':memberId'] = $_SESSION['id'];
    $query .= " JOIN user_tasks ut ON t.task_id = ut.task_id";
}

if ($_SESSION['role'] == 'Project-Leader') {
    $conditions[] = "p.leaderId = :leaderId";
    $params[':leaderId'] = $_SESSION['id'];
}

foreach ($filters as $key => $value) {
    if (!empty($value)) {
        if ($key == 'projectName') {
            $conditions[] = "p.project_title LIKE :$key";
            $params[":$key"] = "%$value%";
        } else {
            $conditions[] = "t.$key = :$key";
            $params[":$key"] = $value;
        }
    }
}

if ($conditions) {
    $query .= " WHERE " . implode(' AND ', $conditions);
}

$sort = $_GET['sort'] ?? 'task_id';
$sort_order = $_GET['order'] ?? 'asc';
$query .= " ORDER BY $sort $sort_order";

$stmt = $pdo->prepare($query);
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->execute();
$tasks = $stmt->fetchAll();
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
    include('memberMenu.html');
}
?>
<main>
    <div class="containerr">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="search-form">
            <div class="formGroup">
                <label for="priority" class="form-label">Priority:</label>
                <select name="priority" id="priority" class="form-control">
                    <option value="">All</option>
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                </select>
            </div>

            <div class="formGroup">
                <label for="status" class="form-label">Status:</label>
                <select name="status" id="status" class="form-control">
                    <option value="">All</option>
                    <option value="pending">Pending</option>
                    <option value="in Progress">In Progress</option>
                    <option value="completed">Completed</option>
                </select>
            </div>

            <div class="formGroup">
                <label for="start_date" class="form-label">Start Date:</label>
                <input type="date" name="start_date" id="start_date" class="form-control">
            </div>
            <div class="formGroup">
                <label for="end_date" class="form-label">End Date:</label>
                <input type="date" name="end_date" id="end_date" class="form-control">
            </div>


            <div class="formGroup">
                <label for="project" class="form-label">Projects:</label>
                <input type="text" name="projectName" id="project" class="form-control">
            </div>
            <button type="submit" class="btn">Search</button>
        </form>
    </div>

    <div class="containerr">
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
            $taskId = $_POST['taskId'];
            $taskName = $_POST['taskName'];
            $projectName = $_POST['projectName'];
        }
        $memberRole = $_SESSION['role'];
        $memberId = $_SESSION['id'];

        if ($memberRole == 'Team-Member') {
            $query = "SELECT t.*, p.project_title 
            FROM tasks t 
            JOIN user_tasks ut ON t.task_id = ut.task_id
            JOIN projects p ON t.project_id = p.project_id
            WHERE ut.user_id = :memberId";
            $stmt = $pdo->prepare($query);
            if (!empty($taskId)) {
                $stmt->bindValue(':memberId', $memberId);
                $stmt->execute();
                $tasks = $stmt->fetchAll();
            }
        }

        if ($memberRole == 'Project-Leader') {
            $query = "SELECT t.*, p.project_title 
            FROM tasks t 
            JOIN projects p ON t.project_id = p.project_id
            WHERE p.leaderId = :memberId";
            $stmt = $pdo->prepare($query);
            if (!empty($taskId)) {
                $stmt->bindValue(':memberId', $memberId);
                $stmt->execute();
                $tasks = $stmt->fetchAll();
            }
        }

        if ($memberRole == 'Manager') {
            $query = "SELECT t.*, p.project_title
              FROM tasks t
              JOIN projects p ON t.project_id = p.project_id";

            $stmt = $pdo->prepare($query);
            if (!empty($taskId)) {
                $stmt->bindValue(':memberId', $memberId);
                $stmt->execute();
                $tasks = $stmt->fetchAll();
            }
        }
        ?>

        <?php if (!empty($tasks)): ?>
            <table>
                <thead>
                    <tr>
                        <th><a href="?sort=task_id&order=<?php echo $sort_order == 'asc' ? 'desc' : 'asc'; ?>&<?php echo http_build_query($filters); ?>">Task ID</a></th>
                        <th><a href="?sort=task_name&order=<?php echo $sort_order == 'asc' ? 'desc' : 'asc'; ?>&<?php echo http_build_query($filters); ?>">Task Name</a></th>
                        <th><a href="?sort=project_title&order=<?php echo $sort_order == 'asc' ? 'desc' : 'asc'; ?>&<?php echo http_build_query($filters); ?>">Project Name</a></th>
                        <th><a href="?sort=status&order=<?php echo $sort_order == 'asc' ? 'desc' : 'asc'; ?>&<?php echo http_build_query($filters); ?>">Status</a></th>
                        <th><a href="?sort=priority&order=<?php echo $sort_order == 'asc' ? 'desc' : 'asc'; ?>&<?php echo http_build_query($filters); ?>">Priority</a></th>
                        <th><a href="?sort=start_date&order=<?php echo $sort_order == 'asc' ? 'desc' : 'asc'; ?>&<?php echo http_build_query($filters); ?>">Start Date</a></th>
                        <th><a href="?sort=end_date&order=<?php echo $sort_order == 'asc' ? 'desc' : 'asc'; ?>&<?php echo http_build_query($filters); ?>">End Date</a></th>
                        <th><a href="?sort=progress&order=<?php echo $sort_order == 'asc' ? 'desc' : 'asc'; ?>&<?php echo http_build_query($filters); ?>">Completion %</a></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tasks as $task): ?>
                        <tr>
                            <td><a href="details.php?id=<?php echo ($task['task_id']); ?>"><?php echo ($task['task_id']); ?></a></td>
                            <td><?php echo ($task['task_name']); ?></td>
                            <td><?php echo ($task['project_title']); ?></td>
                            <td class="status-<?php echo str_replace(' ', '-', strtolower($task['status'])); ?>"><?php echo ($task['status']); ?></td>
                            <td class="priority-<?php echo strtolower($task['priority']); ?>"><?php echo ($task['priority']); ?></td>
                            <td><?php echo ($task['start_date']); ?></td>
                            <td><?php echo ($task['end_date']); ?></td>
                            <td><?php echo ($task['progress']); ?></td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif;
        if (empty($tasks)) {
            echo "<p>There is no Tasks</p>";
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