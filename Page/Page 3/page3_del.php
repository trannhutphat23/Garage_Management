<?php
    require '../../login-form/connect.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $strSQL = "SELECT SoLuong, MaVTPT FROM ct_phieunhapvtpt WHERE MaVTPT = $id";
        $resSQL=mysqli_query($conn,$strSQL);
        $get_array=mysqli_fetch_assoc($resSQL);
        $getNumSupplies=$get_array['SoLuong'];
        $getSuppliesID=$get_array['MaVTPT'];
        
        $strsql="SELECT sum(SoLuong) AS SL FROM ct_phieunhapvtpt WHERE MaVTPT=$id";
        $resSQL=mysqli_query($conn,$strsql);
        $get_array=mysqli_fetch_assoc($resSQL);
        $getNum=$get_array['SL']; //SoLuong
        $conn->query("SET foreign_key_checks = 0");
        $conn->query("DELETE FROM ct_phieunhapvtpt WHERE MaVTPT = $id");
        $conn->query("UPDATE baocaoton SET PhatSinh = PhatSinh - $getNum, TonCuoi = TonCuoi - $getNum WHERE MaVTPT = '$getSuppliesID'");

        $conn->query("UPDATE ct_phieunhapvtpt SET SoPhieuNhap = SoPhieuNhap - 1 WHERE SoPhieuNhap > '$id'");

        $conn->query("UPDATE vtpt SET TonKho = TonKho - $getNumSupplies WHERE MaVTPT = $getSuppliesID");
        $conn->query("SET foreign_key_checks = 1");
    }
    header("Location: page3.php");
?>