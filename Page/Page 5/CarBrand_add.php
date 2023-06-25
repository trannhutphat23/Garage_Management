<?php
    require '../../login-form/connect.php'; 

    if (isset($_POST['add-new'])) {
        $BrandName = $_POST['BrandName'];
        $sl="SELECT * FROM hieuxe";
        $rec_row=mysqli_num_rows(mysqli_query($conn,$sl));
        
        $strsql="SELECT SoLuongHieuXe FROM thamso";
        $res=mysqli_query($conn,$strsql);
        $get_array=mysqli_fetch_assoc($res);
        $get_carbrand=$get_array['SoLuongHieuXe'];
        if ($rec_row==$get_carbrand) {
            echo "<script> alert('Số lượng hiệu xe đã quá $get_carbrand'); window.location.href='CarBrand.php'</script>";
        }
        else {
            $rec_row++;
            $conn->query("INSERT INTO hieuxe VALUES ('$rec_row','$BrandName')");
            header("Location: CarBrand.php");
        }
    }
?>