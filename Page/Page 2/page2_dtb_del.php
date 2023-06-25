<?php
    require '../../login-form/connect.php'; 
    if (isset($_COOKIE['getInfo'])){
        $getInfo=$_COOKIE['getInfo'];
    }
    $querySupplier = mysqli_query($conn,"SELECT ID_PERMISSION FROM user, user_info WHERE user.USER_ID = user_info.ID_USER AND INFO_NAME = '$getInfo'");
    $getSupplierID = mysqli_fetch_row($querySupplier);
    $resSupplierID = $getSupplierID[0]; //MaNCC
    if (isset($_GET['id'])) {
        $id=$_GET['id']; //BienSo

        if ($resSupplierID == 2){
            echo "<script> alert('Không được xóa'); window.location.href='page2.php?id=$id'</script>";
        }else{
            $query = mysqli_query($conn,"SELECT TinhTrang FROM phieutiepnhan WHERE BienSo='$id'");
            $get = mysqli_fetch_assoc($query);
            $res = $get['TinhTrang']; //TinhTrang
            if ($res == "Chưa sửa chữa"){
                echo "<script> alert('Khách hàng đang sửa chữa'); window.location.href='page2.php?id=$id'</script>";
            }else{
                $queryCus = mysqli_query($conn,"SELECT MaKH FROM xe WHERE BienSo = '$id'");
                $getCus = mysqli_fetch_row($queryCus);
                $resCus = $getCus[0]; // MaKH
        
                $conn->query("SET foreign_key_checks = 0");                
                $conn->query("DELETE FROM phieutiepnhan WHERE BienSo ='$id'");  

                $conn->query("DELETE FROM phieusuachua WHERE BienSo ='$id'");  
                
                $conn->query("SET foreign_key_checks = 1");
                header("Location: page2.php");
            }
        }
    }
?>

