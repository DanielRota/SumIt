<?php

if (!isset($_SESSION)) {
    session_start();
}

include("../models/connection.php");

$orderby = $response = "";

if (isset($_GET["orderby"])) {
    if ($_GET["orderby"] == "id") {
        $orderby = "pkCollection";
    } else {
        $orderby = $_GET["orderby"];
    }
} else {
    $orderby = "pkCollection";
}

if (isset($_SESSION["username"])) {

    if ($orderby == "pkCollection") {
        $sql = "SELECT * FROM Collections WHERE fkUser = :id ORDER BY :orderby DESC";
    } else {
        $sql = "SELECT * FROM Collections WHERE fkUser = :id AND Title LIKE :orderby";
    }

    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":id", $param_id);
        $stmt->bindParam(":orderby", $param_orderby);

        $param_id = $_SESSION["id"];

        if ($orderby == "pkCollection") {
            $param_orderby = $orderby;
        } else {
            $param_orderby = $orderby . "%";
        }

        if ($stmt->execute()) {

            $row_count = $stmt->rowCount();

            if ($row_count > 0) {

                $i = 0;
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $collection_id = $row["pkCollection"];
                    $title = $row["Title"];
                    $description = $row["Description"];

                    if ($i % 3 == 0) {
                        $response .= '<div class="uk-child-width-1-3@m uk-grid-small uk-grid-match" uk-grid>';
                    }

                    $response .= '<div class="uk-transition-toggle" tabindex="0">
                        <div class="uk-transition-scale-up uk-transition-opaque">
                            <div class="uk-card uk-card-default uk-margin-small-right" onclick="redirectToCollectionSummariesPage(this);">
                                <div class="uk-card-body">
                                    <h3 class="uk-card-title">' .  '#' . $collection_id . '   ' . $title . '</h3>
                                    <p class="uk-text-default">' . $description . '</p>   
                                    <input type="hidden" name="hidden" value="' . $collection_id . '">
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
