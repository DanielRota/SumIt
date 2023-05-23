<?php

if (!isset($_SESSION)) {
    session_start();
}

include("../models/connection.php");

$title = $description = $script = "";

if (isset($_GET["summaryid"])) {
    $summaryid = $_GET["summaryid"];

    $stmt = $pdo->prepare("SELECT * FROM summaries WHERE pkSummary = :id");
    $stmt->bindParam(":id", $summaryid, PDO::PARAM_INT);
    $stmt->execute();

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $title = $row["Title"];
        $description = $row["Description"];
        $script = $row["Script"];
    }
}

unset($stmt);
unset($pdo);
