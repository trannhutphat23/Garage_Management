<?php
    require '../../login-form/connect.php'; 

    if (isset($_GET['id'])){
        $id = $_GET['id'];
        if (isset($_POST['click_new'])){
            $money = $_POST['money'];
    
            $sl="SELECT * FROM phieuthutien";
            $rec_row=mysqli_num_rows(mysqli_query($conn,$sl));
            $rec_row++;
    
            $queryTong = mysqli_query($conn,"SELECT TienNo FROM ct_phieusuachua, phieusuachua, xe WHERE ct_phieusuachua.SoPhieuSC=phieusuachua.SoPhieuSC AND xe.BienSo = phieusuachua.BienSo AND xe.BienSo = '$id'");
            $getTong = mysqli_fetch_assoc($queryTong);
            $resTong = $getTong['TienNo']; //TienNo

            $queryMaHX = mysqli_query($conn,"SELECT MaHieuXe FROM xe WHERE BienSo = '$id'");
            $getMaHX = mysqli_fetch_row($queryMaHX);
            $resMaHX = $getMaHX[0]; // MaHieuXe

            $queryLuotSua = mysqli_query($conn,"SELECT count(*) as SoLuotSua FROM phieusuachua WHERE BienSo='$id'");
            $getLuotSua = mysqli_fetch_row($queryLuotSua);
            $resLuotSua = $getLuotSua[0]; // SoLuotSua

            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $rec_date = date('Y-m-d h:i:s a', time());
            $year = date('Y', time());
            $year_int = (int)$year;
            $month = date('m', time());
            $month_int = (int)$month;

            $queryMaVTPTDS = "SELECT * FROM baocaodoanhthu WHERE MaHieuXe='$resMaHX' AND $month_int = MONTH(Thang_Nam) AND $year_int = YEAR(Thang_Nam)";
            $rec_rowbcdoanhso=mysqli_num_rows(mysqli_query($conn,$queryMaVTPTDS));
    
            if ($money <= $resTong){
                $conn->query("SET foreign_key_checks = 0");
                $conn->query("INSERT INTO phieuthutien VALUES('$rec_row', '$id', '$money', '$rec_date')");
                $conn->query("UPDATE xe SET TienNo = TienNo - $money WHERE BienSo = '$id'");
                if ($rec_rowbcdoanhso==0){
                    $conn->query("INSERT INTO baocaodoanhthu VALUES('$rec_date', '$resMaHX', 0,'$resLuotSua', '$money', 0)");
                }else{

                    $conn->query("UPDATE baocaodoanhthu SET ThanhTien = ThanhTien + $money, SoLuotSua = SoLuotSua + 1 WHERE MaHieuXe = $resMaHX AND $month_int = MONTH(Thang_Nam) AND $year_int = YEAR(Thang_Nam)");
                }
                $conn->query("SET foreign_key_checks = 1");
                header("Location: payment.php?id=$id");
            } else{
                echo "<script> alert('Số tiền thanh toán lớn hơn số tiền nợ'); window.location.href='payment.php?id=$id'</script>";
            }
        }
    }
?>