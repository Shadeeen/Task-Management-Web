<?php
include("db.php.inc.php");

$projectId = $_GET['id'] ?? '';

try {
    $query = "SELECT doc1_path, doc1_title, doc2_path, doc2_title, doc3_path, doc3_title FROM projects WHERE project_id = :projectId";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':projectId', $projectId);
    $stmt->execute();
    $project = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    exit;
}
?>

<h2>Project Documents</h2>
<ul>
    <?php
    if (!$project['doc1_path'] && !$project['doc2_path'] && !$project['doc3_path']) {
        echo "<label>there is no documents attached</label>";
    }
    for ($i = 1; $i <= 3; $i++) {
        $docPath = $project["doc{$i}_path"];
        $docTitle = $project["doc{$i}_title"];
        if (!empty($docPath) && !empty($docTitle)) {
            $extension = strtolower(pathinfo($docPath, PATHINFO_EXTENSION));
            $iconPath = 'image/pdf.png';
            switch ($extension) {
                case 'pdf':
                    $iconPath = 'image/pdf.png';
                    break;
                case 'doc':
                case 'docx':
                    $iconPath = 'image/docx.png';
                    break;
                case 'jpg':
                    $iconPath = 'image/jpg.png';
                    break;
                case 'png':
                    $iconPath = 'image/png.png';
                    break;
            }
            echo "<li><img src='" . ($iconPath) . "' alt='Document Icon' style='width: 20px; height: 20px;'> <a href='" . ($docPath) . "'>" . ($docTitle) . "</a></li>";
        }
    }
    ?>
</ul>