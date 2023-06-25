<?php
    require 'login-form/connect.php';

    if (isset($_POST['update_button'])){
        $check1=0;
        $check2=0;
        $check3=0;
        $check4=0;
        $check5=0;

        $slcarBrand="SELECT * FROM hieuxe";
        $reccarBrand=mysqli_num_rows(mysqli_query($conn,$slcarBrand));

        $slvtpt="SELECT * FROM vtpt";
        $recvtpt=mysqli_num_rows(mysqli_query($conn,$slvtpt));

        $sltiencong="SELECT * FROM tiencong";
        $rectiencong=mysqli_num_rows(mysqli_query($conn,$sltiencong));
        if ($_POST['numCaraDay']!=NULL){
            $query = mysqli_query($conn,"SELECT max(SL) as SlMax FROM (SELECT COUNT(*) as SL FROM phieutiepnhan GROUP BY NgayTiepNhan) as GetSL");
            $get = mysqli_fetch_row($query);
            $getSlMax = $get[0];

            $numCaraDay = $_POST['numCaraDay'];
            if ($numCaraDay >= $getSlMax){
                $conn->query("UPDATE thamso SET SoXeNhanToiDa=$numCaraDay");
                $check1=1;
            }else{
                echo "<script> alert('Số xe nhận trong ngày đang lớn hơn giá trị vừa nhập'); window.location.href='index.php'</script>";
            }
        }    
        if ($_POST['numRate']!=NULL){
            $numRate = $_POST['numRate'];
            $conn->query("UPDATE thamso SET TiLeTinhDonGiaBan=$numRate");
            $check2=1;
        }
        if ($_POST['maxCar']!=NULL){
            if ($_POST['maxCar'] >= $reccarBrand){
                $maxCar = $_POST['maxCar'];
                $conn->query("UPDATE thamso SET SoLuongHieuXe=$maxCar");
                $check3=1;
            }else{
                echo "<script> alert('Số hiệu xe hiện tại lớn hơn giá trị vừa nhập'); window.location.href='index.php'</script>";
            }
        }
        if ($_POST['numSupply']!=NULL){
            if ($_POST['numSupply'] >= $recvtpt){
                $numSupply = $_POST['numSupply'];
                $conn->query("UPDATE thamso SET SoLuongVTPT=$numSupply");
                $check4=1;
            }else{
                echo "<script> alert('Số loại vật tư hiện tại lớn hơn giá trị vừa nhập'); window.location.href='index.php'</script>";
            }
        }
        if ($_POST['numCost']!=NULL){
            if ($_POST['numCost'] >= $rectiencong){
                $numCost = $_POST['numCost'];
                $conn->query("UPDATE thamso SET SoLuongTienCong=$numCost");
                $check5=1;
            }else{
                echo "<script> alert('Số loại tiền công hiện tại lớn hơn giá trị vừa nhập'); window.location.href='index.php'</script>";
            }
        }
        if ($check1==0 && $check2==0 && $check3==0 && $check4==0 && $check5==0){
            echo "<script> alert('Cập nhật không thành công'); window.location.href='index.php'</script>";
        }else{
            echo "<script> alert('Cập nhật thành công'); window.location.href='index.php'</script>";
        }   
    }
?>