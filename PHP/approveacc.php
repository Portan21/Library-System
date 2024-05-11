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

if(isset($_GET["appacc"])){
    $appacc = $_GET["appacc"];

    //INSERT VALUE to account
    $appquery = "INSERT INTO account (IDnumber, email, password, first_name, last_name, typeID)
    SELECT IDnumber, email, password, first_name, last_name, 4
    FROM account_approval 
    WHERE IDnumber = $appacc";

    //Execute the query
    if(mysqli_query($conn, $appquery)){

        //DELETE FROM account_approval
        $delquery = "DELETE FROM account_approval WHERE IDnumber = $appacc";
        //Exec query
        if(mysqli_query($conn, $delquery)){
        }
        else{
            echo"<script>alert('DELETING ERROR');</script>";
        }
    }
    else{
        echo "<script>alert('INSERTING ERROR');</script>";
    }
}

header("location: approval.php");
exit;

?>