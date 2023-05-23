<?php

include("../models/create_summary.php");

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Create Data</title>
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
                    <div class="uk-margin uk-width-xlarge uk-margin-auto uk-card uk-card-default uk-card-body uk-box-shadow-large">
                        <h2 class="uk-card-title uk-text-center">Create Summary</h2>
                        <?php if (!empty($insert_err)) {
                            echo '<div class="uk-alert uk-alert-danger uk-text-center">' . $insert_err . '</div>';
                        }
                        if (!empty($title_err)) {
                            echo '<div class="uk-alert uk-alert-danger uk-text-center">' . $title_err . '</div>';
                        }
                        if (!empty($url_err)) {
                            echo '<div class="uk-alert uk-alert-danger uk-text-center">' . $url_err . '</div>';
                        }
                        ?>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data" id="form">
                            <div class="uk-flex uk-margin">
                                <div class="uk-inline uk-width-1-1 uk-margin-small-right">
                                    <span class="uk-form-icon" uk-icon="icon: pencil"></span>
                                    <input type="text" name="title" class="uk-input uk-form-large uk-text-default" placeholder="Title" required>
                                </div>
                                <div class="uk-inline uk-width-1-1">
                                    <span class="uk-form-icon" uk-icon="icon: pencil"></span>
                                    <input type="text" name="description" class="uk-input uk-form-large uk-text-default" placeholder="Description" required>
                                </div>
                            </div>
                            <div class="uk-flex uk-margin">
                                <div class="uk-inline uk-width-1-1 uk-margin-small-right">
                                    <select name="type" class="uk-select uk-form-large uk-text-default" required>
                                        <option value="video">YouTube Video</option>
                                        <option value="script">Plain Text</option>
                                        <option value="url">Url/Link</option>
                                    </select>
                                </div>
                                <div class="js-upload uk-width-1-1" uk-form-custom>
                                    <span class="uk-form-icon" uk-icon="icon: code"></span>
                                    <input type="number" name="precision" id="percentage" class="uk-input uk-form-large uk-text-default" placeholder="URLs Precision" min="10" max="100">
                                </div>
                            </div>
                            <div class="uk-inline uk-width-1-1">
                                <span class="uk-form-icon" uk-icon="icon: link"></span>
                                <input type="text" name="url" class="uk-input uk-form-large uk-text-default" placeholder="Url">
                            </div>
                            <div class="uk-margin">
                                <div class="uk-inline uk-width-1-1">
                                    <textarea name="script" class="uk-textarea uk-text-default uk-form-large" style="resize: none;" rows="5" placeholder="Script"></textarea>
                                </div>
                            </div>
                            <div class="uk-text-center uk-margin">
                                <input type="submit" class="uk-button uk-button-primary uk-button-large uk-width-1-2" value="Confirm" id="action">
                                <input type="hidden" name="collectionid" value="<?php echo (!empty($_GET["collectionid"])) ? $_GET["collectionid"] : ''; ?>">
                            </div>
                        </form>
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