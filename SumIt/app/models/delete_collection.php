<?php

if (!isset($_SESSION)) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["collectionid"])) {

        $sql = "DELETE FROM collections WHERE pkCollection = :id";

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":id", $_POST["collectionid"]);

            if ($stmt->execute()) {
                exit(header("location: ../views/home_page.php"));
            }
        }
    }
}
