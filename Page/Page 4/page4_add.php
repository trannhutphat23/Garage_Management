<?php
    require '../../login-form/connect.php'; 
    session_start();
    if (isset($_POST['add-new'])) {
        $employeeName = $_POST['employeeName'];
        $cccd = $_POST['CCCD'];
        $phoneNumber = $_POST['phoneNumber'];
        $address = $_POST['address'];
        $workDate = $_POST['workDate'];
        $permission = $_POST['permission'];

        $query = mysqli_query($conn,"SELECT * FROM permission WHERE PERMISSION_NAME = '$permission'");
        $getPerID = mysqli_fetch_row($query);
        $resPerID = $getPerID[0];
        $res = (int)$resPerID;

        $sl_info="SELECT * FROM user_info";
        $rec_row_info=mysqli_num_rows(mysqli_query($conn,$sl_info));
        $rec_row_info++;

        $sl="SELECT * FROM user";
        $rec_row=mysqli_num_rows(mysqli_query($conn,$sl));
        $conn->query("SET foreign_key_checks = 0");
        if ($resPerID==1) {
            $conn->query("INSERT INTO user_info VALUES ('$rec_row_info','$rec_row' ,'$employeeName','$cccd','$address','$phoneNumber','$workDate')");
        }
        else if ($resPerID==2){
            $rec_row++;
            $conn->query("INSERT INTO user_info VALUES ('$rec_row_info','$rec_row' ,'$employeeName','$cccd','$address','$phoneNumber','$workDate')");
            $conn->query("INSERT INTO user VALUES ('$rec_row', '$resPerID', '$cccd', '1')");
        }
        $conn->query("SET foreign_key_checks = 1");
    }
    header("Location: page4.php");
?>