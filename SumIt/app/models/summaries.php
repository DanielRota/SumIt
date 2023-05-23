<?php

if (!isset($_SESSION)) {
    session_start();
}

include("../models/connection.php");

$collectionid = $title = $orderby = $response = "";

if (isset($_GET["title"])) {
    $title = $_GET["title"];
}

if (isset($_GET["orderby"])) {
    if ($_GET["orderby"] == "id") {
        $orderby = "pkSummary";
    } else {
        $orderby = $_GET["orderby"];
    }
} else {
    $orderby = "pkSummary";
}

if (isset($_GET["collectionid"])) {
    $collectionid = $_GET["collectionid"];
}

if (isset($_SESSION["username"])) {

    if ($orderby == "pkSummary") {
        $sql = "SELECT * FROM Summaries WHERE Summaries.fkCollection = :collectionid ORDER BY :orderby DESC";
    } else {
        $sql = "SELECT * FROM Summaries WHERE Summaries.fkCollection = :collectionid AND Summaries.Title LIKE :orderby";
    }

    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":collectionid", $param_collectionid);
        $stmt->bindParam(":orderby", $param_orderby);

        $param_collectionid = $collectionid;

        if ($orderby == "pkSummary") {
            $param_orderby = $orderby;
        } else {
            $param_orderby = $orderby . "%";
        }

        if ($stmt->execute()) {

            $row_count = $stmt->rowCount();

            if ($row_count > 0) {

                $i = 0;
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $summary_id = $row["pkSummary"];
                    $title = $row["Title"];
                    $description = $row["Description"];

                    if ($i % 3 == 0) {
                        $response .= '<div class="uk-child-width-1-3@m uk-grid-small uk-grid-match" uk-grid>';
                    }

                    $response .= '<div class="uk-transition-toggle" tabindex="0">
                    <div class="uk-transition-scale-up uk-transition-opaque">
                      <div class="uk-card uk-card-default uk-margin-small-right">
                        <div class="uk-card-body uk-position-relative" onclick="redirectToManageSummaryDataPage(this);">
                          <h3 class="uk-card-title">' . '#' . $summary_id . '   ' . $title . '</h3>
                          <p class="uk-text-default">' . $description . '</p>   
                          <input type="hidden" name="hidden" value="' . $summary_id . '">
                        </div>
                      </div>
                    </div></div>';

                    $i++;
                    if ($i % 3 == 0) {
                        $response .= '</div>';
                    }
                }
            }
        } else {
            header("location: ../views/error_page.php");
        }
    }
}

echo json_encode($response);
