<?php 
require 'config.php';

if(empty($_SESSION["accountID"])){
    header("Location: login.php");
}
else{
    $id = $_SESSION["accountID"];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["submit"])) {
        if (isset($_POST['changePasswordCheckbox'])) {
            $current = mysqli_real_escape_string($conn, $_POST["current_password"]);
            $change = mysqli_real_escape_string($conn, $_POST["change_password"]);
            $confirm = mysqli_real_escape_string($conn, $_POST["confirm_password"]);
            if(!empty($current) & !empty($change) & !empty($confirm)){
                if(!empty($_SESSION["typeID"])){
                    $result = mysqli_query($conn, "SELECT password FROM lib_acc WHERE librarianID = '$id'");
                    $row = mysqli_fetch_assoc($result);
                    
                    if(mysqli_num_rows($result) > 0){
                        if(password_verify($current, $row["password"])){
                            if($change == $confirm){
                                if($change == $current){
                                    echo "<script> alert('New Password Cannot Be Similar With the Current Password.'); </script>";
                                }
                                else{
                                    $hashed_new_password = password_hash($change, PASSWORD_DEFAULT);

                                    $updatequery = "UPDATE lib_acc SET 
                                    password = '$hashed_new_password'
                                    WHERE librarianID = '$id';
                                    ";
        
                                    if (mysqli_query($conn, $updatequery)) {
                                        echo "<script> alert('Account Update Successful'); </script>";
                                    }
                    
                                    //echo "<script> alert('New Password Match'); </script>";
                                }
                            }
                            else{
                                echo "<script> alert('New Password Does Not Match'); </script>";
                            }
                        }
                        else{
                            echo "<script> alert('Wrong Current Password'); </script>";
                        }
                    }

                }
                else{
                    $course = mysqli_real_escape_string($conn, $_POST["course"]);

                    $result = mysqli_query($conn, "SELECT password FROM patron_acc WHERE patronID = '$id'");
                    $row = mysqli_fetch_assoc($result);
                    
                    if(mysqli_num_rows($result) > 0){
                        if(password_verify($current, $row["password"])){
                            if($change == $confirm){
                                if($change == $current){
                                    echo "<script> alert('New Password Cannot Be Similar With the Current Password.'); </script>";
                                }
                                else{
                                    $hashed_new_password = password_hash($change, PASSWORD_DEFAULT);

                                    $updatequery = "UPDATE patron_acc SET 
                                    course = '$course',
                                    password = '$hashed_new_password'
                                    WHERE patronID = '$id';
                                    ";
        
                                    if (mysqli_query($conn, $updatequery)) {
                                        echo "<script> alert('Account Update Successful'); </script>";
                                    }
                    
                                    //echo "<script> alert('New Password Match'); </script>";
                                }
                            }
                            else{
                                echo "<script> alert('New Password Does Not Match'); </script>";
                            }
                        }
                        else{
                            echo "<script> alert('Wrong Current Password'); </script>";
                        }
                    }

                }
            }
            else{
                echo "<script> alert('Fill All Information'); </script>";
            }
        }
        else{
            if(empty($_SESSION["typeID"])){
                $course = mysqli_real_escape_string($conn, $_POST["course"]);
                
                $updatequery = "UPDATE patron_acc SET 
                course = '$course'
                WHERE patronID = '$id';
                ";

                if (mysqli_query($conn, $updatequery)) {
                    echo "<script> alert('Course Update Successful'); </script>";
                }

                //echo "<script> alert('$course'); </script>";
            }
        }

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/register.css">
    <script defer src="../JavaScript/bootstrap.bundle.min.js"></script>
    <script defer src="../JavaScript/javascript.js"></script>
    <title>Account Management</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
                <a class='nav-link' href='librarianprofiles-records.php'>Records</a>
                </li>";
            }

            ?>

                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="profile.php">Profile</a>
                </li>

                <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
    </nav>

    <div class="container-nav pd-5">
        <div class="row pt-3"></div>
        <div class="row pt-5">
            <div class="col-md-3"></div>
            <div class="col-md-6 pt-5 mt-2">
                <div class="card">
                    <div class="card-body">
                        <h1 class="text-uppercase">Account Management</h1>
                        <form action="" method="post" autocomplete="off">
                            <div class="mb-2 mt-2">
                                <label for="exampleInputEmail1" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $_SESSION['email']; ?>" disabled>
                            </div>

                            <div class="mb-2 mt-2">
                                <label for="exampleInputEmail1" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" value="<?php echo $_SESSION['name']; ?>" disabled>
                            </div>
                            <?php
                            if(!empty($_SESSION["typeID"])){
                                if($_SESSION["typeID"] == 1){
                                echo"
                                <div class='mb-2 mt-2'>
                                    <label for='exampleInputEmail1' class='form-label'>Account Type</label>
                                    <input type='text' class='form-control' aria-describedby='emailHelp' value='Admin' disabled>
                                </div>";
                                }
                                else if($_SESSION["typeID"] == 2){
                                    echo"
                                    <div class='mb-2 mt-2'>
                                        <label for='exampleInputEmail1' class='form-label'>Account Type</label>
                                        <input type='text' class='form-control' aria-describedby='emailHelp' value='Head Librarian' disabled>
                                    </div>";
                                }
                                else{
                                    echo"
                                    <div class='mb-2 mt-2'>
                                        <label for='exampleInputEmail1' class='form-label'>Account Type</label>
                                        <input type='text' class='form-control' aria-describedby='emailHelp' value='Librarian' disabled>
                                    </div>";
                                }
                            }
                            else{
                                $result = mysqli_query($conn, "SELECT course FROM patron_acc WHERE patronID = '$id'");
                
                                while($row = mysqli_fetch_assoc($result)){
                                    $acccourse = $row['course'];
                                }
                                echo"
                                <div class='mb-2 mt-2'>
                                    <label for='exampleInputEmail1' class='form-label'>Course</label>
                                    <input type='text' class='form-control' id='course' name='course' aria-describedby='emailHelp' value='$acccourse'  required>
                                </div>";
                            }
                            ?>

                            <!-- Existing form fields... -->
                            <div class=" form-check">
                                <input type="checkbox" class="form-check-input" id="changePasswordCheckbox" name="changePasswordCheckbox">
                                <label class="form-check-label" for="changePasswordCheckbox">Change Password</label>
                            </div>

                            <!-- Additional password fields initially hidden -->
                            <div id="passwordFields" style="display:none">
                                <div class="mb-2 mt-2">
                                    <label for="exampleInputPassword1" class="form-label">Current Password</label>
                                    <input type="password" class="form-control" id="current_password" name="current_password">
                                </div>
                                <div class="mb-2 mt-2">
                                    <label for="exampleInputPassword1" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="change_password" name="change_password">
                                </div>
                                <div class="mb-2 mt-2">
                                    <label for="exampleInputPassword2" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                </div>
                            </div>

                            <button type="submit" name="submit" id="submit" class="btn btn-success mt-4">Update Changes</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>

    <script>
        // Use jQuery to handle checkbox change event
        $(document).ready(function () {
            $('#changePasswordCheckbox').change(function () {
                // Show/hide password fields based on checkbox state
                $('#passwordFields').toggle(this.checked);
            });
        });
    </script>
</body>
</html>