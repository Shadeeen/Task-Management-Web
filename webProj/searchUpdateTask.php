<?php
include("db.php.inc.php");
session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Search Tasks</title>
    <?php include('memberMenu.html'); ?>

</head>

<body>
    <main>
        <div class="container">
            <h2>Search Tasks</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <label for="taskId">Task ID:</label>
                <input type="text" id="taskId" name="taskId" placeholder="Enter Task ID">

                <label for="taskName">Task Name:</label>
                <input type="text" id="taskName" name="taskName" placeholder="Enter Task Name">

                <label for="projectName">Project Name:</label>
                <input type="text" id="projectName" name="projectName" placeholder="Enter Project Name">

                <button type="submit" name="search">Search</button>
                <button type="submit" name="all">Show All</button>

            </form>

            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
                $taskId = $_POST['taskId'];
                $taskName = $_POST['taskName'];
                $projectName = $_POST['projectName'];
            }

            $memberId = $_SESSION['id'];
            $query = "SELECT t.*, p.project_title ,ut.percentage
            FROM tasks t 
            JOIN user_tasks ut ON t.task_id = ut.task_id
            JOIN projects p ON t.project_id = p.project_id
            WHERE ut.user_id = :memberId";

            if (!empty($taskId)) {
                $query .= " AND t.task_id = :taskId";
            }
            if (!empty($taskName)) {
                $query .= " AND t.task_name LIKE :taskName";
            }
            if (!empty($projectName)) {
                $query .= " AND p.project_title LIKE :projectName";
            }

            $stmt = $pdo->prepare($query);

            if (!empty($taskId)) {
                $stmt->bindValue(':taskId', $taskId);
            }
            if (!empty($taskName)) {
                $stmt->bindValue(':taskName', '%' . $taskName . '%');
            }
            if (!empty($projectName)) {
                $stmt->bindValue(':projectName', '%' . $projectName . '%');
            }

            $stmt->bindValue(':memberId', $memberId);
            $stmt->execute();
            $tasks = $stmt->fetchAll();
            ?>
            <?php

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['all'])) {
                $memberId = $_SESSION['id'];
                $query = "SELECT t.*, p.project_title ,ut.percentage
                FROM tasks t 
                JOIN user_tasks ut ON t.task_id = ut.task_id
                JOIN projects p ON t.project_id = p.project_id
                WHERE ut.user_id = :memberId";

                $stmt = $pdo->prepare($query);
                $stmt->bindValue(':memberId', $memberId);
                $stmt->execute();
                $tasks = $stmt->fetchAll();
            }
            ?>
            <?php if (!empty($tasks)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Task ID</th>
                            <th>Task Name</th>
                            <th>Project Name</th>
                            <th>Current Progress</th>
                            <th>Current Status</th>
                            <th>Update</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tasks as $task): ?>
                            <tr>
                                <td><?php echo ($task['task_id']); ?></td>
                                <td><?php echo ($task['task_name']); ?></td>
                                <td><?php echo ($task['project_title']); ?></td>
                                <td><?php echo ($task['progress']); ?></td>
                                <td><?php echo ($task['status']); ?></td>
                                <td><a href="update.php?id=<?php echo ($task['task_id']); ?>&tname=<?php echo ($task['task_name']); ?>&pname=<?php echo ($task['project_title']); ?>&progress=<?php echo ($task['progress']); ?>&perc=<?php echo ($task['percentage']); ?>">Update</a></td>

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