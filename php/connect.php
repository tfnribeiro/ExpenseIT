<?php 
    session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "expensedatabase";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    echo "Connected successfully";

?>