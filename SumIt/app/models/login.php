<?php

if (!isset($_SESSION)) {
    session_start();
}

include("connection.php");

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: ../views/home_page.php");
    exit;
}

require_once "../models/connection.php";

$username = $password = "";
$username_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter your username.";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($username_err) && empty($password_err)) {

        $sql = "SELECT * FROM users WHERE Username = :username";

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

            $param_username = trim($_POST["username"]);

            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $id = $row["pkUser"];
                        $username = $row["Username"];
                        $hashed_password = $row["Password"];
                        $email = $row["Email"];
                        $date = $row["CreationDate"];
                        $aboutme = $row["Description"];
                        $imagepath = $row["ImagePath"];

                        if (password_verify($password, $hashed_password)) {
                            session_start();

                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["email"] = $email;
                            $_SESSION["date"] = $date;
                            $_SESSION["aboutme"] = $aboutme;
                            $_SESSION["imagepath"] = $imagepath;

                            header("location: ../views/home_page.php");
                        } else {
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else {
                    $login_err = "Invalid username or password.";
                }
            }

            unset($stmt);
        }
    }

    unset($pdo);
}
