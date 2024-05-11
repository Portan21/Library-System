<?php 
require 'config.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Records</title>
    <link rel="stylesheet" href="../CSS/index.css">
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel = "stylesheet" href = "https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"> 
</head>
<body>
<nav class="navbar sticky-top navbar-expand-lg bg-body-tertiary shadow">
    <div class="container-fluid">
        <a class="navbar-brand" href="landing.php"><img src="../Pictures/logo.png" style="height: 9,5%; width: 9.5%;">SCRIBE</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mb-lg-0 ms-auto">

            <li class="nav-item">
            <a class="nav-link" href="catalogs.php">Catalog</a>
            </li>
	    <?php
	    if(!empty($_SESSION["typeID"])){
	    echo"
            <li class='nav-item'>
            <a class='nav-link' href='request.php'>Request</a>
            </li>

            <li class='nav-item'>
            <a class='nav-link' href='borrowed.php'>Borrowed</a>
            </li>

            <li class='nav-item'>
            <a class='nav-link' href='penalty.php'>Penalty</a>
            </li>
            
            <li class='nav-item'>
            <a class='nav-link active' aria-current='page' href='librarianprofiles-records.php'>Records</a>
            </li>";
	    }

	    ?>

            <li class="nav-item">
            <a class="nav-link" href="profile.php">Profile</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
    </nav>
    <div class = "container py-4">
    <button class="select btn btn-primary mt-2"><a class="nav-link" href="librarianprofiles-records.php">Librarian Profiles</a></button>
    <button class="select btn btn-success mt-2"><a class="nav-link" href="patronprofiles-records.php">Patron Profiles</a></button>
    <button class="select btn btn-primary mt-2"><a class="nav-link" href="attendance(librarians)-records.php">Attendance - Librarian</a></button>
    <button class="select btn btn-primary mt-2"><a class="nav-link" href="attendance(patrons)-records.php">Attendance - Patron</a></button>
    <button class="select btn btn-primary mt-2"><a class="nav-link" href="returned-records.php">Returned Books</a></button>
    <button class="select btn btn-primary mt-2"><a class="nav-link" href="returnedwpenalty-records.php">Returned Books Penalty</a></button>
    <div class ="row">
    <h3 class="mb-4 mt-3 text-uppercase">Patron Accounts</h3>
    <table id="example" class="content-table" style="width:100%">
    <thead>
        <tr>
            <th class='px-4 py-2 text-center'>ID</th>
            <th class='px-4 py-2 text-center'>Name</th>
            <th class='px-4 py-2 text-center'>Email</th>
            <th class='px-4 py-2 text-center'>Course</th>
            <th class='px-4 py-2 text-center'>Status</th>
        </tr>
        </thead>
        <tbody>
            <?php  
                $result = mysqli_query($conn, "SELECT patronID, pt_name, email, course, status
                FROM patron_acc;");
                while($row = mysqli_fetch_assoc($result)){
                    if($row['status'] == 1){
                        echo "<tr>
                            <td class='px-4 py-2 text-center'>$row[patronID]</td>
                            <td class='px-4 py-2 text-center'>$row[pt_name]</td>
                            <td class='px-4 py-2 text-center'>$row[email]</td>
                            <td class='px-4 py-2 text-center'>$row[course]</td>
                            <td class='px-4 py-2 text-center'><button id='statusButton$row[patronID]' onmouseover='hover($row[patronID])' onmouseout='hoverOut($row[patronID])' onclick='changeStatus($row[patronID])' class='select btn btn-success'>Enabled</button></td>
                        </tr>";
                    }
                    else{
                        echo "<tr>
                            <td class='px-4 py-2 text-center'>$row[patronID]</td>
                            <td class='px-4 py-2 text-center'>$row[pt_name]</td>
                            <td class='px-4 py-2 text-center'>$row[email]</td>
                            <td class='px-4 py-2 text-center'>$row[course]</td>
                            <td class='px-4 py-2 text-center'><button id='statusButton$row[patronID]' onmouseover='hover($row[patronID])' onmouseout='hoverOut($row[patronID])' onclick='changeStatus($row[patronID])' class='select btn btn-danger'>Disabled</button></td>
                        </tr>";
                    }
                }     
            ?>
        </tbody>
      </table>
    </div>
    <script src = "https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src = "https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src = "https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src = "../JavaScript/accountStatus - patron.js"></script>
    <script src = "../JavaScript/app2.js"></script>
</body>
</html>