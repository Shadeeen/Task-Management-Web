<?php
session_start();
include("db.php.inc.php");
$taskId = $_GET['id'];

$query = "SELECT
                   t.* ,
                    p.project_title
                FROM
                    tasks t
                JOIN
                    projects p ON t.project_id = p.project_id
                WHERE
                    t.task_id = :taskId";

$stmt = $pdo->prepare($query);
$stmt->bindValue(':taskId', $taskId, PDO::PARAM_INT);
$stmt->execute();
$taskDetails = $stmt->fetch(PDO::FETCH_ASSOC);



$taskMembersQuery = "SELECT 
                        u.id, 
                        u.name,
                        u.photo ,
                        ut.start_date, 
                        t.end_date, 
                        ut.percentage,
                        t.status   
                    FROM 
                        users u
                    JOIN 
                        user_tasks ut ON ut.user_id = u.id
                    JOIN 
                        tasks t ON t.task_id = ut.task_id
                    WHERE 
                        ut.task_id = :taskId";

$taskMembersStmt = $pdo->prepare($taskMembersQuery);
$taskMembersStmt->bindValue(':taskId', $taskId, PDO::PARAM_INT);
$taskMembersStmt->execute();
$members = $taskMembersStmt->fetchAll(PDO::FETCH_ASSOC);

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

<body>
    <main>
        <div class="task-page-container">
            <div class="task-details">
                <h1>Task Details</h1>
                <p><strong>Task ID:</strong> <?php echo ($taskDetails['task_id']) ?></p>
                <p><strong>Task Name:</strong> <?php echo ($taskDetails['task_name']) ?></p>
                <p><strong>Description:</strong> <?php echo ($taskDetails['description']) ?></p>
                <p><strong>Project:</strong> <?php echo ($taskDetails['project_title']) ?></p>
                <p><strong>Start Date:</strong> <?php echo ($taskDetails['start_date']) ?></p>
                <p><strong>End Date:</strong> <?php echo ($taskDetails['end_date']) ?></p>
                <p><strong>Completion Percentage:</strong> <?php echo ($taskDetails['progress']) ?></p>
                <p><strong>Status:</strong> <?php echo ($taskDetails['status']) ?></p>
                <p><strong>Priority:</strong> <?php echo ($taskDetails['priority']) ?></p>
            </div>

            <div class="team-members">
                <?php if (!empty($members)): ?>
                    <h1>Team Members</h1>
                    <table>
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Member ID</th>
                                <th>Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Effort Allocated (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($members as $member): ?>
                                <tr>
                                    <td><img src="<?php echo ($member['photo']); ?>" alt="<?php echo ($member['name']) . " Photo"; ?>" style="width:50px; height:auto;"></td>
                                    <td><?php echo ($member['id']); ?></td>
                                    <td><?php echo ($member['name']); ?></td>
                                    <td><?php echo ($member['start_date']); ?></td>
                                    <td class="status-<?php echo str_replace(' ', '-', strtolower($member['status'])); ?>"><?php echo ($member['status'] == 'in Progress' ? 'In Progress' : ($member['end_date'])); ?></td>
                                    <td><?php echo ($member['percentage']) . '%'; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No team members found for this task.</p>
                <?php endif; ?>
            </div>

        </div>
    </main>
    <footer>
        <p>Contact us on <a href="tel:+97224568466">+972 2 456 8466</a> | <a href="mailto:TAP.company@gmail.com">TAP.company@gmail.com</a></p>
        <p>©2024 Shadeen Hassan Hamda - ID 1220169 | <a href="aboutUs.php">About Us</a></p>
    </footer>
</body>

</html>