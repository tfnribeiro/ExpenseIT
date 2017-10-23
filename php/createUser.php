<?php

include "connect.php";
//$conn provides the link to the database
print_r($_POST);
$name = $_POST['username'];
$pass = hash("sha256", $_POST['psw']);
$pass2 = hash("sha256", $_POST['pswC']); 
$email = $_POST['email'];

// Error on Logins:
//  1. Password not match
if($pass!=$pass2){
    $conn->close();
    header("Location: ../newUser.php?error=1");
    exit();
}
//  2. Email exists on the database
$sql = $conn->prepare('SELECT * FROM USER WHERE EMAIL=?');
$sql->bind_param('s', $email);
$sql->execute();

$result = $sql->get_result();

$num_of_rows = $result->num_rows;

if($num_of_rows > 0){
    $conn->close();
    header("Location: ../newUser.php?error=2");
    exit();
}
//  0. If it doesn't fail, then we can proceed to insert the values
$sql = $conn->prepare('INSERT INTO USER (Username, Password, Email) VALUES(?,?,?)');
$sql->bind_param('sss', $name, $pass, $email);
$sql->execute();
$lastId = $conn->insert_id;
echo($lastId);
echo gettype($lastId);
// Default Types: 
// . Shopping
// . Leasure
// . Housing
$sql2 = $conn->prepare('INSERT INTO TYPE (Type, User_idUser) VALUES(?,?)');
$sql2->bind_param('si', $type, $lastId);
$type = "Shopping";
$sql2->execute();
$type = "Leasure";
$sql2->execute();
$type = "Housing";
$sql2->execute();


$conn->close();
header("Location: ../index.php?error=0");
exit();
?>