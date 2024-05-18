<?php

    echo"CATALOG";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalog</title>

    <link rel="stylesheet" type="text/css" href="../CSS/main.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="../CSS/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../fonts/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="../CSS/catalog.css">
    <link rel="stylesheet" type="text/css" href="../CSS/nivo-lightbox/nivo-lightbox.css">
    <link rel="stylesheet" type="text/css" href="../CSS/nivo-lightbox/default.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

<!-- Navigation Bar -->
<nav id="menu" class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand page-scroll" href="#page-top">SCRIBE</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="catalog.php" class="page-scroll">Catalog</a></li>
                <li><a href="profile.html" class="page-scroll">Profile</a></li>
                <li><a href="logout.php" class="page-scroll">Log Out</a></li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
</nav>
<!-- Body Content Below-->

<br>
<div class="container py-5">
    <div class="row">
        <h1>CATALOG</h1>
        <table id="example" class="content-table" style="width:100%">
            <thead>
                <tr>
                    <th>Book Title</th>
                    <th>Author</th>
                    <th>Genre</th>
                    <th>Year Published</th>
                    <th>Availability</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($conn, "SELECT book_name, author, genres, rating, availability FROM book");
                while ($row = mysqli_fetch_assoc($result)) {
                    echo
                    "<tr>
                        <td class='px-4 py-2 text-center border'>$row[book_name]</td>
                        <td class='px-4 py-2 text-center border'>$row[author]</td>
                        <td class='px-4 py-2 text-center border'>$row[genres]</td>
                        <td class='px-4 py-2 text-center border'>$row[rating]</td>
                        <td class='px-4 py-2 text-center border'>$row[availability]</td>
                    </tr>";
                }
                ?>
                <tr>
                    <td class="px-4 py-2 text-center border">The Great Gatsby</td>
                    <td class="px-4 py-2 text-center border">F. Scott Fitzgerald</td>
                    <td class="px-4 py-2 text-center border">Drama</td>
                    <td class="px-4 py-2 text-center border">4.5</td>
                    <td class="px-4 py-2 text-center border">Available</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/JavaScript/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/JavaScript/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript" src="../JavaScript/bootstrap.js"></script>
<script type="text/javascript" src="../JavaScript/SmoothScroll.js"></script>
<script type="text/javascript" src="../JavaScript/nivo-lightbox.js"></script>
<script type="text/javascript" src="../JavaScript/jqBootstrapValidation.js"></script>
<script type="text/javascript" src="../JavaScript/main.js"></script>
<script src="../JavaScript/app2.js"></script>
<!-- Other scripts go here -->

</body>
</html>