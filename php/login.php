<?php

include "connect.php";

//$conn provides the link to the database
print_r($_POST);
$email = $_POST['email'];
$pass = hash("sha256", $_POST['psw']); 

$sql = $conn->prepare('SELECT * FROM USER WHERE EMAIL=?');
$sql->bind_param('s', $email);
$sql->execute();

$result = $sql->get_result();

$num_of_rows = $result->num_rows;

// Error code:
// 1. Password is Wrong
// 2. Email doesn't exist
// 3. Login session not found
// 4. User logs out

if($num_of_rows > 0){
    $row = $result->fetch_array();
    echo($row['Password']);
    if($row['Password']==$pass){
        //Set Session Variables
        $_SESSION['username']=$row['Username'];
        $_SESSION['email']=$row['Email'];
        $_SESSION['id']=$row['idUser'];
        $conn->close();
        header("Location: ../expense.php");
        exit();
    }
    else{
        $conn->close();
        header("Location: ../index.php?error=1");
        exit();
    }   
}
else{
    $conn->close();
    header("Location: ../index.php?error=2");
    exit();
}

?>