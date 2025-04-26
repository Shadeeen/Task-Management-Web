<?php
include("db.php.inc.php");
session_start();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    if ($startDate > $endDate) {
        $_SESSION['dateError'] = "*The Start Date must be before the End Date.";
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    $projectID = $_POST['projectID'];
    $projectTitle = $_POST['projectTitle'];
    $projectDescription = $_POST['projectDescription'];
    $CustomerName = $_POST['CustomerName'];
    $totalBudget = $_POST['totalBudget'];

    $chSql = "SELECT 1 FROM projects WHERE project_id = ?";
    $chStmt = $pdo->prepare($chSql);
    $chStmt->bindValue(1, $projectID);
    $chStmt->execute();
    if ($chStmt->fetch()) {
        $_SESSION['PIDerror'] = "A project with ID '$projectID' already exists.";
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    $checkTitleSql = "SELECT 1 FROM projects WHERE project_title = ?";
    $checkTitleStmt = $pdo->prepare($checkTitleSql);
    $checkTitleStmt->bindValue(1, $projectTitle);
    $checkTitleStmt->execute();
    if ($checkTitleStmt->fetch()) {
        $_SESSION['titleError'] = "A project with the title '$projectTitle' already exists.";
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    $documents = [];
    for ($i = 1; $i <= 3; $i++) {
        if (isset($_FILES["doc$i"]) && $_FILES["doc$i"]['error'] == UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES["doc$i"]['tmp_name'];
            $fileName = $_FILES["doc$i"]['name'];
            $fileSize = $_FILES["doc$i"]['size'];
            $fileType = $_FILES["doc$i"]['type'];
            $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf', 'application/docx'];

            if (!in_array($fileType, $allowedTypes)) {
                $_SESSION["error$i"] = "Invalid file type. Only PDF, PNG, and JPG files are allowed.";
                continue;
            }
            $newFileName = md5(time() . $fileName) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
            $uploadFileDir = './uploaded_files/';
            $dest_path = $uploadFileDir . $newFileName;

            if ($fileSize > 2097152) {
                $_SESSION["error$i"] = "File too large. File must be less than 2MB.";
            } else {
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $documents[$i] = $dest_path;
                    $documentTitles[$i] =  $_POST['title'][$i] ?? 'Untitled';
                } else {
                    $_SESSION["error$i"] = "Error moving the file.";
                }
            }
        }
    }

    if (empty($_SESSION["error1"]) && empty($_SESSION["error2"]) && empty($_SESSION["error3"])) {
        $sql = "INSERT INTO projects (project_id, project_title, project_description, customer_name, total_budget, start_date, end_date, doc1_path,doc2_path, doc3_path,doc1_title,doc2_title,doc3_title) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(1, $projectID);
        $stmt->bindValue(2, $projectTitle);
        $stmt->bindValue(3, $projectDescription);
        $stmt->bindValue(4, $CustomerName);
        $stmt->bindValue(5, $totalBudget, PDO::PARAM_INT);
        $stmt->bindValue(6, $startDate);
        $stmt->bindValue(7, $endDate);
        $stmt->bindValue(8, $documents[1] ?? null);
        $stmt->bindValue(9, $documents[2] ?? null);
        $stmt->bindValue(10, $documents[3] ?? null);
        $stmt->bindValue(11, $documentTitles[1] ?? null);
        $stmt->bindValue(12, $documentTitles[2] ?? null);
        $stmt->bindValue(13, $documentTitles[3] ?? null);

        $executeSuccess = $stmt->execute();
        if ($executeSuccess) {
            $_SESSION['project_id'] = $_POST['projectID'];
            header('Location:conifarmProj.php');
            exit();
        } else {
            $_SESSION['errorData'] = 'Failed to add the project. Please try again.';
            exit();
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<?php include('managerMenu.html'); ?>
<main>
    <h3>Add Project:</h3>
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="projectID">Project ID:</label>
            <input type="text" id="projectID" name="projectID" required pattern="[A-Z]{4}-\d{5}" title="Project ID must be in the format of 'XXXX-12345'" placeholder="Project ID (XXXX-12345)">
            <span class="error"><?php echo isset($_SESSION['PIDerror']) ? $_SESSION['PIDerror'] : ''; ?></span>
        </div>

        <div class="form-group">
            <label for="projectTitle">Project Title:</label>
            <input type="text" id="projectTitle" name="projectTitle" maxlength="12" minlength="3" required placeholder="Project Title">
            <span class="error"><?php echo isset($_SESSION['titleError']) ? $_SESSION['titleError'] : ''; ?></span>

        </div>

        <div class="form-group">
            <label for="projectDescription">Project Description:</label>
            <textarea id="projectDescription" name="projectDescription" required placeholder="Project Description"></textarea>
        </div>

        <div class="form-group">
            <label for="CustomerName">Customer Name:</label>
            <input type="text" id="CustomerName" name="CustomerName" required placeholder="Customer Name">
        </div>

        <div class="form-group">
            <label for="totalBudget">Total Budget:</label>
            <input type="number" id="totalBudget" name="totalBudget" required placeholder="Total Budget" min="1">
        </div>

        <div class="form-group">
            <label for="startDate">Start Date:</label>
            <input type="date" id="startDate" name="startDate" required>
            <span class="error"><?php echo isset($_SESSION['dateError']) ? $_SESSION['dateError'] : ''; ?></span>
        </div>

        <div class="form-group">
            <label for="endDate">End Date:</label>
            <input type="date" id="endDate" name="endDate" required>
        </div>

        <div class="form-group">
            <label id="document1">Supporting Document 1:</label>
            <input type="file" id="document1" name="doc1" accept=".pdf,.docx,PNG,JPG" maxlength="2097152">
            <input type="text" name="title[1]" id="title1" placeholder="Title for Document Optional">
            <span class="error"><?php echo isset($_SESSION['error1']) ? $_SESSION['error1'] : ''; ?></span>
        </div>

        <div class="form-group">
            <label id="document2">Supporting Document 2:</label>
            <input type="file" id="document2" name="doc2" accept=".pdf,.docx,PNG,JPG">
            <input type="text" name="title[2]" id="title2" placeholder="Title for Document Optional">
            <span class="error"><?php echo isset($_SESSION['error2']) ? $_SESSION['error2'] : ''; ?></span>
        </div>

        <div class="form-group">
            <label id="document3">Supporting Document 3:</label>
            <input type="file" id="document3" name="doc3" accept=".pdf,.docx,PNG,JPG">
            <input type="text" name="title[3]" id="title3" placeholder="Title for Document Optional">
            <span class="error"><?php echo isset($_SESSION['error3']) ? $_SESSION['error3'] : ''; ?></span>
        </div>

        <div class="form-group">
            <input type="submit" value="Add Project" class="submit-button">
            <span class="error"><?php echo isset($_SESSION['errorData']) ? $_SESSION['errorData'] : ''; ?></span>
        </div>
    </form>
    </div>
</main>
<?php
unset($_SESSION['dateError']);
unset($_SESSION['error1']);
unset($_SESSION['error2']);
unset($_SESSION['error3']);
unset($_SESSION['PIDerror']);
unset($_SESSION['errorData']);
unset($_SESSION['titleError']);
?>
<footer>
    <p>Contact us on <a href="tel:+97224568466">+972 2 456 8466</a> | <a href="mailto:TAP.company@gmail.com">TAP.company@gmail.com</a></p>
    <p>©2024 Shadeen Hassan Hamda - ID 1220169 | <a href="aboutUs.php">About Us</a></p>
</footer>
</body>

</html>