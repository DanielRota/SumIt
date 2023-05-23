<?php

if (!isset($_SESSION)) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["action"] == "Delete") {
        if (isset($_POST["summaryid"])) {
            include("connection.php");

            $sql = "DELETE FROM Summaries WHERE pkSummary = :id";

            if ($stmt = $pdo->prepare($sql)) {
                $stmt->bindParam(":id", $_POST["summaryid"]);

                if ($stmt->execute()) {
                    exit(header("location: ../views/home_page.php"));
                }
            }
        }
    }
}
