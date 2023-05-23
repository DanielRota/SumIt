<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Sets</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.7.4/css/uikit.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.7.4/js/uikit.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.7.4/js/uikit-icons.min.js"></script>
</head>

<body>
    <div class="uk-animation-fade uk-background-contain uk-height-medium uk-panel" uk-height-viewport>
        <nav class="uk-navbar-container uk-navbar uk-background-primary custom-navbar" uk-navbar>
            <div class="uk-navbar-right uk-margin-medium-right">
                <ul class="uk-navbar-nav">
                    <li><a href="home_page.php">Home</a></li>
                    <li><a href="user_profile_page.php">Profile</a></li>
                    <li><a href="../models/logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>
        <div class="uk-container uk-margin-small-top uk-container-center">
            <h1 class="uk-heading-line uk-text-center uk-margin-medium-top uk-margin-medium-bottom"><span> <?php echo $_GET["title"] ?> </span></h1>
            <div class="uk-child-width-1-3@m uk-grid-small uk-grid-match uk-margin-medium-bottom uk-flex-center" uk-grid>
                <div class="uk-transition-toggle" tabindex="0">
                    <div class="uk-transition-scale-up uk-transition-opaque">
                        <div id="create" class="uk-card uk-card-primary uk-margin-small-right">
                            <div class="uk-card-body">
                                <h1 class="uk-text-large uk-text-center">Create new.</h1>
                                <input type="text" id="search" class="uk-input uk-margin-small-top uk-text-center" onclick="event.stopPropagation();" placeholder="Search">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="collections">
                <!-- Fetch result -->
            </div>
        </div>
    </div>
</body>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', async (e) => fetchCollectionData());
    document.getElementById('search').addEventListener('input', async (e) => fetchCollectionData());

    document.getElementById('create').addEventListener('click', async (e) => {
        var urlParams = new URLSearchParams(window.location.search);
        var collectionId = urlParams.get('collectionid');
        var destinationUrl = 'create_summary_page.php?collectionid=' + encodeURIComponent(collectionId);
        window.location.href = destinationUrl;
    });

    function fetchCollectionData() {
        var urlParams = new URLSearchParams(window.location.search);
        var collectionId = urlParams.get('collectionid');
        var searchText = document.getElementById('search').value;

        if (searchText.length == 0) {
            searchText = "pkSummary";
        }

        fetch("../models/summaries.php?collectionid=" + encodeURIComponent(collectionId) + "&orderby=" + encodeURIComponent(searchText), {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                }
            })
            .then((response) => response.json())
            .then((data) => {
                var collectionsContainer = document.getElementById('collections');
                collectionsContainer.innerHTML = data;
            })
            .catch((error) => error.response);
    }

    function redirectToManageSummaryDataPage(element) {
        var clickedElement = element;
        var hiddenValue = clickedElement.querySelector('input[name="hidden"]').value;
        var destinationUrl = 'manage_page.php?summaryid=' + encodeURIComponent(hiddenValue);
        window.location.href = destinationUrl;
    }
</script>

</html>