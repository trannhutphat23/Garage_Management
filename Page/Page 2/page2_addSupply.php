<?php
    require '../../login-form/connect.php'; 
    // && isset($_POST['nameSupply']) && isset($_POST['amountSupply']) && isset($_POST['nameCost'])
    if (isset($_POST['myID']) || isset($_POST['nameSupply']) || isset($_POST['amountSupply']) || isset($_POST['nameCost'])){
        $id=$_POST['myID'];
        $nameSupply = $_POST['nameSupply'];
        $amountSupply = $_POST['amountSupply'];
        $nameCost = $_POST['nameCost'];

        // if ($nameSupply!=NULL){
            // $querySupplies = mysqli_query($conn,"SELECT MaVTPT, DonGiaBan FROM vtpt WHERE TenVTPT = '$nameSupply'");
            // $getSuppliesID = mysqli_fetch_row($querySupplies);
            // $resSuppliesID = $getSuppliesID[0]; // MaVTPT
            // $resSuppliesCost = $getSuppliesID[1]; // DonGiaBan
        // }

        // if ($nameCost!=NULL){
            // $queryCost = mysqli_query($conn,"SELECT MaTC, GiaTienCong FROM tiencong WHERE TenTienCong = '$nameCost'");
            // $getCostID = mysqli_fetch_row($queryCost);
            // $resCostID = $getCostID[0]; // MaTC
            // $resCost = $getCostID[1]; //GiaTienCong
        // }
        // $conn->query("INSERT INTO ct_phieusuachua values('$id','$resSuppliesID','$resCostID','$amountSupply',0)");
        
        // $Tien = $amountSupply * $resSuppliesCost + $resCost;
        // $slImport="SELECT * FROM ct_phieunhapvtpt WHERE MaVTPT = $resSuppliesID";
        // $rec_row=mysqli_num_rows(mysqli_query($conn,$slImport));
        // if ($rec_row==0){
            //     echo "<script> alert('Mặt hàng chưa được nhập kho'); window.location.href='page2.php'</script>";
            // } 
            // else{
                //     $conn->query("SET foreign_key_checks = 0");
                //     $conn->query("INSERT INTO ct_phieusuachua VALUES ('$id', '$resSuppliesID', '$resCostID', '$amountSupply','$Tien')");
                //     $conn->query("UPDATE baocaoton SET PhatSinh = PhatSinh - $amountSupply, TonCuoi = TonCuoi - $amountSupply WHERE MaVTPT = $resSuppliesID");
                //     $conn->query("SET foreign_key_checks = 1");
                // }
        // echo "hello";
    }
    // header("Location: page2.php");
?>