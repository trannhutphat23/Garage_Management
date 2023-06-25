<?php
    require '../../login-form/connect.php'; 

    if (isset($_POST['name'])){
        $namecost = $_POST['name'];
        
        $queryCost = mysqli_query($conn,"SELECT GiaTienCong FROM tiencong WHERE TenTienCong = '$namecost'");
        $getCost = mysqli_fetch_row($queryCost);
        $resCost = $getCost[0];

        echo $resCost;
    }
?>