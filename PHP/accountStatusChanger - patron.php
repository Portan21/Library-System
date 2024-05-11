<?php
require 'config.php';

$ID = $_POST['ID'];

$result = mysqli_query($conn, "SELECT status FROM patron_acc WHERE patronID = '$ID'");
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) > 0 && $row['status'] == 1){
    $sql = "UPDATE patron_acc SET status = 2 WHERE patronID = '$ID'";
    $result = mysqli_query($conn, $sql);
}
else{
    $sql = "UPDATE patron_acc SET status = 1 WHERE patronID = '$ID'";
    $result = mysqli_query($conn, $sql);
}
?>