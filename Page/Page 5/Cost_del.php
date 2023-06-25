<?php
    require '../../login-form/connect.php'; 

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $slTC="SELECT * FROM ct_phieusuachua WHERE MaTC = $id";
        $recTC=mysqli_num_rows(mysqli_query($conn,$slTC));

        if ($recTC > 0){
            echo "<script> alert('Tiền công đang được sử dụng'); window.location.href='Cost.php?id=$id'</script>";
        }
        $conn->query("DELETE FROM tiencong WHERE MaTC = '$id'");
        $conn->query("UPDATE tiencong SET MaTC = MaTC - 1 WHERE MaTC > '$id'");
    }
    header("Location: Cost.php");
?>