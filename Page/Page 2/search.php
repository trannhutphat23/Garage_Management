<?php
    require '../../login-form/connect.php';
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="./page2.css">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
      <link rel="stylesheet" href="../fontawsome/css/all.min.css">
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@100;300;400;700&display=swap" rel="stylesheet">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
      <title>Document</title>
   </head>
   <body>
      <script>
         $(document).ready(function() {
            $('.history').click(function(){
               var his = $(this).val();
               $.ajax({
                  url: "p2_RepairHis.php",
                  type: "POST",
                  data: {his: his},
                  success: function(data){
                     $("#his").html(data);
                  }
               });
            });
         });
      </script>
      <h1 class="title" >TRA CỨU</h1>
      <div class="container">
         <div class="container-heading">

            <!-- TÌM KIẾM NÂNG CAO -->
            <div class="searchMore mb-3">
               <form class="searchMore" method="POST" action="">
                  <div class="searchEle">
                     <input type="date" placeholder="Ngày tiếp nhận" name="date">
                     <input type="text" placeholder="Biển số" name="licensePlate">
                     <select name="carBrand" class="carBrand">
                        <option value="">-- Hiệu xe --</option>
                        <?php 
                           $sel_carBrand="SELECT * FROM hieuxe";
                           $recordset=mysqli_query($conn,$sel_carBrand);
                           while ($rowData=mysqli_fetch_assoc($recordset)) {
                        ?>
                           <option value="<?php echo $rowData['TenHieuXe'];?>"><?php echo $rowData['TenHieuXe'];?></option>
                        <?php 
                           }
                        ?>
                     </select>
                     <input type="text" placeholder="Tên chủ xe" name="name">
                     <input type="text" placeholder="Địa chỉ" name="address">
                     <input  type="text" placeholder="Số điện thoại" name="phone">
                     <select name="selDebt" style="margin-right: 0px;">
                        <option value="">-- Tiền nợ --</option>
                        <option value="0|500">Dưới 500$</option>
                        <option value="500|1000">500$ - 1000$</option>
                        <option value="1000|2000">1000$ - 2000$</option>
                        <option value="2000|100000000000000">Trên 2000$</option>
                     </select>
                  </div>
                  <button name="search" class="btn btn-sm btn-success search mt-2 ">
                     Tìm kiếm
                     <i class="fa fa-search"></i>
                  </button>
               </form>
            </div>
         </div>

         <!-- THÔNG TIN TIẾP NHẬN XE -->
         <table class="table table-responsive table-striped table-hover ">
            <thead>
               <tr>
               <th class="col-1 text-center">STT</th>
               <th class="col-2 text-center">Thông tin xe</th>
               <th class="col-4 text-center">Thông tin chủ xe</th>
               <th class="col-2 text-center">Tiền nợ</th>
               <th class="col-4 text-center"></th>
               </tr>
            </thead>
            <tbody style="cursor: pointer;" >
               <?php
                  if (isset($_POST['search']) && (isset($_POST['date']) || isset($_POST['licensePlate']) || isset($_POST['carBrand']) || isset($_POST['name']) && isset($_POST['address']) || isset($_POST['phone']))){
                     $date = $_POST['date'];
                     $licensePlate = $_POST['licensePlate'];
                     $carBrand = $_POST['carBrand'];
                     $name = $_POST['name'];
                     $address = $_POST['address'];
                     $phone = $_POST['phone'];
                     $debt = $_POST['selDebt'];
                     if ($debt!=""){
                        $get_debt = explode('|',$debt);
                        $sel_cost="SELECT * FROM xe, khachhang, phieusuachua, hieuxe WHERE xe.MaKH = khachhang.MaKH AND phieusuachua.BienSo = xe.BienSo AND hieuxe.MaHieuXe = xe.MaHieuXe AND (TienNo BETWEEN '$get_debt[0]' AND '$get_debt[1]')";
                     }else{
                        $sel_cost="SELECT * FROM xe, khachhang, phieusuachua, hieuxe WHERE xe.MaKH = khachhang.MaKH AND phieusuachua.BienSo = xe.BienSo AND hieuxe.MaHieuXe = xe.MaHieuXe AND (NgayTiepNhan LIKE '$date' OR xe.BienSo LIKE '$licensePlate' OR TenHieuXe LIKE '$carBrand' OR TenKH LIKE '$name' OR DiaChi LIKE '$address' OR DienThoai LIKE '$phone')";
                     }                     
                  }else{
                     $sel_cost="SELECT * FROM xe, khachhang, phieusuachua, hieuxe WHERE xe.MaKH = khachhang.MaKH AND phieusuachua.BienSo = xe.BienSo AND hieuxe.MaHieuXe = xe.MaHieuXe";
                  }
                  $recordset=mysqli_query($conn,$sel_cost);
                  $i=0;
                  while ($rowData=mysqli_fetch_assoc($recordset)) {
                     $i++;
               ?>
                  <tr style="font-size: 14px;">
                     <td class="col-1 text-center">
                        <p><b><?php echo $i?></b></p>
                     </td>
                     <td class="col-2 text-center" >
                           <p class="mb-0">Biển số: <b><?php echo $rowData['BienSo']?></b></p>
                           <p class="mb-0">Hiệu xe: <b><?php echo $rowData['TenHieuXe']?></b></d>
                     </td>
                     <td class="col-4 text-center">
                           <p class="mb-0">Chủ xe: <b><?php echo $rowData['TenKH']?></b></p>
                           <p class="mb-0">Địa chỉ: <b><?php echo $rowData['DiaChi']?></b></p>
                           <p class="mb-0">Số điện thoại: <b><?php echo $rowData['DienThoai']?></b></p>
                     </td>
                     <td class="col-2 text-center" >
                        <p class="mb-0" style="color: red; font-size: 20px;"><b><?php echo $rowData['TienNo']?></b></p>
                     </td>
                     <td class="col-4 text-center">
                        <ul class="action-list " style="list-style: none; font-size:15px;">
                           <li class="d-inline-block" onclick="Pay()"><a href="payment.php?id=<?php echo $rowData['BienSo']?>" class="btn btn-primary"><i class="fa-solid fa-money-check-dollar"></i></a></li>
                           <li class="d-inline-block " onclick="History()"><button value=<?php echo $rowData['BienSo']?> class="btn btn-primary history"><i class="fa-sharp fa-solid fa-clock-rotate-left" ></i></button></li>
                           <li class="d-inline-block"><a href="#" class="btn btn-danger" onclick=""><i class="fa fa-times"></i></a></li>
                        </ul>
                     </td>
                  </tr>      
               <?php
                  }
               ?>
            </tbody>
         </table>
      </div>

      <!-- LỊCH SỬ TIẾP NHẬN XE -->
      <div class="history-supplies-root hidden">
         <div class="history-supplies container text-center" style="width: 90%;">
            <i  class="fa-sharp fa-solid fa-square-xmark cancel" onclick="History()"></i>
            <h1 style="font-weight: 700;">LỊCH SỬ SỬA CHỮA</h1>
            <table class="table table-responsive table-striped table-hover ">
               <thead>
                  <tr>
                  <th class="col-2 text-center">Ngày sửa chữa</th>
                  <th class="col-4 text-center">Vật tư phụ tùng</th>
                  <th class="col-4 text-center">Tiền công</th>
                  <th class="col-3 text-center">Tổng tiền</th>
                  </tr>
               </thead>
               <tbody id="his" style="cursor: pointer;" >    
                  <?php
                     $sel_psc="SELECT * FROM phieusuachua, ct_phieusuachua WHERE phieusuachua.SoPhieuSC = ct_phieusuachua.SoPhieuSC AND BienSo='1111'";
                     $recordset=mysqli_query($conn,$sel_psc);
                     $i=0;
                     while ($rowData=mysqli_fetch_assoc($recordset)) {
                        $i++;
                  ?>
                     <?php
                        }
                     ?>    
               </tbody>
            </table>
         </div>
      </div>
   </body>
   <script src="./page2.js"></script>
</html>