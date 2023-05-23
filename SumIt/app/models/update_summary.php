<?php

if (!isset($_SESSION)) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["action"] == "Update") {
        if (isset($_POST["summaryid"]) && isset($_POST["collectionid"])) {
            include("connection.php");

            $sql = "UPDATE Summaries SET Script = :script WHERE pkSummary = :id";

            if ($stmt = $pdo->prepare($sql)) {
                $stmt->bindParam(":id", $_POST["summaryid"]);
                $stmt->bindParam(":script", $_POST["script"]);

                if ($stmt->execute()) {
                    exit(header("location: ../views/home_page.php?collectionid=" . $_POST["collectionid"]));
                }
            }
        }
    }
}
