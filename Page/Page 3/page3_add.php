<?php
    require '../../login-form/connect.php'; 
    session_start();
    if (isset($_POST['add-new'])) {
        $suppliesName = $_POST['suppliesName'];
        $count = $_POST['amount'];
        $supplierName = $_POST['supplierName'];
        $price = $_POST['price'];
        $inputdate = $_POST['date'];
        $_SESSION['suppliesName'] = $suppliesName;

        $date = DateTime::createFromFormat('Y-m-d', $inputdate);
        $day = $date->format('d');
        $year = $date->format('Y');
        $month = $date->format('m');
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $rec_date = date('Y-m-d h:i:s a', time());

        $check_date=1;
        if ($inputdate > $rec_date){
            echo "<script> alert('Ngày nhập đã lớn hơn ngày hiện tại'); window.location.href='page3.php'</script>";
            $check_date=0;
        }
        if($count<=0 && $check_date==1){
            echo "<script> alert('Số lượng vật tư phụ tùng không được nhỏ hơn 0'); window.location.href='page3.php'</script>";
        }else if($check_date==1){

            $sl="SELECT * FROM phieunhapvtpt";
            $rec_row=mysqli_num_rows(mysqli_query($conn,$sl));
            $rec_row++;
    
            $querySupplier = mysqli_query($conn,"SELECT MaNCC FROM nhacungcap WHERE TenNCC = '$supplierName'");
            $getSupplierID = mysqli_fetch_row($querySupplier);
            $resSupplierID = $getSupplierID[0]; //MaNCC
    
            $querySupplies = mysqli_query($conn,"SELECT * FROM vtpt WHERE TenVTPT = '$suppliesName'");
            $getSuppliesID = mysqli_fetch_row($querySupplies);
            $resSuppliesID = $getSuppliesID[0]; //MaVTPT
            $resSuppliesCost = $getSuppliesID[2]; // DonGiaBan
            $resTonDau = $getSuppliesID[3]; //TonKho

            $queryRate = mysqli_query($conn,"SELECT * FROM thamso");
            $getRate = mysqli_fetch_row($queryRate);
            $resRate = $getRate[2]; 
            
            
            $cost = $count*$price;
    
            $sl_bcton="SELECT * FROM baocaoton WHERE MaVTPT = $resSuppliesID AND $month = MONTH(ThangNam) AND $year = YEAR(ThangNam)";
            $rec_rowbcton=mysqli_num_rows(mysqli_query($conn,$sl_bcton));
            if ($rec_rowbcton==0) {
                $sl_TC_PreMon = mysqli_query($conn,"SELECT * FROM baocaoton WHERE ($month = MONTH(ThangNam) + 1) AND ($year = YEAR(ThangNam)) AND (MaVTPT = $resSuppliesID)");
                $getTonCuoiPre = mysqli_fetch_row($sl_TC_PreMon);
                $resTonCuoiPre = $getTonCuoiPre[5];
            }
            if ($rec_rowbcton==0) {
                $TonDau = $resTonCuoiPre;
            } else {
                $TonDau = 0;
            }
            $price_vtpt = $price + $price*($resRate/100);
            $price_vtpt = (float)$price_vtpt;
            $conn->query("UPDATE vtpt SET DonGiaBan = $price_vtpt, DonGiaGoc = $price WHERE TenVTPT = '$suppliesName'");
            $conn->query("INSERT INTO phieunhapvtpt VALUES('$rec_row','$resSupplierID','$inputdate')");
            $conn->query("INSERT INTO ct_phieunhapvtpt VALUES('$rec_row','$resSuppliesID','$price','$count','$cost')");
            $conn->query("UPDATE vtpt SET TonKho = TonKho + $count WHERE MaVTPT = $resSuppliesID");
            $TonCuoi = $TonDau + $count;
            if ($rec_rowbcton==0) {
                $conn->query("INSERT INTO baocaoton VALUES('$inputdate','$resSuppliesID','$TonDau','$count',0,'$TonCuoi')");
            }
            else {
                $conn->query("UPDATE baocaoton SET PhatSinh = PhatSinh + $count, TonCuoi = TonCuoi + $count WHERE MaVTPT = $resSuppliesID AND $month = MONTH(ThangNam) AND $year = YEAR(ThangNam)");
            }
            header("Location: page3.php");
        }

    }
?>