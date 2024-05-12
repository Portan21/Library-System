<?php 

require 'config.php';

if(!empty($_SESSION["accountID"])){
    header("Location: catalogs.php");
}

if(isset($_POST["login"])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM lib_acc WHERE email = '$email' AND status = '1'");
    $row = mysqli_fetch_assoc($result);

    if(mysqli_num_rows($result) > 0){
        if(password_verify($password, $row["password"])){
            
            $_SESSION["accountID"] = $row["librarianID"];
            $_SESSION["email"] = $row["email"];
            $_SESSION["name"] = $row["name"];
            $_SESSION["typeID"] = $row["typeID"];
            $_SESSION["login"] = true;

            header("Location: landing.php");
        }
        else{
            echo "<script> alert('Wrong Password'); </script>";
        }
    }
    else{
        $cresult = mysqli_query($conn, "SELECT * FROM patron_acc WHERE email = '$email' AND status = '1'");
        $crow = mysqli_fetch_assoc($cresult);

        if(mysqli_num_rows($cresult) > 0){
            if(password_verify($password, $crow["password"])){
                
                $_SESSION["accountID"] = $crow["patronID"];
                $_SESSION["email"] = $crow["email"];
                $_SESSION["name"] = $crow["pt_name"];
                $_SESSION["course"] = $crow["course"];
                $_SESSION["login"] = true;

                header("Location: patron_landing.php");
            }
            else{
                echo "<script> alert('Wrong Password'); </script>";
            }
        }
        else{
            echo "<script> alert('Account Not Found'); </script>";
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
    <link rel="stylesheet" href="../CSS/login.css">
    <script defer src="../JavaScript/bootstrap.bundle.min.js"></script>
    <script defer src="../JavaScript/javascript.js"></script>
    <title>Login</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row login">
            <div class="login-side col-lg-3">
            </div>
                <div class="login-form col-lg-6 rounded-5 border-0 shadow">
                <div class="col-lg-8 login-frame">

                <div class="row logo-container d-flex justify-content-center mt-4">
                    <div class="col-lg-3 d-flex justify-content-center">
                        <img class="logo" src="../Pictures/user log 2.png" alt="logo">
                    </div>
                </div>

                <div class="row login-text d-flex justify-content-center">
                    <div class="col-lg-4 d-flex justify-content-center">
                        <p class="login-sign">Login</p>
                    </div>
                </div>

                <div class="row d-flex justify-content-center mb-5">
                    <div class="col-lg-5 d-flex justify-content-center">
                        <form action="" method="post" autocomplete="off">
                            <label class="input-text" for="username">Email</label><br>
                            <input class="input-username format" type="text" id="email" name="email" required><br>

                            <label class="input-text" for="pwd">Password</label><br>
                            <input class="input-password format" type="password" id="password" name="password" required>
                            <div class="mb-5"></div>

                            <button class="login-button format" type="submit" value="Login" id="login" name="login">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
            <div class="login-side col-lg-3 mt-5 mb-5">
            </div>
        </div>
    </div>
</body>
</html>

