<?php

include("../models/read_summary.php");
include("../models/delete_summary.php");
include("../models/update_summary.php");
include("../models/download_summary.php");

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Manage Summary</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.7.4/css/uikit.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.7.4/js/uikit.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.7.4/js/uikit-icons.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="uk-animation-fade" uk-height-viewport>
        <nav class="uk-navbar-container uk-navbar uk-background-primary custom-navbar" uk-navbar>
            <div class="uk-navbar-right uk-margin-medium-right">
                <ul class="uk-navbar-nav">
                    <li><a href="home_page.php">Home</a></li>
                    <li><a href="user_profile_page.php">Profile</a></li>
                    <li><a href="../models/logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>
        <div class="uk-container uk-margin-medium-top">
            <h1 class="uk-heading-line uk-text-center uk-margin-medium-bottom"><span>Manipulate Summary</span></h1>
            <div class="uk-grid-divider uk-flex-center" uk-grid>
                <div class="uk-width-1-4">
                    <div class="uk-card uk-card-default uk-card-body">
                        <h3 id="title" class="uk-card-title uk-text-large"><?php echo (!empty($title)) ? wordwrap($title, 15, "<br>", true) : ""; ?></h3>
                        <p class="uk-text-default"><?php echo (!empty($description)) ? wordwrap($description, 30, "<br>", true) : ""; ?> </p>
                    </div>
                </div>

                <div class="uk-width-3-4">
                    <div class="uk-card uk-card-default uk-card-body">
                        <h3>Script</h3>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <textarea id="scriptarea" class="uk-textarea uk-text-default uk-form-large" name="script" style="resize: none;" cols="50" oninput="autoResizeTextarea()"> <?php echo (!empty($script)) ? $script : ""; ?></textarea>
                            <div class="uk-flex uk-margin">
                                <input type="submit" name="action" class="uk-button uk-button-default uk-margin-small-right uk-width-1-6" value="Update">
                                <input type="submit" name="action" class="uk-button uk-button-danger uk-margin-small-right uk-width-1-6" value="Delete">
                                <input id="download" class="uk-button uk-button-secondary uk-width-1-6" value="TXT">
                                <input type="hidden" name="summaryid" value="<?php echo (!empty($_GET["summaryid"])) ? $_GET["summaryid"] : ''; ?>" </div>
                                <input type="hidden" name="collectionid" value="<?php echo (!empty($_GET["collectionid"])) ? $_GET["collectionid"] : ''; ?>" </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    $(document).ready(function() {
        autoResizeTextarea();
    });

    UIkit.util.on('#category-select', 'show', function() {
        UIkit.tooltip('.uk-select option');
    });

    document.getElementById('download').addEventListener('click', async (e) => createAndDownloadTxtFile());

    function autoResizeTextarea() {
        var textarea = document.getElementById('scriptarea');
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    }

    function createAndDownloadTxtFile() {
        var title = document.getElementById('title').textContent;
        var script = document.getElementById('scriptarea').textContent;
        var fileContent = title + "\n\n" + script;

        var blob = new Blob([fileContent], {
            type: 'text/plain'
        });

        var url = URL.createObjectURL(blob);
        var link = document.createElement('a');
        link.href = url;
        link.download = title + '.txt';
        link.textContent = 'Scarica il file';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(url);
    }
</script>

</html>