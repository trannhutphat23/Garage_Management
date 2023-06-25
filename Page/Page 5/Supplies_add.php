<?php
    require '../../login-form/connect.php'; 

    if (isset($_POST['add-new'])) {
        $suppliesName = $_POST['SuppliesName'];
        $suppliesPrice = $_POST['SuppliesPrice'];
        $supplierName = $_POST['SupplierName'];
        
        $sl="SELECT * FROM vtpt";
        $rec_row=mysqli_num_rows(mysqli_query($conn,$sl));
        $query = mysqli_query($conn,"SELECT * FROM nhacungcap WHERE TenNCC = '$supplierName'");
        $getSupplierID = mysqli_fetch_row($query);
        $res = $getSupplierID[0];

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $rec_date = date('Y-m-d h:i:s a', time());
        $cost = $count*$resSuppliesCost;

        $strsql="SELECT SoLuongVTPT FROM thamso";
        $resSQL=mysqli_query($conn,$strsql);
        $get_array=mysqli_fetch_assoc($resSQL);
        $get_supplies=$get_array['SoLuongVTPT'];
        if ($rec_row==$get_supplies) {
            echo "<script> alert('Số lượng vật tư phụ tùng đã quá $get_supplies'); window.location.href='Supplies.php'</script>";
        }
        else{
            $rec_row++;
            $conn->query("INSERT INTO vtpt VALUES ('$rec_row', '$suppliesName', '$suppliesPrice',50,'$res', '$supplierName')");
            header("Location: Supplies.php");
        }
    }
?>