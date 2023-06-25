<?php
    $servername="localhost";
    $username="root";
    $password="";
    $dtbname="quanlygara";

    $conn = new mysqli($servername, $username, $password, $dtbname);
    if ($conn->connect_error) {
        die("Kết nối thất bại: ".$conn->connect_error);
    }
?>