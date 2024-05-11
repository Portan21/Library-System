<?php
require 'config.php';

error_reporting(E_ERROR | E_PARSE); // Report only errors and parse errors
ini_set('display_errors', 0); // Do not display errors on the screen

$ID = $_POST['ID'];

$result = mysqli_query($conn, "SELECT typeID, COUNT(typeID) AS count FROM lib_acc WHERE librarianID = '$ID' GROUP BY typeID");
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) > 0 && $row['typeID'] == 2){
    $sql = "UPDATE lib_acc SET typeID = 3 WHERE librarianID = '$ID'";
    $result = mysqli_query($conn, $sql);
}
else{
    $result2 = mysqli_query($conn, "SELECT typeID, COUNT(typeID) AS count FROM lib_acc WHERE typeID = '2' GROUP BY typeID");
    $row2 = mysqli_fetch_assoc($result2);
    if($row2['count'] == 1){
        $result2 = "You can set 1 Head Librarian only";
        echo json_encode($result2);
    }
    else{
        $sql = "UPDATE lib_acc SET typeID = 2 WHERE librarianID = '$ID'";
        $result = mysqli_query($conn, $sql);
    }
}
?>