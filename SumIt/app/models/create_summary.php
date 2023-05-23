<?php

if (!isset($_SESSION)) {
    session_start();
}

include("api.php");
include("connection.php");

$collectionid = $title = $description = $url = "";
$insert_err = $title_err = $url_err = "";

if (isset($_POST["collectionid"])) {
    $collectionid = $_POST["collectionid"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $input_title = trim($_POST["title"]);
    if (empty($input_title)) {
        $insert_err = "Please enter a title.";
    } elseif (strlen($input_title) < 3) {
        $title_err = "Please enter a valid title.";
    } else {
        $title = $input_title;
    }

    $input_description = trim($_POST["description"]);
    if (empty($input_description)) {
        $insert_err = "Fill in all the required fields please.";
    } else {
        $description = $input_description;
    }

    $input_type = trim($_POST["type"]);
    if (empty($input_type)) {
        $insert_err = "Fill in all the required fields please.";
    } else {
        $type = $input_type;
    }

    if ($type == "script") {
        $input_script = trim($_POST["script"]);
        if (empty($input_script)) {
            $insert_err = "Fill in all the required fields please.";
        } else {
            $script = $input_script;
        }
    }

    if ($type == "video" || $type = "url") {
        $input_url = trim($_POST["url"]);
        if (empty($input_url)) {
            $insert_err = "Fill in all the required fields please.";
        } else {
            $url = $input_url;
        }
    }

    if ($type == "script" && !empty(trim($_POST["url"]))) {
        $insert_err = "Url option is only available for Youtube Videos and Urls.";
    }

    if (($type == "video" || $type == "url") && !empty(trim($_POST["script"]))) {
        $insert_err = "Script field is only available for Plain Text type.";
    }

    if ($type == "url" && empty($_POST["precision"])) {
        $insert_err = "Precision value must be set for Url/Link option.";
    }

    if (empty($insert_err) && empty($title_err)) {

        $api = new ExposeTextApi();

        $sql = "INSERT INTO Summaries (Title, Description, Script, Link, fkCollection) VALUES (:title, :description, :script, :link, :collectionid)";

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":title", $param_title);
            $stmt->bindParam(":description", $param_description);
            $stmt->bindParam(":script", $param_script);
            $stmt->bindParam(":link", $param_link);
            $stmt->bindParam(":collectionid", $param_collectionid);

            switch ($type) {
                case "script": {
                        $script = $api->fetchTextSummary($script);
                        $link = "";
                        break;
                    }
                case "video": {
                        $subtitles = $api->fetchVideoSubtitles($url);
                        $script = $api->fetchTextSummary($subtitles);
                        $link = $url;
                        break;
                    }
                case "url": {
                        $precision = 0;

                        if (isset($_POST["precision"])) {
                            $precision = $_POST["precision"];
                        }

                        $script = $api->fetchUrlSummary($url, $precision);
                        $link = $url;
                        break;
                    }
            }

            $param_title = $title;
            $param_description = $description;
            $param_script = $script;
            $param_link = $link;
            $param_collectionid = $collectionid;

            if ($stmt->execute()) {
                exit(header("location: ../views/home_page.php"));
            }
        }
    }
}
