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

    $input_title = $_POST["title"];
    if (empty($input_title)) {
        $insert_err = "Please enter a title.";
    } elseif (strlen($input_title) < 3) {
        $title_err = "Please enter a valid title.";
    } else {
        $title = $input_title;
    }

    $input_description = $_POST["description"];
    if (empty($input_description)) {
        $insert_err = "Fill in all the required fields please.";
    } else {
        $description = $input_description;
    }

    $input_type = $_POST["type"];
    if (empty($input_type)) {
        $insert_err = "Fill in all the required fields please.";
    } else {
        $type = $input_type;
    }

    if ($type == "script") {
        $input_script = $_POST["script"];
        if (empty($input_script)) {
            $insert_err = "Fill in all the required fields please.";
        } else {
            $script = $input_script;
        }
    }

    if ($type == "video") {
        $input_url = $_POST["url"];
        if (empty($input_url)) {
            $insert_err = "Fill in all the required fields please.";
        } else {
            $url = $input_url;
        }
    }

    if ($type == "url") {
        $input_url = $_POST["url"];
        if (empty($input_url)) {
            $insert_err = "Fill in all the required fields please.";
        } else {
            $url = $input_url;
        }
    }

    if (empty($insert_err) && empty($title_err)) {

        $api = new ExposeTextApi();

        $sql = "INSERT INTO summaries (Title, Description, Script, Link, fkCollection) VALUES (:title, :description, :script, :link, :collectionid)";

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
                        $precision = 50;

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
