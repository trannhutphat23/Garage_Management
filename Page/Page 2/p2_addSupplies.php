<?php
    require '../../login-form/connect.php'; 
    if (isset($_POST['add-new'])) {
        $suppliesName = $_POST['suppliesName'];
        $amount = $_POST['amount'];

        $query = mysqli_query($conn,"SELECT * FROM vtpt WHERE TenVTPT = '$suppliesName'");
        $get_row = mysqli_fetch_row($query);
        $getCost = $get_row[2];
        $getNumSupplies = $get_row[3];
        if ($amount > $getNumSupplies) {
            echo "<script> alert('Số lượng vật tư phụ tùng lớn hơn tồn kho'); window.location.href='page2.php'</script>";
        } else {
            $conn->query("UPDATE vtpt SET TonKho = TonKho - $amount WHERE TenVTPT = '$suppliesName'");
        }
    }
    // header("Location: page2.php");
?>
