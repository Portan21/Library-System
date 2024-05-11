<?php
require 'config.php';
if(empty($_SESSION["accountID"])){
    header("Location: login.php");
}

if($_SESSION["typeID"] == 4){
    header("Location: catalog.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Approval</title>
    <link rel="stylesheet" href="../CSS/approval.css">
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
        $acctype = $_SESSION["typeID"];
	    if($acctype != 4){
	    echo"
            <li class='nav-item'>
            <a class='nav-link active' href='approval.php'>Approval</a>
            </li>

            <li class='nav-item'>
            <a class='nav-link' href='request.php'>Request</a>
            </li>

            <li class='nav-item'>
            <a class='nav-link' href='borrowed.php'>Borrowed</a>
            </li>

            <li class='nav-item'>
            <a class='nav-link' href='penalty.php'>Penalty</a>
            </li>";
	    }

	    ?>

            <li class="nav-item">
            <a class="nav-link"href="profile.php">Profile</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>
    <div class = "container py-5">
        <div class ="row">
            <table id="example" class="table table-borderless" style="width:100%">
                <thead>
                <tr>
                    <th class='text-uppercase'><h3>Account Approval</h3></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $result = mysqli_query($conn, "SELECT IDnumber, email, first_name, last_name FROM account_approval");
                while($row = mysqli_fetch_assoc($result)){
                    echo 
                    "<tr>
                        <td class='px-4 py-2'>
                            <div class='container'>
                                <div class='row border border-secondary rounded mt-1 mb-1'>
                                    <div class='col-7 text-break mt-1 mb-1'>
                                            <h3 class='text-uppercase mb-0'>$row[first_name] $row[last_name]</h3>
                                            <a>$row[IDnumber]</a><br>
                                            <a>$row[email]</a>
                                    </div>

                                    <div class='col-5 d-flex justify-content-end align-items-center'>
                                        <div>
                                            <a href='approveacc.php?appacc=$row[IDnumber]'><img id='imagebtn' class='logo' src='../Pictures/accept.png' alt='logo' onclick='return confirmApprove()'></a>
                                            <a href='rejectacc.php?rejacc=$row[IDnumber]'><img id='imagebtn' class='logo' src='../Pictures/reject.png' alt='logo' onclick='return confirmReject()'></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
    function confirmApprove() {
        return confirm('Press "OK" to approve the account. Press "Cancel" otherwise.');
    }
    function confirmReject() {
        return confirm('Press "OK" to reject the account. Press "Cancel" otherwise.');
    }
    </script>
    <script src = "https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src = "https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src = "https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src = "../JavaScript/app2.js"></script>
</body>
</html>