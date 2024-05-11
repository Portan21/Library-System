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

if(isset($_GET["rejreq"]) && isset($_GET["rejbook"])){
    $rejreq = $_GET["rejreq"];
    $rejbook = $_GET["rejbook"];
    
    //DELETE FROM book_request
    $delquery = "DELETE FROM book_request WHERE patronID = $rejreq AND bookID = $rejbook";
    //Exec query
    if(mysqli_query($conn, $delquery)){
        
        $updatequery = "UPDATE book SET availability = '1' WHERE bookID = '$rejbook'";
        if (mysqli_query($conn, $updatequery)) {
            // The update was successful
        }

        echo "<script> alert('DELETE SUCCESSFUL'); </script>";
    }
    else{
        echo"<script>alert('DELETING ERROR');</script>";
    }
    
}

header("location: request.php");
exit;
?>