<?php
require 'config.php';
if(!empty($_SESSION["accountID"])){
    $id = $_SESSION["accountID"];
}
else{
    header("Location: login.php");
}

if($_SESSION["typeID"] == 4){
    header("Location: catalog.php");
}

if(isset($_GET["rejacc"])){
    $rejacc = $_GET["rejacc"];
    
    //DELETE FROM account_approval
    $delquery = "DELETE FROM account_approval WHERE IDnumber = $rejacc";
    //Exec query
    if(mysqli_query($conn, $delquery)){
    }
    else{
        echo"<script>alert('DELETING ERROR');</script>";
    }
    
}

header("location: approval.php");
exit;
?>