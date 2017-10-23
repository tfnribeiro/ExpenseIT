<?php
    /*  Code: Tiago Ribeiro, 18/10/2017
        . Logs out an user, by releasing all his variables.
    */
    include "connect.php";
    session_unset();
    $conn->close();
    header("Location: ../index.php?error=4");
    exit();
?>