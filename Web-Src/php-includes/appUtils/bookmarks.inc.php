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

switch ($_GET["action"]) {
    case "add":
        $studentID = $_SESSION["userid"];
        $targetID = $_GET["id"];
        addBookmark($sql_client, $studentID, $targetID);
    
    default:
        break;
}
