<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Homepage</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.7.4/css/uikit.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.7.4/js/uikit.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.7.4/js/uikit-icons.min.js"></script>
    <link rel="stylesheet" href="../../public/js/style.css">
</head>

<body>
    <div class="container">
        <div class="wave">
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
                <div class="uk-container uk-margin-medium-top uk-container-center">
                    <h1 class="uk-heading-line uk-text-center uk-margin-medium-bottom"><span>Collections</span></h1>
                    <div class="uk-child-width-1-3@m uk-grid-small uk-grid-match uk-margin-medium-bottom uk-flex-center" uk-grid>
                        <div class="uk-transition-toggle" tabindex="0">
                            <div class="uk-transition-scale-up uk-transition-opaque">
                                <div class="uk-card uk-card-primary uk-margin-small-right" onclick="window.location=`create_collection_page.php`;">
                                    <div class="uk-card-body">
                                        <h3 class="uk-card-title uk-text-center">Create new.</h3>
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
        </div>
    </div>
</body>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', async (e) => fetchCollectionData());
    document.getElementById('search').addEventListener('input', async (e) => fetchCollectionData());

    function fetchCollectionData() {
        var searchText = document.getElementById('search').value;

        if (searchText.length == 0) {
            searchText = "pkCollection";
        }

        fetch('../models/home.php?orderby=' + encodeURIComponent(searchText), {
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

    function redirectToCollectionSummariesPage(element) {
        var clickedElement = element;
        var collectionId = clickedElement.querySelector('input[name="hidden"]').value;
        var titleElement = clickedElement.querySelector(".uk-card-title");
        var title = titleElement.innerText;
        var destinationUrl = 'summaries_page.php?collectionid=' + encodeURIComponent(collectionId) + '&title=' + encodeURIComponent(title);
        window.location.href = destinationUrl;
    }
</script>

</html>