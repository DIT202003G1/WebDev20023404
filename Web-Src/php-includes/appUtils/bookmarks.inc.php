<?php

session_start();

require "/opt/lampp/htdocs/php-includes/database.inc.php";

function addBookmark($conn, $studentID, $targetID) {
    $result = $conn->query("SELECT bookmark_index FROM Bookmarks ORDER BY bookmark_index DESC LIMIT 1;");
    $row = $result->fetch_assoc();
    $bookmark_index = $row === null ? 0 : intval($row["bookmark_index"]) + 1;
    $result->close();

    $stmt = $conn->prepare("INSERT INTO Bookmarks VALUES (?, ?, ?);");
    $stmt->bind_param("iii", $studentID, $bookmark_index, $targetID);
    $stmt->execute();
    $stmt->close();
}
function removeBookmark($conn, $studentID, $targetID) {
    $stmt = $conn->prepare("DELETE FROM Bookmarks WHERE student_id = ? AND target_id = ?");
    $stmt->bind_param("ii", $studentID, $targetID);
    $stmt->execute();
    $stmt->close();
}

$studentID = $_SESSION["userid"];
$targetID = $_GET["id"];

switch ($_GET["action"]) {
    case "add":
        addBookmark($sql_client, $studentID, $targetID);
        break;

    case "remove":
        removeBookmark($sql_client, $studentID, $targetID);
        break;
    
    default:
        break;
}

$returnURI = isset($_GET["return_uri"]) ? $_GET["return_uri"] : "/application/view/?id=$targetID";
header("Location: " . $returnURI);
