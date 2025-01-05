<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        body {
            margin: 0px;
            padding: 0px;
        }

        .maincontainer {
            display: flex;
        }

        .sidebar {
            border-right: 2px solid antiquewhite;
            width: 300px;
            height: 110vh;
            margin: 0px;
        }

        .heading h2 {
            margin-top: 0px;
            padding-top: 40px;
            text-align: center;
            color: aliceblue;
        }

        .buttons {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
        }

        button a {
            color: aliceblue;
            text-decoration: none;
        }

        .display {
            margin: 10px;
            flex-grow: 1;
            border: 1px solid #ccc;
            padding: 10px;
            height: 100vh;
            overflow-y: auto;
        }
    </style>
</head>

<body>
    <div class="maincontainer">
        <div class="sidebar">
            <div class="heading">
                <h2>Admin Panel</h2>
            </div>

            <div class="buttons">
                <button class="load-page" data-page="upload.php">Upload Place</button><br>
                <button class="load-page" data-page="hotelinsert.php">Insert Hotels</button><br>
                <button class="load-page" data-page="update.php">Update Place</button><br>
                <button class="load-page" data-page="view.php">View Data's</button><br>
                <button><a href="adlogout.php">Logout</a></button>
            </div>
        </div>
        <div class="display" id="display-container">
            Select an option to load content.
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $(".load-page").click(function() {
                const page = $(this).data("page");
                $("#display-container").load(page, function(response, status, xhr) {
                    if (status == "error") {
                        $("#display-container").html("<p>error loading page!</p>");
                    }
                })
            })
        })
    </script>
</body>

</html>