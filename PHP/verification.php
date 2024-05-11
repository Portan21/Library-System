<?php
require 'config.php';

if(!empty($_SESSION["accountID"])){
    header("Location: catalogs.php");
}

if(empty($_SESSION["verifyemail"])){
    header("Location: login.php");
}
else{
$verifyemail = $_SESSION["verifyemail"];
}

if(isset($_POST["verify"])){
    $verifycode = $_POST["verificationCode"];

    $coderesult = mysqli_query($conn, "SELECT * FROM account_approval WHERE email = '$verifyemail' AND code = '$verifycode'");
    if(mysqli_num_rows($coderesult) > 0){

        $row = mysqli_fetch_assoc($coderesult); // Fetch the first row from the result set
        $name = $row['name'];
        $password = $row['password'];
        $course = $row['course'];

        // Verify if the email already exists in the patron_acc table
        $emailCheckQuery = "SELECT * FROM patron_acc WHERE email = '$verifyemail'";
        $emailCheckResult = mysqli_query($conn, $emailCheckQuery);

        if(mysqli_num_rows($emailCheckResult) > 0) {
            echo "<script> alert('Email already exists in the patron account database.'); </script>";
        } 
        else {
            // Continue with the INSERT query if the email does not exist
            $insertquery = "INSERT INTO patron_acc (email, password, pt_name, course) VALUES ('$verifyemail', '$password', '$name', '$course')";

            // Execute the INSERT query
            if (mysqli_query($conn, $insertquery)) {

                // Delete the row in account_approval where email = $verifyemail
                $deletequery = "DELETE FROM account_approval WHERE email = '$verifyemail'";
                
                // Execute the DELETE query
                if (mysqli_query($conn, $deletequery)) {
                    // Empty the session variables
                    unset($_SESSION["verifyemail"]);
                    unset($_SESSION["resend"]);

                    echo "<script> alert('Account Verification Successful!! You May Now Log In.'); </script>";
                    
                    header("Location: login.php");
                }

            } else {
                echo "<script> alert('Error inserting record: " . mysqli_error($conn) . "'); </script>";
            }


        }
    }
    else{
        echo "<script> alert('Verificaiton Code Does Not Match.'); </script>";
    }
}


    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Page</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #e2f1fc; 
        }

        .modal {
            background-color: #ffffff; 
            border-radius: 50px;
            padding: 80px;
            padding-top: 50px;
            text-align: center;
            width: 90vw; 
            max-width: 500px; 
            margin: 5%;
        }

        input {
            width: 50%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: left;
            display: block; 
            margin: 0; 
        }

        button {
            background-color: #4caf50; 
            color: #ffffff;
            padding: 15px 0; 
            width: 200px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            display: flex; 
            justify-content: center; 
            align-items: center; 
            margin: 0 auto; 
        }

        .resend-code {
            font-size: 14px;
            color: #5ab2db;
            text-decoration: underline;
            cursor: pointer;
            text-align: left;
            display: block; 
            margin-top: 10px; 
            font-family: Arial, Helvetica, sans-serif;
        }

        @media screen and (max-width: 768px) {      
            .modal {
                padding: 10px; 
            }
            button {
                margin: 20px auto 50px; 
            }
        }

    </style>
</head>
<body>

    <div class="modal">
        <h2 style="font-size: 36px;font-family: Arial, Helvetica, sans-serif; ">ACCOUNT VERIFICATION</h2>
        <?php
            if(!empty($_SESSION["resend"])){
                echo"
                <p style = 'margin-bottom: 15px;font-family: Arial, Helvetica, sans-serif;'><b>Verification code resent.</b></p>
                ";
            }
        ?>
        <p style = "margin-bottom: 15px;font-family: Arial, Helvetica, sans-serif;">SCRIBE sent a verification code to <b><?php echo $verifyemail ?></b> for verification.</p>
        <p style = "margin-bottom: 25px;font-family: Arial, Helvetica, sans-serif;">Please check your inbox and enter the verification code below to verify your email address.</p>
        
        <form action="" method="post" autocomplete="off">
            <input class="input-verificationCode format" type="text" placeholder="Verification Code" id="verificationCode" name="verificationCode" required>
            <a class="resend-code" href="resendcode.php">Didn't receive the code? Resend Code</a>
            <br>
            <button class="submit-button format" type="submit" value="SUBMIT" id="verify" name="verify">SUBMIT</button>
        </form>
    </div>

</body>

</html>