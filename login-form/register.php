<?php
    session_start();
    require 'connect.php';
    if (isset($_POST['reg-submit'])) {
        $check=0;
        (!empty($_POST['User'])) ? ($name=$_POST['User']) : ($check=1);
        (!empty($_POST['Password'])) ? $pass=$_POST['Password'] : ($check=1);
        (!empty($_POST['Fullname'])) ? $fullname=$_POST['Fullname'] : ($check=1);
        (!empty($_POST['NumberPhone'])) ? $phone=$_POST['NumberPhone'] : ($check=1);
        (!empty($_POST['Email'])) ? $email=$_POST['Email'] : ($check=1);
        (!empty($_POST['Confirm'])) ? $passConfirm=$_POST['Confirm'] : ($check=1);
        //CHECK FORMAT EMAIL
        $checkMail=true;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) && $check!=1) {
            $checkMail=false;
            echo "<script>alert('EMAIL KHÔNG ĐÚNG ĐỊNH DẠNG'); location.href='/login.php';</script>";
        }
        // CHECK PASS AND PASS_CONFIRM
        if ($pass == $passConfirm && $check!=1 && $checkMail==true) {
            $sql="SELECT * FROM user";
            $countrow=mysqli_num_rows(mysqli_query($conn,$sql));
            $countrow++;
            $id_permission="0".$countrow;
            $id_permission=(int)$id_permission;
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $rec_date = date('Y-m-d h:i:s a', time());
            $check1=$conn->query("INSERT INTO user VALUES ('$countrow',1,'$name','$pass')");
            $check2=$conn->query("INSERT INTO user_info VALUES ('$countrow','$countrow','$fullname','$email','$phone','$rec_date')");
            if ($check1 && $check2) {
                $check=2;
            } 
            else $check=3;
        }
    }    
?>
<script>
    var check = <?php echo json_encode($check);?>;
    if (check==1) {
        alert("CHƯA ĐIỀN ĐẦY ĐỦ THÔNG TIN");
    }
    else if (check==2){
        alert("ĐĂNG KÝ THÀNH CÔNG");
    }
    else if (check==3){
        alert("ĐĂNG KÝ THẤT BẠI");
    }              
    location.href='login.php';
</script>        
                