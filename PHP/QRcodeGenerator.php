<?php 
require 'config.php';

if(isset($_POST["login"])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM account WHERE email = '$email'");
    $row = mysqli_fetch_assoc($result);

    if(mysqli_num_rows($result) > 0){
        if(password_verify($password, $row["password"])){
            $_SESSION["login"] = true;
            $_SESSION["accountID"] = $row["accountID"];
            $_SESSION["idnumber"] = $row["idnumber"];
            $_SESSION["email"] = $row["email"];
            $_SESSION["first_name"] = $row["first_name"];
            $_SESSION["last_name"] = $row["last_name"];
            $_SESSION["typeID"] = $row["typeID"];
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
    <link rel="stylesheet" href="../CSS/qrcodegenerator.css">
    <script defer src="../JavaScript/bootstrap.bundle.min.js"></script>
    <script defer src="../JavaScript/qrcodeGenerator.js"></script>
    <title>QRGenerator</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row qr">
            <div class="qr-side col-lg-3">
            </div>
            <div class="qr-form col-lg-6 rounded-5 border-0 shadow">
                <div class="col-lg-8 qr-frame">

                    <div class="row qr-text d-flex justify-content-center">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <p id="qr-name" class="qr-sign"><?php echo $_SESSION["first_name"], " " ,$_SESSION["last_name"]; ?></p>
                        </div>
                    </div>

                    <div class="row qr-image d-flex justify-content-center">
                        <div class="col-lg-3 d-flex justify-content-center">
                            <img src="" id="qrcode">
                        </div>
                    </div>
                    
                    <div class="row download-container d-flex justify-content-center">
                        <div class="col-lg-3 d-flex justify-content-center">
                            <a download href="https://api.qrserver.com/v1/create-qr-code/?size=[250]x[250]&data=<?php echo $_SESSION["first_name"], " " ,
                            $_SESSION["last_name"]; ?>&download=1">
                            <input class="download-button format" type="submit" value="DOWNLOAD QR">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="qr-side col-lg-3">
            </div>
        </div>
    </div>
</body>
</html>
