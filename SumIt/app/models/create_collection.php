<?php

if (!isset($_SESSION)) {
    session_start();
}

include("connection.php");

$title = $description = $category = "";
$insert_err = $title_err = "";

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
        $insert_err = "Please enter a description.";
    } else {
        $description = $input_description;
    }

    $input_category = trim($_POST["category"]);
    if (empty($input_category)) {
        $insert_err = "Please enter a category.";
    } else {
        $category = $input_category;
    }

    if (empty($title_err) && empty($insert_err)) {

        $sql = "INSERT INTO collections (Title, Description, fkUser, fkCategory) VALUES (:title, :description, :user, :category)";

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":title", $param_title);
            $stmt->bindParam(":description", $param_description);
            $stmt->bindParam(":user", $param_user);
            $stmt->bindParam(":category", $param_category);

            $param_title = $title;
            $param_description = $description;
            $param_user = $_SESSION["id"];
            $param_category = $category;

            if ($stmt->execute()) {
                header("location: ../views/home_page.php");
                return 0;
            }
        }

        unset($stmt);
    }

    unset($pdo);
}
