<?php

require "/opt/lampp/htdocs/php-includes/database.inc.php";

function addBookmark($conn, $studentID, $targetID) {
    $result = $conn->query("SELECT bookmark_index FROM Bookmarks DESC LIMIT 1;");
    $bookmark_index = int($result[0]["bookmark_index"]) + 1;
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
