<?php 
    require '../../login-form/connect.php'; 

    if (isset($_POST['add-new'])) {
        $ownerName=$_POST['owner-name'];
        $addr=$_POST['address'];
        $phone=$_POST['phone'];
        $licensePlate=$_POST['licensePlate'];
        $carBrand=$_POST['car-brand'];
        $inputdate = $_POST['date'];
        $date = DateTime::createFromFormat('Y-m-d', $inputdate);
        $day = $date->format('d');
        $year = $date->format('Y');
        $month = $date->format('m');

        $sl_numcar="SELECT COUNT(BienSo) as BS from xe GROUP BY DAY(NgayTiepNhan)";
        $rec_row_numcar=mysqli_num_rows(mysqli_query($conn,$sl_numcar));
        if($rec_row_numcar > 0){
            $queryNumcar = mysqli_query($conn,"SELECT COUNT(BienSo) as BS from xe GROUP BY DAY(NgayTiepNhan)");
            $getNumcar = mysqli_fetch_assoc($queryNumcar);
            $resNumcar = $getNumcar['BS'];
        }

        $strsql="SELECT SoXeNhanToiDa FROM thamso";
        $res=mysqli_query($conn,$strsql);
        $get_array=mysqli_fetch_assoc($res);
        $get_numCar=$get_array['SoXeNhanToiDa'];
        
        $queryNumcar = mysqli_query($conn,"SELECT count(*) as SoLuongXe FROM xe where DAY(NgayTiepNhan) = '$day'");
        $getNumcar = mysqli_fetch_assoc($queryNumcar);
        $resNumcar = $getNumcar['SoLuongXe'];
        if ($resNumcar==$get_numCar) {
            echo "<script> alert('Số lượng xe đã quá $get_numCar'); window.location.href='page2.php'</script>";
        } else{
            $sl_kh="SELECT * FROM khachhang";
            $rec_row_kh=mysqli_num_rows(mysqli_query($conn,$sl_kh));
            $rec_row_kh++;

            $sl_psc="SELECT * FROM phieusuachua";
            $rec_row_psc=mysqli_num_rows(mysqli_query($conn,$sl_psc));
            $rec_row_psc++;

            $get_maTN = mt_rand(0,1000000);

            $query = mysqli_query($conn,"SELECT * FROM hieuxe WHERE TenHieuXe = '$carBrand'");
            $getCarbrandIDarr = mysqli_fetch_row($query);
            $getCarbrandID = $getCarbrandIDarr[0];
            $sl_cus="SELECT * FROM khachhang, xe, phieutiepnhan WHERE khachhang.MaKh = xe.MaKH AND xe.BienSo = phieutiepnhan.BienSo AND khachhang.DienThoai = '$phone' AND khachhang.TenKH = '$ownerName' AND khachhang.DiaChi = '$addr' AND xe.BienSo = '$licensePlate' AND DAY(xe.NgayTiepNhan) != '$day' AND MONTH(xe.NgayTiepNhan) = '$month' AND YEAR(xe.NgayTiepNhan) = '$year'";
            $rec_row_cus=mysqli_num_rows(mysqli_query($conn,$sl_cus));
            $slKH="SELECT * FROM khachhang, xe WHERE khachhang.MaKH = xe.MaKH AND DienThoai = '$phone' AND TenKH = '$ownerName' AND DiaChi = '$addr' AND xe.BienSo = '$licensePlate'";
            $rec_rowKH=mysqli_num_rows(mysqli_query($conn,$slKH));
            if ($rec_rowKH == 0){
                $conn->query("INSERT INTO khachhang VALUES ('$rec_row_kh','$ownerName','$phone','$addr')");
                $conn->query("INSERT INTO xe VALUES ('$licensePlate','$getCarbrandID','$rec_row_kh','$inputdate',0)");
                $conn->query("INSERT INTO phieusuachua VALUES ('$rec_row_psc','$licensePlate','0000-00-00')");
                $conn->query("INSERT INTO phieutiepnhan VALUES ('$get_maTN','$licensePlate','$inputdate', '$ownerName','$phone','$addr', '$carBrand', 'Chưa sửa chữa')");
                header("Location: page2.php");
            }else{
                $conn->query("INSERT INTO phieutiepnhan VALUES ('$rec_row_ptn','$licensePlate','$inputdate', '$ownerName','$phone','$addr', '$carBrand', 'Chưa sửa chữa')");
                header("Location: page2.php");
            }
        }
    }
?>