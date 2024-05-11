<?php
require 'config.php';

date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippines
$currentDateTime = date('Y-m-d H:i:s');

date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippines
$currentDate = new DateTime();

$accID = $_POST['email'];

if(substr($accID, -15) == "@adamson.edu.ph"){
    $sql = "SELECT pt_name, patronID FROM patron_acc WHERE email = '$accID'";
    $result2 = mysqli_query($conn, $sql);
    $row2 = mysqli_fetch_assoc($result2);
    $patronID = $row2['patronID'];

    $duplicateEmail = mysqli_query($conn, "SELECT pt_entry FROM patron_attendance WHERE patronID = '$patronID' AND pt_exit IS NULL");
    if(mysqli_num_rows($duplicateEmail) > 0){
        $sql = "UPDATE patron_attendance SET pt_exit = '$currentDateTime' WHERE patronID = $patronID AND pt_exit IS NULL";
        $result = mysqli_query($conn, $sql);
        echo json_encode("<b>Name: $row2[pt_name] <br> Time Out: $currentDateTime");
    }
    else {
        $sql = "INSERT INTO patron_attendance(patronID, pt_entry) VALUES('$patronID','$currentDateTime')";
        $result = mysqli_query($conn, $sql);
        echo json_encode("<b>Name: $row2[pt_name] <br> Time In: $currentDateTime");
    }
}
else{
    $sql = "SELECT name, librarianID FROM lib_acc WHERE email = '$accID'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $librarianId = $row['librarianID'];

    $duplicateEmail = mysqli_query($conn, "SELECT lib_entry FROM lib_attendance WHERE librarianID = '$librarianId' AND lib_exit IS NULL");
    if(mysqli_num_rows($duplicateEmail) > 0){
        $sql = "UPDATE lib_attendance SET lib_exit = '$currentDateTime' WHERE librarianID = $librarianId AND lib_exit IS NULL";
        $result = mysqli_query($conn, $sql);
        echo json_encode("<b>Name: $row[name] <br> Time Out: $currentDateTime");
    }
    else {
        $sql = "INSERT INTO lib_attendance(librarianID, lib_entry) VALUES('$librarianId','$currentDateTime')";
        $result = mysqli_query($conn, $sql);
        echo json_encode("<b>Name: $row[name] <br> Time In: $currentDateTime");
    }
}


// if ($row['lib_entry']) {
    
// } else {
//     $sql = "INSERT INTO lib_attendance(librarianID, lib_entry) VALUES('$librarianId','$currentDateTime')";
//     $result = mysqli_query($conn, $sql);
// }

// $sql = "INSERT INTO lib_attendance(librarianID, lib_entry) VALUES('$librarianId','$currentDateTime')";
// $result = mysqli_query($conn, $sql);

// if ($row) {
//     // If a row is found, echo the data as JSON
//     echo json_encode($row);
// } else {
//     // If no matching record found, echo appropriate message
//     echo json_encode(['error' => 'No matching record found']);
// }
?>