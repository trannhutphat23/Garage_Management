<?php
    require '../../login-form/connect.php'; 

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $slHX1="SELECT * FROM xe WHERE MaHieuXe = $id";
        $recHX1=mysqli_num_rows(mysqli_query($conn,$slHX1));

        $slHX2="SELECT * FROM baocaodoanhthu WHERE MaHieuXe = $id";
        $recHX2=mysqli_num_rows(mysqli_query($conn,$slHX2));

        if ($recHX1 > 0 || $recHX2 > 0){
            echo "<script> alert('Hiệu xe đang được sử dụng'); window.location.href='Supplies.php?id=$id'</script>";
        }

        $conn->query("DELETE FROM hieuxe WHERE MaHieuXe = '$id'");
        $conn->query("UPDATE hieuxe SET MaHieuXe = MaHieuXe - 1 WHERE MaHieuXe > '$id'");
    }
    header("Location: CarBrand.php");
?>