<?php session_start();
include("db.php.inc.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $leaderId = $_POST['leaderId'];
    $projectId = $_GET['id'] ?? '';
    try {
        $query = "UPDATE projects SET leaderId = :leaderId WHERE project_id = :projectId";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':leaderId', $leaderId);
        $statement->bindValue(':projectId', $projectId);
        $statement->execute();

        $_SESSION['currentProID'] = $projectId;
        header('location: confAllocLeader.php');
        exit();
    } catch (PDOException $e) {
        $_SESSION['SQLerror'] = "Error: " . $e->getMessage();
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <title>Allocate Leader</title>
    <?php include('managerMenu.html'); ?>
    <main id="main-content">
        <div class="container">
            <h2>Select Team Leader</h2>
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                <?php
                $projectId = $_GET['id'] ?? '';
                $query = "SELECT * FROM projects WHERE project_id = :projectId";
                $statement = $pdo->prepare($query);
                $statement->bindValue(':projectId', $projectId);
                $statement->execute();
                $project = $statement->fetch();

                if ($project) {
                    echo '<label for="proId">Project ID:</label>';
                    echo "<input type='text' id='proId' name='id' value='" . ($project['project_id']) . "' disabled>";

                    echo '<label for="proTitle">Project Title:</label>';
                    echo "<input type='text' id='proTitle' value='" . ($project['project_title']) . "' disabled>";

                    echo '<label for="proDesc">Project Description:</label>';
                    echo "<textarea id='proDesc' disabled>" . ($project['project_description']) . "</textarea>";

                    echo '<label for="proStartDate">Start Date:</label>';
                    echo "<input type='date' id='proStartDate' value='" . $project['start_date'] . "' disabled>";
                    echo '<label for="proEndDate">End Date:</label>';
                    echo "<input type='date' id='proEndDate' value='" . $project['end_date'] . "' disabled>";

                    echo '<label for="customerName">Customer Name:</label>';
                    echo "<input type='text' id='customerName' value='" . ($project['customer_name']) . "' disabled>";

                    echo '<label for="totalBudget">Total Budget:</label>';
                    echo "<input type='number' id='totalBudget' value='" . $project['total_budget'] . "' disabled>";
                }
                ?>
                <div class="allocationBox">
                    <label for="leaderId">Leaders To Allocate:</label>
                    <select name="leaderId" id="leaderId" required>
                        <option value="" disabled selected style="display:none;">Select an option</option>

                        <?php
                        $sql = "SELECT u.id, u.name
                            FROM users u
                            WHERE u.role = 'Project-Leader'";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        $leaders = $stmt->fetchAll();
                        foreach ($leaders as $leader) {
                            echo '<option value="' . ($leader['id']) . '">' . ($leader['name']) . " " . ($leader['id']) . '</option>';
                        }
                        ?>
                    </select>
                    <input type="submit" value="Allocate">
                    <span class="error-message"><?php echo isset($_SESSION['SQLerror']) ? $_SESSION['SQLerror'] : ''; ?></span>
                </div>
                <div class="docBox">
                    <?php include("SupportingDoc.php") ?>
                </div>
            </form>
        </div>
    </main>
    <?php
    unset($_SESSION['SQLerror']);
    ?>
    <footer>
        <p>Contact us on <a href="tel:+97224568466">+972 2 456 8466</a> | <a href="mailto:TAP.company@gmail.com">TAP.company@gmail.com</a></p>
        <p>©2024 Shadeen Hassan Hamda - ID 1220169 | <a href="aboutUs.php">About Us</a></p>
    </footer>
    </body>

</html>