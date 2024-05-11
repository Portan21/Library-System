<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/qrcodereader.css">
    <script defer src="../JavaScript/bootstrap.bundle.min.js"></script>
    <script defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script defer src="../JavaScript/html5-qrcode-min.js"></script>
    <script defer src="../JavaScript/qrcodeReader.js"></script>
    <title>QRReader</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row reader">
            <div class="reader-side col-lg-3">
            </div>
            <div class="reader-form col-lg-6 rounded-5 border-0 shadow">
                <div class="col-lg-8 reader-frame">
                    <div id="reader" width="600px"></div>
                    <div id="scannedName"><b>Name: 
                    </div>
                </div>
            </div>
            <div class="reader-side col-lg-3">
            </div>
        </div>
    </div>
</body>
</html>
