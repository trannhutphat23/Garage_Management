<?php
    require '../../login-form/connect.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $query = mysqli_query($conn,"SELECT * FROM user_info WHERE INFO_ID = $id");
        $getUserID = mysqli_fetch_row($query);
        $resUserID = $getUserID[0];

        $conn->query("SET foreign_key_checks = 0");
        if ($resUserID==1){
            echo "<script> alert('KHÔNG THỂ XÓA ADMIN'); window.location.href='page4.php'</script>";
        } else{
            $conn->query("DELETE FROM user_info WHERE INFO_ID = $id");
            $conn->query("UPDATE user_info SET INFO_ID = INFO_ID - 1 WHERE INFO_ID > '$id'");
            if ($resUserID!=1) {
                $conn->query("DELETE FROM user WHERE USER_ID = $resUserID");
            }
            $conn->query("SET foreign_key_checks = 1");
            header("Location: page4.php");
        }
    }
?>