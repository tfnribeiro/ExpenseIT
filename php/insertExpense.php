<?php

include "connect.php";
/*Get type ID*/
$id = $_SESSION['id'];
$type = $_POST['type'];
$query="SELECT IDType FROM TYPE WHERE User_idUser='$id' AND TYPE='$type'";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$type = $row['IDType'];
// --
$amount = $_POST['amount'];
//Check if date is null, if so we set it to the date in the system;
if($_POST['date'] == ""){
    $date =  date("Y-m-d");
}
else{
    $date = $_POST['date'];
}
$description = $_POST['description'];
print_r($_POST);
echo("THIS IS " . $amount . "<br>" . $type . "<br>" . $date);
echo("<br> Hvad?");
$sql = $conn->prepare('INSERT INTO EXPENSE (PRICE, Type_User_idUser, Type_IDType, DATE, DESCRIPTION) VALUES(?,?,?,?,?)');
$sql->bind_param('diiss', $amount, $id, $type, $date, $description);
$sql->execute();

$conn->close();
header("Location: ../expense.php");


?>
