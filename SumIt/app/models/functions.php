<?php

function checkIfUserIsLoggedIn()
{
    if (!isset($_SESSION["id"])) {
        exit(header("location: ../views/login_page.php"));
    }
}
