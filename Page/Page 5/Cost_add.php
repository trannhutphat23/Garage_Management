<?php
    require '../../login-form/connect.php'; 
    session_start();
    if (isset($_POST['add-new'])) {
        $costName = $_POST['CostName'];
        $costValue = $_POST['CostValue'];
        $sl="SELECT * FROM tiencong";
        $rec_row=mysqli_num_rows(mysqli_query($conn,$sl));

        $strsql="SELECT SoLuongTienCong FROM thamso";
        $res=mysqli_query($conn,$strsql);
        $get_array=mysqli_fetch_assoc($res);
        $get_cost=$get_array['SoLuongTienCong'];
        if ($rec_row==$get_cost) {
            echo "<script> alert('Số lượng tiền công đã quá $get_cost'); window.location.href='Cost.php'</script>";
        } else {
            $rec_row++;
            $conn->query("INSERT INTO tiencong VALUES ('$rec_row', '$costName', '$costValue')");
            header("Location: Cost.php");
        }
    }
?>