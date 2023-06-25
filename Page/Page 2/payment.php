<?php
    require '../../login-form/connect.php';
    session_start();
    if(isset($_GET['id'])){
        $getID = $_GET['id'];
    }
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
    <title>Document</title>
</head>
<body>          
    <h1 class="title" >
        <a href="./search.php" class="turnBack"><i class="fa-sharp fa-solid fa-arrow-left"></i></a> 
        PHIẾU THANH TOÁN
    </h1>

    <!-- CONTAINER -->
    <div class="container">
        <!-- THONG TIN KHACH HANG -->
        <table class="table table-responsive table-striped table-hover ">
            <thead style="border: 1px solid black;">
               <tr>
                    <th class="col-1 text-center">Ngày tiếp nhận</th>
                    <th class="col-4 text-center" style="border-left: 1px solid black;">Thông tin xe</th>
                    <th class="col-7 text-center" style="border-left: 1px solid black;">Thông tin chủ xe</th>
               </tr>
            </thead>
            <tbody style="cursor: pointer; border: 1px solid black;" >
               <?php
                  $sel_cus="SELECT * FROM ((SELECT HieuXe,DiaChi,DienThoai,TenKH,BienSo,NgayTiepNhan,day(NgayTiepNhan) as dday from phieutiepnhan) b INNER JOIN (SELECT BienSo,max(day(NgayTiepNhan)) as maxDay FROM phieutiepnhan GROUP BY BienSo) a on a.BienSo = b.BienSo AND a.maxDay = b.dday) WHERE a.BienSo = '$getID'";
                  $recordset=mysqli_query($conn,$sel_cus);
                  while ($rowData=mysqli_fetch_assoc($recordset)) {
               ?>
                  <tr style="font-size: 14px;">
                     <td class="col-3 text-center">
                           <p>Ngày tiếp nhận: <b><?php echo $rowData['NgayTiepNhan']?></b></p>
                     </td>
                     <td class="col-3 text-center" style="border-left: 1px solid black;" >
                           <p>Biển số: <b><?php echo $rowData['BienSo']?></b></p>
                           <p class="mb-0">Hiệu xe: <b><?php echo $rowData['HieuXe']?></b></d>
                     </td>
                     <td class="col-3 text-center" style="border-left: 1px solid black;">
                           <p>Chủ xe: <b><?php echo $rowData['TenKH']?></b></p>
                           <p>Địa chỉ: <b><?php echo $rowData['DiaChi']?></b></p>
                           <p class="mb-0">Số điện thoại: <b><?php echo $rowData['DienThoai']?></b></p>
                     </td>
                  </tr>   
               <?php
                  }
               ?>      
            </tbody>
        </table>
        
        <table class="table table-responsive table-striped table-hover ">
            <thead>
               <tr>
               <th class="col-2 text-center">Ngày sửa chữa</th>
               <th class="col-4 text-center">Vật tư phụ tùng</th>
               <th class="col-4 text-center">Tiền công</th>
               <th class="col-3 text-center">Tổng tiền</th>
               </tr>
            </thead>
            <tbody style="cursor: pointer;" >    
               <?php
                  $sel_psc="SELECT *, sum(ThanhTien) as TT, GROUP_CONCAT(TenVTPT SEPARATOR '<br>') as VTPT, GROUP_CONCAT(TenTienCong SEPARATOR '<br>') as TC FROM phieusuachua, ct_phieusuachua, vtpt, tiencong WHERE phieusuachua.SoPhieuSC = ct_phieusuachua.SoPhieuSC AND vtpt.MaVTPT = ct_phieusuachua.MaVTPT AND tiencong.MaTC = ct_phieusuachua.MaTC AND BienSo='$getID' GROUP BY NgaySuaChua";
                  $recordset=mysqli_query($conn,$sel_psc);
                  $i=0;
                  while ($rowData=mysqli_fetch_assoc($recordset)) {
               ?>
                  <tr style="font-size: 14px;">
                     <td class="col-2 text-center">
                           <p><b><?php echo $rowData['NgaySuaChua']?></b></p>
                     </td>
                     <td class="col-4 text-center" >
                           <p class="mb-0"><b><?php echo $rowData['VTPT']?></b></p>
                     </td>
                     <td class="col-4 text-center">
                           <p class="mb-0"><b><?php echo $rowData['TC']?></b></p>
                     </td>
                     <td class="col-3 text-center">
                        <p style="color: red; font-size: 17px;"><b><?php echo $rowData['TT']?></b></p>
                     </td>
               <?php
                  }
               ?> 
            </tbody>
         </table>
         <div style="left: 70%;" class="total" onclick="Pay()">
            <button type="submit" class="btn btn-success mt-1 mb-3" > 
                THANH TOÁN
            </button>
        </div>
    </div>
    <div class="pay-root hidden">
      <form class="pay-root" method="POST" action="payment_add.php?id=<?php echo $getID?>">
        <div style="padding: 15px;" class="pay">
           <i class="fa-sharp fa-solid fa-square-xmark cancel" onclick="Pay()"></i>
           <h1 style="font-weight: 700;">THANH TOÁN</h1>
           <table class="table table-responsive table-striped">
            <p 
            style="background-color:#6B728E; color: white; font-size: 20px; border: 1px solid black; border-bottom: none;" 
            class="mb-0 text-center"><b>LỊCH SỬ THANH TOÁN</b></p>
            <thead>
               <tr class="text-center">
                  <th class="col-3">Ngày</th>
                  <th class="col-9">Số tiền thu</th>
               </tr>
            </thead>
            <tbody>
               <?php          
                  $sel_tienthu="SELECT SoTienThu, NgayLapPhieuThu FROM phieuthutien WHERE BienSo='$getID'";
                  $recordset=mysqli_query($conn,$sel_tienthu);
                  while ($rowData=mysqli_fetch_assoc($recordset)) {
                     echo "<div class='ele'>
                              <tr style='font-size: 14px;'>
                                 <td class='col-3 text-center'>
                                    <p><b>".$rowData['NgayLapPhieuThu']."</b></p>
                                 </td>
                                 <td class='col-9 text-center' >
                                    <p><b>".$rowData['SoTienThu']."</b></p>
                                 </td>
                              </tr>
                           </div>";
                  }
               ?>
            </tbody>
            </table>
           <div class="total">
               <?php
                  if (mysqli_num_rows(mysqli_query($conn,"SELECT * FROM ct_phieusuachua"))){
                     $queryTonga = mysqli_query($conn,"SELECT TienNo FROM xe WHERE BienSo='$getID'");
                     $getTonga = mysqli_fetch_row($queryTonga);
                     $resTonga = $getTonga[0]; // MaVTPT
                     echo "<p>Còn nợ:  <b style='color: red;'>".$resTonga."</b>   $</p>";
                  }
               ?>
              <input name="money" type="number" min="1" step="any" class="form-control w-50 mb-2" id="Money" placeholder="Số tiền thanh toán" required>
              <button name="click_new" type="submit" class="btn btn-success mt-1" onclick=""> 
                 THANH TOÁN
              </button>
              
           </div>
        </div>
      </form>
   </div>

</body>
    <script src="page2.js"></script>
</html>
