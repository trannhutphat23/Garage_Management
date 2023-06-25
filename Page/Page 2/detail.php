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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <title>Document</title>
</head>
<body>         
   <script>
      $(document).ready(function(){
         $(".selCost").on("change", function(){
            $costName = $(this).val();
            $("#valueInit").hide();
            $.ajax({
               url: "p2_getCost.php",
               type: "POST",
               data: {name: $costName},
               success: function(data){
                  $("#getCost").html(data);
               }
            });
         });
      });
   </script>     
    <h1 class="title" >
        <a href="./repair.php" class="turnBack"><i class="fa-sharp fa-solid fa-arrow-left"></i></a> 
        CHI TIẾT
    </h1>

    <!-- CONTAINER -->
    <div class="container">
         <a href="#" class="btn btn-sm btn-primary fa-pull-left mb-1" onclick="Add()">
            <i class="fa fa-plus-circle"></i>  
            SỬA THÔNG TIN
         </a>   
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
                    $sel_cus="SELECT DISTINCT * FROM xe,khachhang,phieusuachua,hieuxe WHERE xe.MaKH=khachhang.MaKH AND phieusuachua.BienSo=xe.BienSo AND hieuxe.MaHieuXe=xe.MaHieuXe AND xe.BienSo = '$getID'";
                    $recordset=mysqli_query($conn,$sel_cus);
                    while ($rowData=mysqli_fetch_assoc($recordset)) {
               ?>
                  <tr style="font-size: 14px;">
                     <td class="col-3 text-center">
                           <p>Ngày tiếp nhận: <b><?php echo $rowData['NgayTiepNhan']?></b></p>
                     </td>
                     <td class="col-3 text-center" style="border-left: 1px solid black;" >
                           <p>Biển số: <b><?php echo $rowData['BienSo']?></b></p>
                           <p class="mb-0">Hiệu xe: <b><?php echo $rowData['TenHieuXe']?></b></d>
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
        
        <!-- BUTTON -->
        <div class="buttonS">

            <!-- THEM VAT TU -->
            <a href="#" class="btn btn-sm btn-primary fa-pull-left mb-1" onclick="Supplies()">
                    <i class="fa fa-plus-circle"></i>  
                    THÊM
            </a>  
        </div>

        <br>
        <br>

        <!-- CHI TIET VAT TU -->
        <div class="supplies">
            <h1 style="font-weight: 700;">VẬT LIỆU SỬA CHỮA</h1>
            <table class="table table-responsive table-striped">
               <thead>
                  <tr class="text-center">
                     <th class="col-3">Tên vật liệu</th>
                     <th class="col-3">Đơn giá</th>
                     <th class="col-2">Số lượng</th>
                     <th class="col-3">Tổng tiền</th>
                     <th class="col-3"></th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                     $strsql="SELECT TiLeTinhDonGiaBan FROM thamso";
                     $resSQL=mysqli_query($conn,$strsql);
                     $get_array=mysqli_fetch_assoc($resSQL);
                     $getRate=$get_array['TiLeTinhDonGiaBan'];

                     $sel_vtpt="SELECT TenVTPT,sum(SoLuong) as SL, sum(ThanhTien) as TT, DonGiaBan FROM ct_phieusuachua, vtpt WHERE vtpt.MaVTPT=ct_phieusuachua.MaVTPT AND SoPhieuSC='$getID' GROUP BY ct_phieusuachua.MaVTPT";
                     $recordset=mysqli_query($conn,$sel_vtpt);
                     while ($rowData=mysqli_fetch_assoc($recordset)) {
                  ?>
                     <div class="ele">
                        <tr style="font-size: 14px;">
                           <td class="col-3 text-center">
                           <p><b><?php echo $rowData['TenVTPT']?></b></p>
                           </td>
                           <td class="col-3 text-center">
                           <p><b><?php echo $rowData['DonGiaBan']+($rowData['DonGiaBan']*$getRate)/100?></b></p>
                           </td>
                           <td class="col-1 text-center" >
                           <p><b><?php echo $rowData['SL']?></b></p>
                           </td>
                           <td class="col-2 text-center">
                           <p><b><?php echo $rowData['SL']*($rowData['DonGiaBan']+($rowData['DonGiaBan']*$getRate)/100)?></b></p>
                           </td>
                           <td class="col-1 text-center">
                           <li class="d-inline-block"><a href="deleteData.php?id=<?php echo $getID?>" class="btn btn-danger"><i class="fa fa-times"></i></a></li>
                           </td>
                        </tr>
                    </div>
                  <?php
                     }
                  ?>
               </tbody>
            </table>
        </div>

        <!-- CHI TIET TIEN CONG -->
        <div class="cost">
            <h1 style="font-weight: 700;">TIỀN CÔNG</h1>
            <table class="table table-responsive table-striped">
               <thead>
                  <tr class="text-center">
                     <th class="col-7">Tên tiền công</th>
                     <th class="col-3">Tổng tiền</th>
                     <th class="col-2"></th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                     $sel_cost="SELECT * FROM ct_phieusuachua, tiencong WHERE ct_phieusuachua.MaTC=tiencong.MaTC AND SoPhieuSC='$getID'";
                     $recordset=mysqli_query($conn,$sel_cost);
                     while ($rowData=mysqli_fetch_assoc($recordset)) {
                  ?>
                     <div class="ele">
                        <tr style="font-size: 14px;">
                           <td class="col-3 text-center">
                           <p><b><?php echo $rowData['TenTienCong']?></b></p>
                           </td>
                           <td class="col-2 text-center">
                           <p><b><?php echo $rowData['GiaTienCong']?></b></p>
                           </td>
                           <td class="col-1 text-center">
                           <li class="d-inline-block"><a href="#" class="btn btn-danger"><i class="fa fa-times"></i></a></li>
                           </td>
                        </tr>
                     </div>
                  <?php
                     }
                  ?>
               </tbody>
            </table>
        </div>

        <!-- TONG TIEN -->
        <div style="left: 70%;" class="total">
        <?php
            if (mysqli_num_rows(mysqli_query($conn,"SELECT * FROM ct_phieusuachua"))){
               $queryTong = mysqli_query($conn,"SELECT sum(ThanhTien) FROM ct_phieusuachua WHERE SoPhieuSC=$getID");
               $getTong = mysqli_fetch_row($queryTong);
               $resTong = $getTong[0]; 
               echo "<p>Tổng tiền:  <b>".$resTong."</b>   $</p>";
            }
         ?>
            <button type="submit" class="btn btn-success mt-1 mb-3" onclick="Pay()"> 
                THANH TOÁN
             </button>
        </div>
    </div>

  
    <!-- <div class="supplies-form-root hidden">
      <form class="supplies-form-root" method="POST" action="add_ctphieusuachua.php?id=<?php echo $getID?>">
         <div style="padding: 15px;" class="supplies-form ">
             <h1 style="font-weight: 700;">
                 THÊM VẬT TƯ PHỤ TÙNG
                 <i class="fa-sharp fa-solid fa-square-xmark cancel" style="left:30%;" onclick="Supplies()"></i>
             </h1>
            <table class="table table-responsive ">
               <thead>
                  <tr class="text-center">
                     <th class="col-9">Tên vật liệu</th>
                     <th class="col-3">Số lượng</th>
                  </tr>
               </thead>
               <tbody>
                     <tr style="font-size: 14px;">
                        <td class="col-3">
                           <div class="d-flex justify-content-center">
                              <select name="selectSupply" class="form-select" id="supplyName" required>
                                 <option value="">-- Vật liệu --</option>
                                 <?php 
                                     $sel_vtpt="SELECT * FROM vtpt";
                                     $recordset=mysqli_query($conn,$sel_vtpt);
                                     while ($rowData=mysqli_fetch_assoc($recordset)) {
                                  ?>
                                     <option value="<?php echo $rowData['TenVTPT'];?>"><?php echo $rowData['TenVTPT'];?></option>
                                  <?php
                                     }
                                  ?>
                              </select>
                           </div>
                        </td>
                        <td class="col-1">
                           <div class="d-flex justify-content-center">
                              <input name="amount" type="number" class="form-control" aria-label="Number" aria-describedby="basic-addon1">
                           </div>
                        </td>
                     </tr>
               </tbody>
            </table>
            <h1 style="font-weight: 700;">
             THÊM TIỀN CÔNG
             </h1>
            <table class="table table-responsive ">
               <thead>
                  <tr class="text-center">
                     <th class="col-9">Tên tiền công</th>
                     <th class="col-3">Giá tiền</th>
                  </tr>
               </thead>
               <tbody>
                     <tr style="font-size: 14px;">
                        <td class="col-3">
                           <div class="d-flex justify-content-center">
                              <select name="selectCost" class="form-select selCost" id="supplyName" required>
                                 <option id="valueInit" value="">-- Tiền công --</option>
                                 <?php 
                                     $sel_cost="SELECT * FROM tiencong";
                                     $recordset=mysqli_query($conn,$sel_cost);
                                     while ($rowData=mysqli_fetch_assoc($recordset)) {
                                  ?>
                                     <option value="<?php echo $rowData['TenTienCong'];?>"><?php echo $rowData['TenTienCong'];?></option>
                                  <?php
                                     }
                                  ?>
                              </select>
                           </div>
                        </td>
                        <td class="col-1">
                            <div class="d-flex justify-content-center">
                               <p><b style="font-size: 20px;" id="getCost"></b></p>
                            </div>
                         </td>
                     </tr>
               </tbody>
            </table>
            <button name="add-new" class="btn btn-sm btn-primary fa-pull-left mb-1" onclick="Supplies()">
                   <i class="fa fa-plus-circle"></i>  
                   THÊM
             </button>
         </div>
      </form>
    </div> -->

   

    <div class="pay-root hidden">
      <form class="pay-root" method="POST" action="payment.php?id=<?php echo $getID?>">
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
                    <th class="col-9">Số tiền</th>
                 </tr>
              </thead>
              <tbody>
                  <?php
                     $queryLicensePlate = mysqli_query($conn,"SELECT xe.BienSo FROM xe, phieusuachua WHERE xe.BienSo=phieusuachua.BienSo AND SoPhieuSC=$getID");
                     $getLicensePlate = mysqli_fetch_row($queryLicensePlate);
                     $resLicensePlate = $getLicensePlate[0]; //BienSo
                              
                     $sel_tienthu="SELECT SoTienThu, NgayLapPhieuThu FROM phieuthutien WHERE BienSo='$resLicensePlate'";
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
                     $queryBienSo = mysqli_query($conn,"SELECT BienSo FROM phieusuachua WHERE SoPhieuSC=$getID");
                     $getBienSo = mysqli_fetch_row($queryBienSo);
                     $resBienSo = $getBienSo[0]; // MaVTPT

                     $queryTonga = mysqli_query($conn,"SELECT TienNo FROM xe WHERE BienSo='$resBienSo'");
                     $getTonga = mysqli_fetch_row($queryTonga);
                     $resTonga = $getTonga[0]; // MaVTPT
                     echo "<p>Còn nợ:  <b>".$resTonga."</b>   $</p>";
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
    <div class="add-form-root hidden">
       <div class="add-form container text-center">
            <form  method="POST" action="update_info.php?id=<?php echo $getID?>">
               <i class="fa-sharp fa-solid fa-square-xmark cancel" onclick="Add()"></i>
               <h1 style="font-weight: 700;">THÊM MỚI</h1>
               <div class="row mt-3 d-flex justify-content-center">
                  <div class="col-12 col-md-6">
                     <div class="form-group mb-3 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-user mr-1"></i>
                        <input type="text" class="form-control " id="Owner" name="owner-name"
                           placeholder="Tên chủ xe" >
                     </div>
                     <div class="form-group mb-3 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-location-dot mr-1"></i>
                        <input type="text" class="form-control" id="Address" name="address"
                           placeholder="Địa chỉ" >
                     </div>
                     <div class="form-group mb-3 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-phone mr-1"></i>
                        <input type="text" class="form-control" id="Phone" name="phone"
                           placeholder="Số điện thoại" >
                     </div>
                     <div class="form-group mb-3 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-car mr-1"></i>
                        <select class="form-select" id="carBrand" name="car-brand" >
                           <option value="">-- HÃNG XE --</option>
                           <?php 
                              $sel_carbrand="SELECT * FROM hieuxe";
                              $recordset=mysqli_query($conn,$sel_carbrand);
                              while ($rowData=mysqli_fetch_assoc($recordset)) {
                           ?>
                              <option value="<?php echo $rowData['TenHieuXe'];?>"><?php echo $rowData['TenHieuXe'];?></option>
                           <?php
                              }
                           ?>
                        </select>
                     </div>
                     <div class="form-group mb-3 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary" name="add-new" onclick="">
                        <i class="fa fa-plus-circle mr-1"></i> 
                        CẬP NHẬT
                        </button>
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>


</body>
    <script src="page2.js"></script>
</html>