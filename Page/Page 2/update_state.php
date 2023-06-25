<?php
    require '../../login-form/connect.php'; 

    if (isset($_GET['id'])){
        $id = $_GET['id'];
        if (isset($_POST['confirm'])){
            $conn->query("UPDATE phieutiepnhan SET TinhTrang = 'Đã sửa chữa' WHERE BienSo = '$id'");
        }
    }
    header("Location: repair.php");
?>