<?php
    require '../../login-form/connect.php'; 

    if (isset($_POST['add-new'])) {
        $supplierName = $_POST['supplier_name'];
        $supplierPhone = $_POST['supplier_phone'];
        $supplierEmail = $_POST['supplier_email'];
        $sl="SELECT * FROM nhacungcap";
        $rec_row=mysqli_num_rows(mysqli_query($conn,$sl));
        $rec_row++;
        $conn->query("INSERT INTO nhacungcap VALUES ('$rec_row', '$supplierName', '$supplierPhone', '$supplierEmail')");
    }
    header("Location: Supplier.php");
?>