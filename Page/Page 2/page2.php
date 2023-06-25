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
               var selectMonth = $(".selMonth option:selected").val();
               var selectYear = $(".selYear option:selected").val();
               $.ajax({
                  url: "page2_importHis.php",
                  type: "POST",
                  data: {MONTH: selectMonth, YEAR: selectYear},
                  success: function(data){
                     $("#History").html(data);
                  }
               });
            });
         });
      </script>
      <h1 class="title" >PHIẾU TIẾP NHẬN XE</h1>
      <div class="container">
         <div class="container-heading">
            <form method="POST" action="page2.php">
               <div class="col-sm-12 col-xs-12">
                  <a href="#" class="btn btn-sm btn-primary fa-pull-left mb-1" onclick="Add()">
                     <i class="fa fa-plus-circle"></i>  
                     LẬP PHIẾU TIẾP NHẬN XE MỚI
                  </a>      
                  
                  <!-- BUTTON LỊCH SỬ TIẾP NHẬN -->
                  <a href="#" class="btn btn-sm btn-primary fa-pull-left mb-1" onclick="History()">
                     <i class="fa-sharp fa-solid fa-clock-rotate-left"></i>
                     LỊCH SỬ TIẾP NHẬN XE
                  </a>
                  <button name="search" class="btn btn-sm btn-dark fa-pull-right search">
                     <i class="fa fa-search"></i>
                  </button>
                  <input type="text" name="ValueSearch" id="search" class="fa-pull-right" placeholder="Tìm kiếm">
               </div>
            </form>
         </div>
         <table class="table table-responsive table-striped table-hover ">
            <thead>
               <tr>
                  <th class="col-1 text-center">STT</th>
                  <th class="col-3 text-center">Ngày tiếp nhận</th>
                  <th class="col-3 text-center">Thông tin xe</th>
                  <th class="col-5 text-center">Thông tin chủ xe</th>
                  <th class="col-1 text-center"></th>
               </tr>
            </thead>
            <tbody style="cursor: pointer;" >
               <?php 
                  // Search
                  if(isset($_POST['search']) && $_POST['search']!=" "){
                     $valueSearch = $_POST['ValueSearch'];
                     $sel_cus = "SELECT * FROM ((SELECT HieuXe,DiaChi,DienThoai,TenKH,BienSo,NgayTiepNhan,day(NgayTiepNhan) as dday from phieutiepnhan) b INNER JOIN (SELECT BienSo,max(day(NgayTiepNhan)) as maxDay FROM phieutiepnhan GROUP BY BienSo) a on a.BienSo = b.BienSo AND a.maxDay = b.dday) WHERE (a.BienSo LIKE '%$valueSearch%' OR  TenKH LIKE '%$valueSearch%' OR HieuXe LIKE '%$valueSearch%' OR DiaChi LIKE '%$valueSearch%' OR DienThoai LIKE '%$valueSearch%')";
                  }
                  else{
                     $sel_cus="SELECT * FROM ((SELECT HieuXe,DiaChi,DienThoai,TenKH,BienSo,NgayTiepNhan,day(NgayTiepNhan) as dday from phieutiepnhan) b INNER JOIN (SELECT BienSo,max(day(NgayTiepNhan)) as maxDay FROM phieutiepnhan GROUP BY BienSo) a on a.BienSo = b.BienSo AND a.maxDay = b.dday)";
                  }
                  $recordset=mysqli_query($conn,$sel_cus);
                  $i=0;
                  while ($rowData=mysqli_fetch_assoc($recordset)) {
                     $i++;
               ?>
                  <tr style="font-size: 14px;">
                     <td class="col-1 text-center">
                         <p><b><?php echo $i ?></b></p>
                     </td>
                     <td class="col-3 text-center">
                         <p><b><?php echo $rowData['NgayTiepNhan']; ?></b></p>
                     </td>
                     <td class="col-3 text-center" >
                        <P class="mb-0">Biển số: <b><?php echo $rowData['BienSo']; ?></b></P>
                        <p class="mb-0">Hiệu xe: <b><?php echo $rowData['HieuXe'];?></b></d>
                     </td>
                     <td class="col-5 text-center">
                         <p class="mb-0">Chủ xe: <b><?php echo $rowData['TenKH']?></b></p>
                         <p class="mb-0">Địa chỉ: <b><?php echo $rowData['DiaChi']?></b></p>
                         <p class="mb-0">Số điện thoại: <b><?php echo $rowData['DienThoai']?></b></p>
                     </td>
                     <td class="col-1 text-center">
                        <ul class="action-list " style="list-style: none; font-size:15px;">
                           <li class="d-inline-block"><a href="page2_dtb_del.php?id=<?php echo $rowData['BienSo'];?>" class="btn btn-danger" onclick=""><i class="fa fa-times"></i></a></li>
                        </ul>
                     </td>
                  </tr>
               <?php
                  }
               ?>         
            </tbody>
         </table>
      </div>
      <div class="add-form-root hidden">
         <div class="add-form container text-center">
            <i class="fa-sharp fa-solid fa-square-xmark cancel" onclick="Add()"></i>
            <h1 style="font-weight: 700;">THÊM MỚI</h1>
            <div class="row mt-3 d-flex justify-content-center">
               <div class="col-12 col-md-6">
                  <form class="form-inline" method="POST" action="page2_dtb_add.php">
                     <div class="form-group mb-3 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-calendar mr-1"></i>
                        <input type="date" class="form-control " id="Date" name="date"
                           placeholder="Ngày tiếp nhận" required>
                     </div>
                     <div class="form-group mb-3 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-user mr-1"></i>
                        <input type="text" class="form-control " id="Owner" name="owner-name"
                           placeholder="Tên chủ xe" required>
                     </div>
                     <div class="form-group mb-3 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-location-dot mr-1"></i>
                        <input type="text" class="form-control" id="Address" name="address"
                           placeholder="Địa chỉ" required>
                     </div>
                     <div class="form-group mb-3 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-phone mr-1"></i>
                        <input type="text" class="form-control" id="Phone" name="phone"
                           placeholder="Số điện thoại" required>
                     </div>
                     <div class="form-group mb-3 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-id-card mr-1"></i>
                        <input type="text" class="form-control" id="LisencePlate" name="licensePlate"
                           placeholder="Biển số" required>
                     </div>
                     <div class="form-group mb-3 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-car mr-1"></i>
                        <select class="form-select" id="carBrand" name="car-brand" required>
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
                        Thêm mới 
                        </button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <div class="history-supplies-root hidden">
         <div class="history-supplies container text-center">
            <i  class="fa-sharp fa-solid fa-square-xmark cancel" onclick="History()"></i>
            <h1 style="font-weight: 700;">LỊCH SỬ TIẾP NHẬN</h1>
            <div class="year-select d-flex justify-content-center align-items-center mb-3 ">
               <select name="month" style="width: 15%; margin-left: 10px;" class="form-select col-3 month selMonth" id="Year" required>
                  <option value="">Tháng</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
               </select>
               <select name="year" style="width: 15%;margin-right: 10px;" class="form-select col-3 year selYear" id="Year" required>
                  <option value="">Năm</option>
                  <option value="2022">2022</option>
                  <option value="2023">2023</option>
               </select>
               <button name="display" type="submit" class="btn btn-primary history"> 
                  Xem 
               </button>
            </div>
            <table class="table table-responsive table-striped table-hover ">
               <thead>
                  <tr>
                  <th class="col-1 text-center">STT</th>
                  <th class="col-2 text-center">Ngày tiếp nhận</th>
                  <th class="col-2 text-center">Thông tin xe</th>
                  <th class="col-5 text-center">Thông tin chủ xe</th>
                  </tr>
               </thead>
               <tbody id="History" style="cursor: pointer;" > 
               </tbody>
            </table>
         </div>
      </div>
   </body>
   <script src="./page2.js"></script>
</html>