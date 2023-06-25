<?php 
   require '../../login-form/connect.php';

   if (isset($_GET['id'])){
    $id = $_GET['id'];

    $queryCus = mysqli_query($conn,"SELECT BienSo, SoLuong, MaVTPT FROM ct_phieusuachua, phieusuachua WHERE ct_phieusuachua.SoPhieuSC = phieusuachua.SoPhieuSC AND ct_phieusuachua.SoPhieuSC = $id");
    $getCus = mysqli_fetch_row($queryCus);
    $resCus = $getCus[0]; 
    $resNum = $getCus[1]; 
    $resVTPT = $getCus[2]; 
    $query1 = mysqli_query($conn,"SELECT ThanhTien FROM ct_phieusuachua WHERE ct_phieusuachua.SoPhieuSC = $id");
    $getCus1 = mysqli_fetch_row($query1);
    $resCus1 = $getCus1[0];

    $sl="SELECT * FROM phieuthutien WHERE BienSo = '$resCus'";
    $rec_row=mysqli_num_rows(mysqli_query($conn,$sl));
    if ($rec_row > 0){
        echo "<script> alert('Không thể xóa!'); window.location.href='detail.php?id=$id'</script>";
    }else{
        $conn->query("UPDATE xe SET TienNo = TienNo - $resCus1 WHERE BienSo = '$resCus'");
        $conn->query("DELETE FROM ct_phieusuachua WHERE SoPhieuSC = $id AND MaVTPT = $resVTPT");
        $conn->query("UPDATE vtpt SET TonKho = TonKho + $resNum WHERE MaVTPT = $resVTPT");
    }
   }
   header("Location: detail.php?id=$id")
?>