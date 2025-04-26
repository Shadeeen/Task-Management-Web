<?php session_start();
include("db.php.inc.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Project Management</title>
    <?php include('managerMenu.html'); ?>
    <main id="main-content">
        <div class="container">
            <h2>Project Details</h2>
            <table>
                <tr>
                    <th>Project ID</th>
                    <th>Project Title</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Action</th>
                </tr>
                <?php

                $query = "SELECT * FROM projects WHERE leaderId IS NULL order by start_date";
                $statement = $pdo->prepare($query);
                $statement->execute();
                $projects = $statement->fetchAll();
                foreach ($projects as $project) : ?>
                    <tr>
                        <td><?php echo ($project['project_id']); ?></td>
                        <td><?php echo ($project['project_title']); ?></td>
                        <td><?php echo ($project['start_date']); ?></td>
                        <td><?php echo ($project['end_date']); ?></td>
                        <td><a href="allcolateLeader.php?id=<?php echo ($project['project_id']); ?>">Allocate Team Leader</a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </main>
    <footer>
        <p>Contact us on <a href="tel:+97224568466">+972 2 456 8466</a> | <a href="mailto:TAP.company@gmail.com">TAP.company@gmail.com</a></p>
        <p>©2024 Shadeen Hassan Hamda - ID 1220169 | <a href="aboutUs.php">About Us</a></p>
    </footer>
    </body>

</html>