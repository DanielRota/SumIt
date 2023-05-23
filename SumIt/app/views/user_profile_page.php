<?php

include("../models/connection.php");

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST["aboutme"])) {
    $aboutme = $_POST["aboutme"];

    $sql = "UPDATE Users SET Description = :aboutme WHERE pkUser = :id";

    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":id", $_SESSION["id"]);
        $stmt->bindParam(":aboutme", $aboutme);

        $_SESSION["aboutme"] = $aboutme;

        $stmt->execute();
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.7.4/css/uikit.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.7.4/js/uikit.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.7.4/js/uikit-icons.min.js"></script>
</head>

<body>
    <div class="uk-animation-fade" uk-height-viewport>
        <nav class="uk-navbar-container uk-navbar uk-background-primary" uk-navbar>
            <div class="uk-navbar-right uk-margin-medium-right">
                <ul class="uk-navbar-nav">
                    <li><a href="home_page.php">Home</a></li>
                    <li><a href="user_profile_page.php">Profile</a></li>
                    <li><a href="../models/logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>
        <div class="uk-container uk-margin-medium-top">
            <h1 class="uk-heading-line uk-text-center uk-margin-medium-bottom"><span>User Profile</span></h1>
            <div class="uk-grid-divider uk-flex-center" uk-grid>
                <div class="uk-width-1-3">
                    <div class="uk-card uk-card-default uk-card-body">
                        <h3 class="uk-card-title uk-text-large"><?php echo $_SESSION["username"] ?></h3>
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <p class="uk-text-default">Email: <?php echo $_SESSION["email"] ?></p>
                            <p class="uk-text-default">Since: <?php echo $_SESSION["date"] ?></p>
                    </div>
                </div>
                <div class="uk-width-3-5">
                    <div class="uk-card uk-card-default uk-card-body">
                        <h3>About Me</h3>
                        <textarea class="uk-textarea uk-text-default uk-form-large" name="aboutme" style="resize: none;" rows="8" cols="50"> <?php echo $_SESSION["aboutme"] ?></textarea>
                        <input type="submit" class="uk-button uk-button-default uk-margin-small-top" value="Edit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>