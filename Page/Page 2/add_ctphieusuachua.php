<?php
    require '../../login-form/connect.php'; 

    if (isset($_GET['id'])){
        $id = $_GET['id'];
        if (isset($_POST['add-new'])){
            $supplyName = $_POST['selectSupply'];
            $amountSupply = $_POST['amount'];
            $costName = $_POST['selectCost'];

            $strsql="SELECT TiLeTinhDonGiaBan FROM thamso";
            $resSQL=mysqli_query($conn,$strsql);
            $get_array=mysqli_fetch_assoc($resSQL);
            $getRate=$get_array['TiLeTinhDonGiaBan'];

            $querySupplies = mysqli_query($conn,"SELECT MaVTPT, DonGiaBan FROM vtpt WHERE TenVTPT = '$supplyName'");
            $getSuppliesID = mysqli_fetch_row($querySupplies);
            $resSuppliesID = $getSuppliesID[0]; // MaVTPT
            $resSuppliesCost = $getSuppliesID[1]; // DonGiaBan

            $queryCost = mysqli_query($conn,"SELECT MaTC, GiaTienCong FROM tiencong WHERE TenTienCong = '$costName'");
            $getCostID = mysqli_fetch_row($queryCost);
            $resCostID = $getCostID[0]; // MaTC
            $resCost = $getCostID[1]; //GiaTienCong

            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $rec_date = date('Y-m-d h:i:s a', time());
            $query_SP = "SELECT SoPhieuSC FROM phieusuachua WHERE BienSo = '$id'";
            if (mysqli_num_rows(mysqli_query($conn,$query_SP)) > 0){
                $querySoPhieu = mysqli_query($conn,"SELECT SoPhieuSC FROM phieusuachua WHERE BienSo = '$id'");
                $getSoPhieu = mysqli_fetch_row($querySoPhieu);
                $resSoPhieu = $getSoPhieu[0];  // get SoPhieuSC
            }

            $selImport="SELECT * FROM ct_phieunhapvtpt WHERE MaVTPT=$resSuppliesID";
            $rec_rowImport=mysqli_num_rows(mysqli_query($conn,$selImport));
            if ($rec_rowImport!=0){
                $queryNumvtpt = mysqli_query($conn,"SELECT sum(SoLuong) as SL FROM ct_phieunhapvtpt WHERE MaVTPT=$resSuppliesID GROUP BY MaVTPT");
                $getNumvtpt = mysqli_fetch_row($queryNumvtpt);
                $resNumvtpt = $getNumvtpt[0]; // Num VTPT
            }else{
                echo "<script> alert('Mặt hàng này chưa được nhập kho'); window.location.href='detail_repair.php?id=$id'</script>";
            }

            $selRepair="SELECT * FROM ct_phieusuachua";
            $rec_rowRepair=mysqli_num_rows(mysqli_query($conn,$selRepair));
            if ($rec_rowRepair!=0){
                $queryNumvtptNew = mysqli_query($conn,"SELECT sum(SoLuong) as SL FROM ct_phieusuachua WHERE MaVTPT=$resSuppliesID GROUP BY MaVTPT");
                $getNumvtptNew = mysqli_fetch_row($queryNumvtptNew);
                $resNumvtptNew = $getNumvtptNew[0]; // Num VTPT New
                $query = mysqli_query($conn,"SELECT * FROM ct_phieusuachua WHERE SoPhieuSC = $rec_rowRepair");
                $get = mysqli_fetch_row($query);
                $resvt = $get[1];
                $restc = $get[2];
            } else{
                $resNumvtptNew=0;
                $resvt=0;
                $restc=0;
            }

            $Tien = $amountSupply * $resSuppliesCost + $resCost;
            $slImport="SELECT * FROM ct_phieunhapvtpt WHERE MaVTPT = $resSuppliesID";
            $rec_row=mysqli_num_rows(mysqli_query($conn,$slImport));
            if ($rec_row==0){
                echo "<script> alert('Mặt hàng chưa được nhập kho'); window.location.href='detail_repair.php?id=$id'</script>";
            } 
            else if ($resNumvtpt < $resNumvtptNew + $amountSupply){
                echo "<script> alert('Hãy nhập thêm hàng'); window.location.href='detail_repair.php?id=$id'</script>";
            }
            else{
                $selRepairNum="SELECT * FROM ct_phieusuachua, phieusuachua WHERE ct_phieusuachua.SoPhieuSC = phieusuachua.SoPhieuSc AND MaVTPT = $resSuppliesID AND MaTC = $resCostID AND phieusuachua.SoPhieuSC = $rec_rowRepair AND BienSo = '$id'";
                $rec_rowRepairNum=mysqli_num_rows(mysqli_query($conn,$selRepairNum));
                if ($rec_rowRepairNum!=0){
                    echo "<script> alert('Tiền công đã tồn tại'); window.location.href='detail_repair.php?id=$id'</script>";
                }else{
                    $conn->query("SET foreign_key_checks = 0");
                    if($resSuppliesID == $resvt && $resCostID != $restc){
                        $rec_rowRepair++;
                        $conn->query("INSERT INTO ct_phieusuachua VALUES ('$resSoPhieu', '$resSuppliesID', '$resCostID', '$amountSupply','$Tien')");
                        $conn->query("UPDATE xe SET TienNo = TienNo + $Tien WHERE BienSo = '$id'");
                        $conn->query("UPDATE phieusuachua SET NgaySuaChua = '$rec_date' WHERE BienSo = '$id'");
                    }
                    else if($resSuppliesID == $resvt && $resCostID == $restc){
                        $conn->query("UPDATE ct_phieusuachua SET SoLuong = SoLuong + $amountSupply, ThanhTien = ThanhTien + $Tien WHERE MaVTPT = $resvt AND MaTC = $restc");
                        $conn->query("UPDATE xe SET TienNo = TienNo + $Tien WHERE BienSo = '$id'");
                        $conn->query("UPDATE phieusuachua SET NgaySuaChua = '$rec_date' WHERE BienSo = '$id'");
                    }
                    else{
                        $rec_rowRepair++;
                        $conn->query("INSERT INTO ct_phieusuachua VALUES ('$resSoPhieu', '$resSuppliesID', '$resCostID', '$amountSupply','$Tien')");
                        $conn->query("UPDATE xe SET TienNo = TienNo + $Tien WHERE BienSo = '$id'");
                        $conn->query("UPDATE phieusuachua SET NgaySuaChua = '$rec_date' WHERE BienSo = '$id'");
                    }
                    $conn->query("UPDATE baocaoton SET SuDung = SuDung + $amountSupply, TonCuoi = TonCuoi - $amountSupply WHERE MaVTPT = $resSuppliesID");
                    $conn->query("UPDATE vtpt SET TonKho = TonKho - $amountSupply WHERE MaVTPT = $resSuppliesID");
                    $conn->query("SET foreign_key_checks = 1");
                    header("Location: detail_repair.php?id=$id");
                }
            }
        }
    }
?>

