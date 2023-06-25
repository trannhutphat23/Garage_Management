<?php
    require '../../login-form/connect.php'; 

    if (isset($_POST['add-new'])){
        if (isset($_GET['id'])){
            $id = $_GET['id'];
    
            $queryKH = mysqli_query($conn,"SELECT MaKH, MaHieuXe FROM phieusuachua, xe WHERE phieusuachua.BienSo = xe.BienSo AND SoPhieuSC = $id");
            $getKH = mysqli_fetch_row($queryKH);
            $resKH = $getKH[0]; //MaKH
            $resHX = $getKH[1]; //MaHieuXe
            
        }
        $conn->query("SET foreign_key_checks = 0");

        if (isset($_POST['owner-name']) || isset($_POST['address']) || isset($_POST['phone']) || isset($_POST['licensePlate']) || isset($_POST['car-brand'])){
            if (isset($_POST['owner-name'])){
                $owner_name = $_POST['owner-name'];
                $conn->query("UPDATE khachhang SET TenKH = '$owner_name' WHERE MaKH = $resKH");
                // header("Location: detail.php?id=$id");
            } 
            
            if (isset($_POST['address'])){
                $address = $_POST['address'];
                $conn->query("UPDATE khachhang SET DiaChi = '$address' WHERE MaKH = $resKH");
                // header("Location: detail.php?id=$id");
            } 
            if (isset($_POST['phone'])){
                $phone = $_POST['phone'];
                $conn->query("UPDATE khachhang SET DienThoai = '$phone' WHERE MaKH = $resKH");
                // header("Location: detail.php?id=$id");
            } 
            if (isset($_POST['car-brand'])){
                $carbrand = $_POST['car-brand'];
                $conn->query("UPDATE hieuxe SET TenHieuXe = '$carbrand' WHERE MaHieuXe = $resHX");
                // header("Location: detail.php?id=$id");
            }
            
        }
        $conn->query("SET foreign_key_checks = 1");
    }      
    header("Location: detail.php?id=$id");
    
?>