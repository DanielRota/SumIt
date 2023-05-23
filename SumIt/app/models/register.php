<?php

if (!isset($_SESSION)) {
    session_start();
}

include("connection.php");

$username = $email = $password = $confirm_password = "";
$username_err = $email_err = $password_err = $confirm_password_err = $register_err = "";
$pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["username"]))) {
        $register_err = "Please enter a username.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]{4,}$/', trim($_POST["username"]))) {
        $username_err = "Username must be at least 4 characters long and can only contain letters and numbers.";
    } else {

        $sql = "SELECT pkUser FROM Users WHERE Username = :username";

        if ($stmt = $pdo->prepare($sql)) {
            $param_username = trim($_POST["username"]);
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            }

            unset($stmt);
        }
    }

    if (empty(trim($_POST["email"]))) {
        $register_err = "Please enter an email.";
    } elseif (!preg_match($pattern, $_POST["email"])) {
        $email_err = "Email address is not valid.";
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty(trim($_POST["password"]))) {
        $register_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty(trim($_POST["confirm_password"]))) {
        $register_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
            header("location: ../views/register_page.php");
        }
    }

    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($register_err)) {

        $sql = "INSERT INTO Users (Username, Password, Email) VALUES (:username, :password, :email)";

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_email = $email;

            if ($stmt->execute()) {
                header("location: ../views/login_page.php");
            }

            unset($stmt);
        }
    }

    unset($pdo);
}
