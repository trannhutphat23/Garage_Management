<?php
    require '../../login-form/connect.php'; 

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $conn->query("DELETE FROM nhacungcap WHERE MaNCC = '$id'");
        $conn->query("UPDATE nhacungcap SET MaNCC = MaNCC - 1 WHERE MaNCC > '$id'");
    }
    header("Location: Supplier.php");
?>