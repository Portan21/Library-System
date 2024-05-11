<?php 

require 'config.php';

if(empty($_SESSION["accountID"])){
    header("Location: login.php");
}

if(empty($_SESSION["typeID"])){
    header("Location: catalogs.php");
}
else{
    if($_SESSION["typeID"] == 3){
        header("Location: landing.php");
    }
    $typeid = $_SESSION["typeID"];
}

if(isset($_POST["regis"])){
    $fname = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];
    $accounttype = $_POST["accountType"];

    $duplicateEmail = mysqli_query($conn, "SELECT email FROM lib_acc WHERE email = '$email'");
    if(mysqli_num_rows($duplicateEmail) > 0){
        echo "<script> alert('Email Has Already Been Taken'); </script>";
    }
    else{
        if($password == $confirmpassword){
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $insertquery = "INSERT INTO lib_acc (email, password, name, typeID) VALUES ('$email', '$hashed_password', '$fname', '$accounttype')";

            mysqli_query($conn,$insertquery);
            echo "<script> alert('Registration Successful!!'); </script>";
        }
        else{
            echo "<script> alert('Password Does Not Match'); </script>";
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
    <style>

    .container-fluid{
    background-color: #e9f6ff;
    height: 100vh;
}

.register{
    padding: 10%;
    padding-top: 7%;
}

.register-sign{
    font-size: 26px;
    font-weight: bold;
}

.register-form{
    background-color: #ffffff;
    height: 100%;
}

.register-text{
    margin: 0;
    padding: 0;
    padding-top: 4%;
}

.register-frame{
    height: 100%;
    width: 100%;
}

.format{
    border: 2px solid gray;
    border-radius: 20px;
    width: 350px;
    padding-left: 10px;
    height: 25px;
    display: block;
}

.submit-button{
    border: 2px solid transparent;
    border-radius: 20px;
    width: 350px;
    height: 45px;
    margin-top: 8%;
    background-color: #d6eeff;
}

a{
    font-size: 12px;
}

.input-text{
    font-size: 12px;
}

@media only screen and (max-width: 1000px) {
    .regsiter-form{
        background-color: #ffffff;
        height: 70vh;
    }

    .format{
        border: 2px solid gray;
        border-radius: 20px;
        width: 200px;
        padding-left: 10px;
        height: 25px;
        display: block;
    }

    .submit-button{
        border: 2px solid transparent;
        border-radius: 20px;
        width: 200px;
        height: 45px;
        margin-top: 8%;
        background-color: #d6eeff;
    }
}
  




    </style>
    <script defer src="../JavaScript/bootstrap.bundle.min.js"></script>
    <script defer src="../JavaScript/javascript.js"></script>
    <title>Create Admin/Librarian Account</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row register">
            <div class="register-side col-lg-3">
            </div>
            <div class="register-form col-lg-6 rounded-5 border-0 shadow">
                <div class="col-lg-8 register-frame">

                    <div class="row register-text d-flex justify-content-center mt-2">
                        <div class="col-lg-8 d-flex justify-content-center">
                            <p class="register-sign text-center">CREATE LIBRARIAN ACCOUNT</p>
                        </div>
                    </div>

                    <div class="row d-flex justify-content-center mb-5">

                        <div class="col-lg-3 d-flex justify-content-center">
                            <form action="" method="post" autocomplete="off">

                                <label class="input-text" for="name">FULL NAME</label><br>
                                <input class="input-name format" type="text" id="name" name="name" placeholder="Juan Dela Cruz" required>

                                <label class="input-text" for="email">EMAIL ADDRESS</label><br>
                                <input class="input-email format" type="text" id="email" name="email" required>

                                <label class="input-text" for="password">PASSWORD</label><br>
                                <input class="input-password format" type="password" id="password" name="password" required>

                                <label class="input-text" for="confirmpassword">CONFIRM PASSWORD</label><br>
                                <input class="input-confirmpassword format" type="password" id="confirmpassword" name="confirmpassword" required>

                                <label class="input-text" for="accounttype">ACCOUNT TYPE</label>
                                <div class="form-check">
                                    <?php
                                    if($typeid == 1){
                                        echo"
                                        <input class='form-check-input' type='radio' name='accountType' id='accountType1' value='1'>
                                        <label class='form-check-label' for='accountType1'> Admin</label>
                                        </div>
                                        <div class='form-check'>
                                        <input class='form-check-input' type='radio' name='accountType' id='accountType2' value='2'>
                                        <label class='form-check-label' for='accountType2'> Head Librarian</label>
                                        </div>
                                        <div class='form-check'>
                                        <input class='form-check-input' type='radio' name='accountType' id='accountType3' value='3' checked>
                                        <label class='form-check-label' for='accountType3'> Librarian</label>";
                                    }
                                    else if($typeid == 2){
                                        echo"
                                        <input class='form-check-input' type='radio' name='accountType' id='accountType3' value='3' checked>
                                        <label class='form-check-label' for='accountType3'> Librarian</label>";
                                    }


                                    ?>
                                </div>

                                <button class="submit-button format" type="submit" value="SUBMIT" id="regis" name="regis" onclick='return confirmApprove()'>SUBMIT</button>
                            </form>
                        </div>
                        <div class="row d-flex justify-content-center">
                                <div class="col-lg-6 d-flex justify-content-center mt-2">
                                   
                                    <a class="create-format" href="landing.php">Back to Landing</a>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="register-side col-lg-3">
            </div>
        </div>
    </div>
    
    <script>
    function confirmApprove() {
        return confirm('Press "OK" to proceed on creating the account. Press "Cancel" otherwise.');
    }
    </script>
</body>
</html>