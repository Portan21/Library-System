<?php 

    require 'config.php';

    if(empty($_SESSION["accountID"])){
        header("Location: login.php");
    }
    else{
        $id = $_SESSION["accountID"];
    }

    date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippines
    $currentDateTime = date('Y-m-d H:i:s');

    date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippines
    $currentDate = new DateTime();

if(isset($_POST["ret"])){
    $borrowID = $_POST["borrowID"];

    $bdateres = mysqli_query($conn, "SELECT borrow_date FROM borrowed_book WHERE borrowID = $borrowID");
    while($rowbdate = mysqli_fetch_assoc($bdateres)){
        $borrowdate = new DateTime($rowbdate["borrow_date"]);

        $interval = $borrowdate->diff($currentDate);

        $months = $interval->y * 12 + $interval->m;
        // Access the difference in days, hours, minutes, and seconds
        $days = $interval->d;

        $totaldays = ($months * 30) + $days;
        $totalpenalty = $totaldays * 10;
        
        
        $insquery = "INSERT INTO returned_book (bookID, borrowerID, librarianID, borrow_date, return_date, penalty_paid)
        SELECT bookID, borrowerID, $id, borrow_date, '$currentDateTime', '$totalpenalty'
        FROM borrowed_book
        WHERE borrowID = $borrowID";
        if(mysqli_query($conn, $insquery)){
            $delquery = "DELETE FROM borrowed_book WHERE borrowID = $borrowID";
            if(mysqli_query($conn, $delquery)){
            }
            else{
                echo"<script>alert('DELETING ERROR');</script>";
            }
        }

        //echo"<script>alert('Total Penalty: ₱$totalpenalty.00');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/profile.css">
    <link rel="icon" href="../Pictures/logo-header.png" type="image/ico">
    <script defer src="../JavaScript/bootstrap.bundle.min.js"></script>
    <script defer src="../JavaScript/profile.js"></script>
    <title>Profile</title>
</head>
<body>

<nav class="navbar sticky-top navbar-expand-lg bg-body-tertiary shadow px-5">
    <div class="container-fluid">
        
        <a class="navbar-brand"  style="max-width: 150px;"  href="landing.php">
            <img src="../Pictures/logo.png" style="height: 9.5%; width: 35%;" alt="Logo">SCRIBE
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mb-lg-0 ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="catalogs.php">CATALOG</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="return.php">RETURN</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link active" aria-current="page" href="profile.php">PROFILE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">LOGOUT</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <div class="container-fluid">
        <div class="row mx-md-3 my-md-2 me-1">
            <div class="col-lg border-0 shadow p-2 m-2">
                <div class="col-lg-11">
                    <div class="col-lg-12">
                        <p class="overview">Overview <a href="accountedit.php"><input class="edit-button pt-1 pb-1 pl-1 pr-1" type="submit" value="Edit"></a> </p>
                        
                        <hr>
                    </div>
                    <div class="row">
                        <div class="col-12">
                        <table id="example" class="content-table table-borderless" style="table-layout:fixed; width:100%">
                            <thead>
                                <tr>
                                    <th class='px-5 py-2'>Name</th>
                                    <?php
                                        if(!empty($_SESSION["typeID"])){
                                            $accID = $_SESSION["accountID"];
                                            $result = mysqli_query($conn, "SELECT name
                                            FROM account_type a JOIN lib_acc l ON a.type_ID = l.typeID
                                            WHERE librarianID = '$accID'");
                                            $row = mysqli_fetch_assoc($result);
                                            $name = $row['name'];
                                            echo"
                                            <td class='px-4 py-2 text-end overview-text'>$name</td>";
                                        }
                                        else{
                                            $accID = $_SESSION["accountID"];
                                            $result = mysqli_query($conn, "SELECT course, pt_name, email
                                            FROM patron_acc
                                            WHERE patronID = '$accID'");
                                            $row = mysqli_fetch_assoc($result);
                                            $name = $row['pt_name'];
                                            $email = $row['email'];
                                            $course = $row['course'];
                                            echo"
                                            <td class='px-4 py-2 text-end overview-text'>$name</td>";
                                        }
                                        ?>
                                    
                                </tr>  
                                <tr>
                                    <th class='px-5 py-2'>Email</th>
                                    <?php
                                        if(!empty($_SESSION["typeID"])){
                                            $accID = $_SESSION["accountID"];
                                            $result = mysqli_query($conn, "SELECT email
                                            FROM account_type a JOIN lib_acc l ON a.type_ID = l.typeID
                                            WHERE librarianID = '$accID'");
                                            $row = mysqli_fetch_assoc($result);
                                            $email = $row['email'];
                                            echo"
                                            <td class='px-4 py-2 text-end overview-text'>$email</td>";
                                        }
                                        else{
                                            $accID = $_SESSION["accountID"];
                                            $result = mysqli_query($conn, "SELECT course, pt_name, email
                                            FROM patron_acc
                                            WHERE patronID = '$accID'");
                                            $row = mysqli_fetch_assoc($result);
                                            $name = $row['pt_name'];
                                            $email = $row['email'];
                                            $course = $row['course'];
                                            echo"
                                            <td class='px-4 py-2 text-end overview-text'>$email</td>";
                                        }
                                    ?>
                                </tr>  
                                <tr>
                                    <th class="px-5 py-2">
                                        <?php
                                        if(!empty($_SESSION["typeID"])){
                                            $accID = $_SESSION["accountID"];
                                            $result = mysqli_query($conn, "SELECT nameType
                                            FROM account_type a JOIN lib_acc l ON a.type_ID = l.typeID
                                            WHERE librarianID = '$accID'");
                                            $row = mysqli_fetch_assoc($result);
                                            echo "Account Type";}
                                        else{
                                            echo "Course";
                                        }
                                        ?>
                                    </th>
                                    <?php
                                        if(!empty($_SESSION["typeID"])){
                                            $accID = $_SESSION["accountID"];
                                            $result = mysqli_query($conn, "SELECT nameType
                                            FROM account_type a JOIN lib_acc l ON a.type_ID = l.typeID
                                            WHERE librarianID = '$accID'");
                                            $row = mysqli_fetch_assoc($result);
                                            $type = $row['nameType'];
                                            echo"
                                            <td class='px-4 py-2 text-end overview-text'>$type</td>";
                                        }
                                        else{
                                            $accID = $_SESSION["accountID"];
                                            $result = mysqli_query($conn, "SELECT course, pt_name, email
                                            FROM patron_acc
                                            WHERE patronID = '$accID'");
                                            $row = mysqli_fetch_assoc($result);
                                            $name = $row['pt_name'];
                                            $email = $row['email'];
                                            $course = $row['course'];
                                            echo"
                                            <td class='px-4 py-2 text-end overview-text'>$course</td>";
                                        }
                                    ?>
                                </tr>             
                            </thead>
                            
                        </table>

                            <div class="col-lg-3">
                            <a href='#'>
                                <input class="view-button" type="submit" value="View QR">
                            </a>
                            </div>
                            <div id="myModal" class="modal2">
                                <div class="modal-content2">
                                    <span class="close" id="closeModal">&times;</span>

                                    <div class="row qr-text d-flex justify-content-center">
                                        <div class="col-lg-12 d-flex justify-content-center">
                                            <p id="qr-name" class="qr-sign"><?php echo $_SESSION["name"]; ?></p>
                                        </div>
                                    </div>

                                    <div class="row qr-image d-flex justify-content-center">
                                        <div class="col-lg-3 d-flex justify-content-center">
                                            <img src="" id="qrcode">
                                        </div>
                                    </div>

                                    <!-- Borrow button with ID for styling -->
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-lg-3 d-flex justify-content-center">
                                            <a download href="https://api.qrserver.com/v1/create-qr-code/?size=[250]x[250]&data=<?php echo $_SESSION["email"] ?>&margin=15&download=1">
                                            <input class="download-button format" type="submit" value="DOWNLOAD QR">
                                            </a>
                                        </div>
                                    </div>
                                
                                    <!-- Remove button with ID for styling 
                                    <button id="remove-button">Remove</button>-->
                                
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-lg border-0 shadow p-2 m-2">
                <div class="col-lg-11">
                    <div class="col-lg-12">
                        <p class="overview">Attendance History</p>
                        <hr>
                    </div>
                    <div class ="">
                        <div class ="row">
                        <table id="example" class="content-table table-borderless" style="width:100%">
                            <thead>
                                <tr>
                                    <th class='px-4 py-2 text-center'>Date</th>
                                    <th class='px-4 py-2 text-center'>Time in</th>
                                    <th class='px-4 py-2 text-center'>Time out</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(!empty($_SESSION["typeID"])){
                                        $accID = $_SESSION["accountID"];
                                        $result = mysqli_query($conn, "SELECT lib_entry, lib_exit
                                        FROM lib_attendance
                                        WHERE librarianID = '$accID'
                                        ORDER BY lib_attendanceID DESC
                                        LIMIT 3;");
                                        while($row = mysqli_fetch_assoc($result)){
                                            $date = substr("$row[lib_entry]", 0, 10);
                                            $timeIN = substr("$row[lib_entry]", -8);
                                            $timeOUT = substr("$row[lib_exit]", -8);
                                            echo "<tr>
                                                <td class='px-4 py-2 text-center'>$date</td>
                                                <td class='px-4 py-2 text-center'>$timeIN</td>
                                                <td class='px-4 py-2 text-center'>$timeOUT</td>
                                            </tr>";
                                        }     
                                    }  
                                    else{
                                        $accID = $_SESSION["accountID"];
                                        $result = mysqli_query($conn, "SELECT pt_entry, pt_exit
                                        FROM patron_attendance
                                        WHERE patronID = '$accID'
                                        ORDER BY pt_attendanceID DESC
                                        LIMIT 3;");
                                        while($row = mysqli_fetch_assoc($result)){
                                            $date = substr("$row[pt_entry]", 0, 10);
                                            $timeIN = substr("$row[pt_entry]", -8);
                                            $timeOUT = substr("$row[pt_exit]", -8);
                                            echo "<tr>
                                                <td class='px-4 py-2 text-center'>$date</td>
                                                <td class='px-4 py-2 text-center'>$timeIN</td>
                                                <td class='px-4 py-2 text-center'>$timeOUT</td>
                                            </tr>";
                                        }     
                                    }
                                ?>
                            </tbody>
                        </table>
                        <a href='attendance-profile.php'>
                            <input class="view-all format" type="submit" value="View all">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        </div>


        <?php
        if(empty($_SESSION["typeID"])){
        echo"<div class='row mx-md-3 my-md-2 me-1'>
            <div class='col-lg border-0 shadow p-2 m-2'>
                <div class='col-lg-11'>
                    <div class='col-lg-12'>
                        <p class='overview'>Borrowed Books</p>
                        <hr>
                    </div>
                    <div class='row'>
                    <table id='example' class='content-table table-borderless' style='width:100%'>
                        <thead>
                            <tr>
                                <th class='px-4 py-2 text-center'>Date</th>
                                <th class='px-4 py-2 text-center'>Deadline</th>
                                <th class='px-4 py-2 text-center'>Title</th>
                            </tr>
                        </thead>
                        <tbody>";
                            if(empty($_SESSION["typeID"])){   
                                $accID = $_SESSION["accountID"];
                                $result = mysqli_query($conn, "SELECT borrow_date,deadline,bookID
                                FROM borrowed_book
                                WHERE patronID = '$accID'
                                ORDER BY borrow_date DESC
                                LIMIT 3;");

                                while($row = mysqli_fetch_assoc($result)){

                                    $booknumber = $row["bookID"];
                                    $result2 = mysqli_query($conn, "SELECT book_name
                                    FROM book
                                    WHERE bookID = '$booknumber';");

                                    $row2 = mysqli_fetch_assoc($result2);

                                    echo "<tr>
                                        <td class='px-4 py-2 text-center'>$row[borrow_date]</td>
                                        <td class='px-4 py-2 text-center'>$row[deadline]</td>
                                        <td class='px-4 py-2 text-center'>$row2[book_name]</td>
                                    </tr>";
                                }     
                            }
                            echo"
                        </tbody>
                    </table>
                    <a href='borrowedbooks-profile.php'>
                        <input class='view-all format' type='submit' value='View all'>
                    </a>                       
                    </div>
                </div>
            </div>";

            echo'
            <div class="col-lg border-0 shadow p-2 m-2">
                <div class="col-lg-11">
                    <div class="col-lg-12">
                        <p class="overview">Penalty</p>
                        <hr>
                    </div>
                    <div class = "">
                            <div class ="row">
                            <table id="example" class="content-table table-borderless" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 text-center">Book Name</th>
                                        <th class="px-4 py-2 text-center">Days Late</th>
                                        <th class="px-4 py-2 text-center">Penalty Fee</th>
                                    </tr>
                                </thead>
                                <tbody>';

                                $result = mysqli_query($conn, "SELECT borrowID, a.pt_name AS bf_name, ac.name AS lf_name, book_name, deadline, bb.borrow_date AS borrow_date FROM borrowed_book bb
                                INNER JOIN book b on bb.bookID = b.bookID
                                INNER JOIN patron_acc a on bb.patronID = a.patronID
                                INNER JOIN lib_acc ac on bb.librarianID = ac.librarianID
                                WHERE deadline < '$currentDateTime'
                                AND a.patronID = '$accID'");
                                while($row = mysqli_fetch_assoc($result)){
                                    $brwdate = new DateTime($row["borrow_date"]);
                                    
                                    $intrvl = $brwdate->diff($currentDate);
                                    $mnt = $intrvl->y * 12 + $intrvl->m;
                                    $dys = $intrvl->d;
                    
                                    $totday = ($mnt * 30) + $dys;
                                    $totpen = $totday * 10;
                                    echo "<tr>
                                        <td class='px-4 py-2 text-center'>$row[book_name]</td>
                                        <td class='px-4 py-2 text-center'>$totday days</td>
                                        <td class='px-4 py-2 text-center'>₱$totpen.00</td>
                                    </tr>"; }

                                    echo'
                                </tbody>
                            </table>
                            <a href="penaltyprofile.php">
                                <input class="view-all format" type="submit" value="View all">
                            </a>
                        </div>
                    </div>
                </div>
            </div>';
            }?>
    </div>

    

    <script>var qrText = document.getElementById('qr-name').innerHTML;


qrcode.src="https://api.qrserver.com/v1/create-qr-code/?size=[250]x[250]&data=" + qrText;
    
// Get the modal and its elements
const modal = document.getElementById("myModal");

// Get all book buttons
const bookButtons = document.querySelectorAll(".view-button");

// Attach click event to each book button
bookButtons.forEach((button) => {
  button.addEventListener("click", (e) => {
    e.preventDefault(); // Prevent the default behavior of anchor tags
        
    // Show the modal
    modal.style.display = "flex";
  });
});

// Close the modal when the 'x' is clicked or when clicking outside of it
const closeModal = document.getElementById("closeModal");
closeModal.addEventListener("click", () => {
  modal.style.display = "none";
});

window.addEventListener("click", (event) => {
  if (event.target === modal) {
    modal.style.display = "none";
  }
});

</script>
</body>
</html>




