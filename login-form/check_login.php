<?php
    session_start();
    require 'connect.php';
    if ($_SERVER['REQUEST_METHOD']=='POST') {
        $log_username = $_POST['User'];
        $log_password = $_POST['Password'];
        
        $queryInfo = mysqli_query($conn,"SELECT * FROM user, user_info WHERE user_info.ID_USER = user.USER_ID AND USER_NAME = '$log_username'");
        $queryInfo = mysqli_fetch_row($queryInfo);
        $resInfo = $queryInfo[6]; 
        $resPer = $queryInfo[1];
        if (isset($_SESSION['getInfo'])){
            setcookie('getInfo',$resInfo, time() - 3600, "/");
            // setcookie('getPermission',$resPer, time() - 3600, "/");
            $_SESSION['getInfo']= $queryInfo;
            // $_SESSION['resPer']= $queryInfo;
        } else{
            setcookie('getInfo',$resInfo,time() + 7200, "/");
            // setcookie('getPermission',$resPer, time() - 3600, "/");
        }
        require 'connect.php';
        
        $sql="SELECT * FROM user WHERE User_name='$log_username' AND Password='$log_password' ";
        $res=mysqli_query($conn,$sql);
        $check = mysqli_fetch_array($res);
        if (isset($check)){
            echo "<script> alert('ĐĂNG NHẬP THÀNH CÔNG'); window.location.href='../index.php'</script>";
        }
        else echo "<script> alert('ĐĂNG NHẬP THẤT BẠI'); window.location.href='login.php'</script>";   
    }    
    $conn->close();
?>