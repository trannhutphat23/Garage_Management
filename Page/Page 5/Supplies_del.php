<?php
    require '../../login-form/connect.php'; 

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $slVTPT1="SELECT * FROM ct_phieusuachua WHERE MaVTPT = $id";
        $recVTPT1=mysqli_num_rows(mysqli_query($conn,$slVTPT1));

        $slVTPT2="SELECT * FROM ct_phieunhapvtpt WHERE MaVTPT = $id";
        $recVTPT2=mysqli_num_rows(mysqli_query($conn,$slVTPT2));

        if ($recVTPT1 > 0 || $recVTPT2 > 0){
            echo "<script> alert('Vật tư phụ tùng đang được sử dụng'); window.location.href='Supplies.php?id=$id'</script>";
        }
        else{
            $conn->query("DELETE FROM vtpt WHERE MaVTPT = '$id'");
            $conn->query("UPDATE vtpt SET MaVTPT = MaVTPT - 1 WHERE MaVTPT > '$id'");
            header("Location: Supplies.php");
        }
    }
?>