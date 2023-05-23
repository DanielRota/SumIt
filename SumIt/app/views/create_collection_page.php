<?php

include("../models/create_collection.php");

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Create Collection</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.7.4/css/uikit.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.7.4/js/uikit.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.7.4/js/uikit-icons.min.js"></script>
</head>

<body>
    <nav class="uk-navbar-container uk-navbar uk-background-primary uk-animation-fade" uk-navbar>
        <div class="uk-navbar-right uk-margin-medium-right">
            <ul class="uk-navbar-nav">
                <li><a href="home_page.php">Home</a></li>
                <li><a href="user_profile_page.php">Profile</a></li>
                <li><a href="../models/logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>
    <div class="uk-section uk-flex uk-animation-fade" uk-height-viewport>
        <div class="uk-width-1-1">
            <div class="uk-container">
                <div class="uk-grid-margin uk-grid uk-grid-stack" uk-grid>
                    <div class="uk-width-1-1@m">
                        <div class="uk-margin uk-width-large uk-margin-auto uk-card uk-card-default uk-card-body uk-box-shadow-large">
                            <h2 class="uk-card-title uk-text-center">Create Collection</h2>
                            <?php if (!empty($register_err)) {
                                echo '<div class="uk-alert uk-alert-danger">Fill in all the required fields please.</div>';
                            }
                            if (!empty($title_err)) {
                                echo '<div class="uk-alert uk-alert-danger">' . $title_err . '</div>';
                            }
                            if (!empty($description_err)) {
                                echo '<div class="uk-alert uk-alert-danger">' . $description_err . '</div>';
                            }
                            if (!empty($category_err)) {
                                echo '<div class="uk-alert uk-alert-danger">' . $category_err . '</div>';
                            }
                            ?>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                <div class="uk-margin">
                                    <div class="uk-inline uk-width-1-1">
                                        <span class="uk-form-icon" uk-icon="icon: pencil"></span>
                                        <input type="text" name="title" class="uk-input uk-form-large uk-text-default" placeholder="Title" required>
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <div class="uk-inline uk-width-1-1">
                                        <span class="uk-form-icon" uk-icon="icon: pencil"></span>
                                        <input type="text" name="description" class="uk-input uk-form-large uk-text-default" placeholder="Description" required>
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <div class="uk-inline uk-width-1-1">
                                        <select class="uk-select uk-form-large uk-text-default" name="category" id="category-select" required>
                                            <?php $sql = "SELECT * FROM categories";
                                            if ($stmt = $pdo->prepare($sql)) {
                                                if ($stmt->execute()) {
                                                    $row_count = $stmt->rowCount();
                                                    if ($stmt->rowCount() > 0) {

                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                            $category_id = $row["pkCategory"];
                                                            $category_name = $row["Name"];
                                                            $category_description = $row["Description"]; ?>
                                                            <option class="uk-text-default" title="<?php echo $category_description ?>" value="<?php echo $category_id ?>"><?php echo $category_name ?></option>
                                            <?php
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <input type="submit" class="uk-button uk-button-primary uk-button-large uk-width-1-1" value="Confirm">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    UIkit.util.on('#category-select', 'show', function() {
        UIkit.tooltip('.uk-select option');
    });
</script>

</html>