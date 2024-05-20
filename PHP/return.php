<?php
require 'config.php';
if(empty($_SESSION["accountID"])){
    header("Location: login.php");
}
else{
    $id = $_SESSION["accountID"];
}

if(!empty($_SESSION["typeID"])){
    header("Location: profile.php");
}

date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippines
$currentDateTime = date('Y-m-d H:i:s');

date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippines
$currentDate = new DateTime();

if(isset($_POST["ret"])){
    $borrowID = $_POST["borrowID"];

    $insquery = "INSERT INTO return_form (borrowID) VALUES ($borrowID)";

    if(mysqli_query($conn, $insquery)){
        echo "<script>alert('Return Form Submitted.');</script>";
    }
    else{
        echo "<script>alert('Return Form Submission Unsuccessful.');</script>";
    }
}

if(isset($_POST["retpen"])){
    $borrowID = $_POST["borrowID"];
    $receipt_num = $_POST["receiptNumber"];

    $insquery = "INSERT INTO return_form (borrowID, receipt_number) VALUES ($borrowID, $receipt_num)";

    if(mysqli_query($conn, $insquery)){
        echo "<script>alert('Return Form Submitted.');</script>";
    }
    else{
        echo "<script>alert('Return Form Submission Unsuccessful.');</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Form</title>
    <link rel="stylesheet" href="../CSS/approval.css">
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel = "stylesheet" href = "https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">  
    <link rel="icon" href="../Pictures/logo-header.png" type="image/ico">
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
                <li class="nav-item active">
                    <a class="nav-link active" aria-current="page" href="return.php">RETURN</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">PROFILE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">LOGOUT</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


    <div class = "container py-5">
        <div class ="row">
        <table id="example" class="table table-borderless" style="width:100%">
            <thead>
            <tr>
                <th class='text-uppercase'><h3>Borrowed Books</h3></th>
            </tr>
            </thead>
            <tbody>
            <?php
            
            $result = mysqli_query($conn, "SELECT a.patronID, borrowID, a.pt_name AS bf_name, ac.name AS lf_name, book_name, bb.borrow_date AS borrow_date, deadline FROM borrowed_book bb
            INNER JOIN book b on bb.bookID = b.bookID
            INNER JOIN patron_acc a on bb.patronID = a.patronID
            INNER JOIN lib_acc ac on bb.librarianID = ac.librarianID
            WHERE a.patronID = '$id'");// AND deadline >= '$currentDateTime'

            while($row = mysqli_fetch_assoc($result)){
                $brwdate = new DateTime($row["borrow_date"]);
                
                $intrvl = $brwdate->diff($currentDate);
                $mnt = $intrvl->y * 12 + $intrvl->m;
                $dys = $intrvl->d;

                $totday = ($mnt * 30) + $dys;
                $totpen = $totday * 10;

                
                $currentcost = "SELECT cost 
                FROM penalty_cost 
                ORDER BY penaltyID DESC
                LIMIT 1";

                $costresult = mysqli_query($conn, $currentcost);

                if ($costresult && mysqli_num_rows($costresult) > 0) {
                    $currow = mysqli_fetch_assoc($costresult);
                    $latestCost = $currow['cost'];
                }



                if($row['deadline'] >= $currentDateTime){
                    $borrowID = $row['borrowID'];
                    $returnresult = mysqli_query($conn, "SELECT * FROM return_form WHERE borrowID = $borrowID");
                    $returnrow = mysqli_fetch_assoc($returnresult);
                
                echo 
                "<tr>
                    <td class='px-4 py-2'>
                        <div class='container'>

                            <div class='row border border-secondary rounded mt-1 mb-1'>
                                <div class='col-5 text-break mt-1 mb-2 '>
                                        <h3 class='text-uppercase mb-0'>$row[book_name]</h3>
                                </div>
                                
                                <div class='col-4 text-break mt-1 mb-2'>
                                        <a><b>Deadline:</b></a><br>
                                        <h3 class='text-uppercase mb-0'>$row[deadline]</h3>
                                </div>

                                <div class='col-3 d-flex justify-content-end align-items-center'>
                                    <div>
                                        <form action='' method='post' autocomplete='off'>
                                            <input type='hidden' id='borrowID' name='borrowID' value='$row[borrowID]'>";

                                            if(mysqli_num_rows($returnresult) > 0){
                                                echo"<button type='submit' class='btn btn-primary py-2' onclick='return confirmReturn()' id='ret' name='ret' disabled>RETURN</button>";
                                            }
                                            else{
                                                echo"<button type='submit' class='btn btn-primary py-2' onclick='return confirmReturn()' id='ret' name='ret''>RETURN</button>";
                                            }

                                            echo"
                                        </form>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </td>
                </tr>";
                }
                else{
                    $borrowID = $row['borrowID'];
                    $returnresult = mysqli_query($conn, "SELECT * FROM return_form WHERE borrowID = $borrowID");
                    $returnrow = mysqli_fetch_assoc($returnresult);

                    $totalcost = $totday * $latestCost;
                    echo 
                    "<tr>
                        <td class='px-4 py-2'>
                            <div class='container'>
    
                                <div class='row border border-secondary rounded mt-1 mb-1'>
                                    <div class='col-5 text-break mt-1 mb-2 '>
                                            <h3 class='text-uppercase mb-0'>$row[book_name]</h3>
                                    </div>
                                    
                                    <div class='col-4 text-break mt-1 mb-2'>
                                            <a><b>Deadline:</b></a><br>
                                            <h3 class='text-uppercase text-danger mb-0'>$row[deadline]</h3>
                                            <h5 class='text-uppercase mb-0 text-danger'>$totday days late (Php $totalcost)</h5>
                                    </div>
    
                                    <div class='col-3 d-flex justify-content-end align-items-center'>
                                        <div>
                                            <input type='hidden' id='borrowID' name='borrowID' value='$row[borrowID]'>";

                                            if(mysqli_num_rows($returnresult) > 0){
                                                echo"<button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#exampleModal$row[borrowID]' disabled>RETURN</button>";
                                            }
                                            else{
                                                echo"<button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#exampleModal$row[borrowID]'>RETURN</button>";
                                            }

                                            echo"
                                            <div class='modal fade' id='exampleModal$row[borrowID]' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                                <div class='modal-dialog modal-dialog-centered'>
                                                    <div class='modal-content'>
                                                    <div class='modal-header'>
                                                        <h1 class='modal-title fs-5 text-uppercase mb-0' id='exampleModalLabel'>Return Form</h1>
                                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                    </div>
                                                    <div class='modal-body'>
                                                        <h3 class='text-uppercase mb-0'>$row[book_name]</h3>
                                                        <form id='returnForm$row[borrowID]' method='post' action=''  autocomplete='off'>
                                                            <input type='hidden' name='borrowID' value='$row[borrowID]'>
                                                            <div class='mb-3 mt-2'>
                                                                <label for='receiptNumber' class='form-label'>Receipt Number:</label>
                                                                <input type='value' class='form-control' id='receiptNumber' name='receiptNumber' required>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class='modal-footer'>
                                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                                        <button type='submit' form='returnForm$row[borrowID]' class='btn btn-success' id='retpen' name='retpen'>Submit</button>
                                                    </div>
                                                    </div>
                                                        
                                                </div>
                                            </div>

                                        </div>
                                    </div>


    
                                </div>
    
                            </div>
                        </td>
                    </tr>";
                }
            }
            ?>
            </tbody>
        </table>
        </div>
    </div>
    
    <script>
    function confirmReturn() {
        return confirm('Press "OK" to confirm the book return. Press "Cancel" otherwise.');
    }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src = "https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src = "https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src = "https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src = "../JavaScript/app2.js"></script>
</body>
</html>