<?php

include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["action"] == "TXT") {
        if (isset($_POST["summaryid"])) {

            if (isset($_POST["summaryid"])) {
                $summaryid = $_POST["summaryid"];

                $stmt = $pdo->prepare("SELECT * FROM summaries WHERE pkSummary = :id");
                $stmt->bindParam(":id", $summaryid, PDO::PARAM_INT);
                $stmt->execute();

                if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $title = $row["Title"];
                    $description = $row["Description"];
                    $script = $row["Script"];

                    $fileName = $title . ".txt";

                    $fileContent = $title . "\n\n" . $script;

                    header('Content-Type: text/plain');
                    header('Content-Disposition: attachment; filename="' . $fileName . '"');

                    echo $fileContent;
                }
            }
        }
    }
}
