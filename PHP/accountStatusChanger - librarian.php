<?php
require 'config.php';

$ID = $_POST['ID'];

$result = mysqli_query($conn, "SELECT status FROM lib_acc WHERE librarianID = '$ID'");
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) > 0 && $row['status'] == 1){
    $sql = "UPDATE lib_acc SET status = 2 WHERE librarianID = '$ID'";
    $result = mysqli_query($conn, $sql);
}
else{
    $sql = "UPDATE lib_acc SET status = 1 WHERE librarianID = '$ID'";
    $result = mysqli_query($conn, $sql);
}
?>