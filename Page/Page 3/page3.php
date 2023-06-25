<?php
    require '../../login-form/connect.php';
    session_start();
   if (isset($_COOKIE['getAmount'])){
      $getAmount = $_COOKIE['getAmount'];
   }
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="./page3.css">
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
                  url: "page3_history.php",
                  type: "POST",
                  data: {MONTH: selectMonth, YEAR: selectYear},
                  success: function(data){
                     $("#History").html(data);
                  }
               });
            });
         });
      </script>
      <h1 class="title">QUẢN LÍ KHO HÀNG</h1>
      <div class="container">
         <div class="container-heading">
            <form method="POST" action="page3.php">
               <div class="col-sm-12 col-xs-12">
                  <a href="#" class="btn btn-sm btn-primary fa-pull-left mb-1" onclick="Supplies()">
                  <i class="fa fa-plus-circle"></i> 
                  NHẬP HÀNG
                  </a>    
                  <a href="#" class="btn btn-sm btn-primary fa-pull-left mb-1" onclick="History()">
                     <i class="fa fa-plus-circle"></i> 
                     LỊCH SỬ NHẬP HÀNG
                     </a> 
                  <button name="search" class="btn btn-sm btn-dark fa-pull-right search">
                  <i class="fa fa-search"></i>
                  </button>
                  <input type="text" name="ValueSearch" id="search" class="fa-pull-right" placeholder="Tìm kiếm">
               </div>
            </form>
         </div>
         <table class="table table-responsive table-striped table-hover">
            <thead>
               <tr class="text-center">
                  <th class="col-3">Tên vật liệu</th>
                  <th class="col-2">Số lượng</th>
                  <th class="col-1">Đơn giá</th>
                  <th class="col-1"></th>
               </tr>
            </thead>
            <tbody class="text-center">
               <?php

                  if(isset($_POST['search']) && $_POST['search']!=" "){
                     $valueSearch = $_POST['ValueSearch'];
                     $sel_import_detail = "SELECT vtpt.MaVTPT as VT,vtpt.TenVTPT as VTPT,ct_phieunhapvtpt.SoPhieuNhap AS SPN, sum(SoLuong) AS SL, GROUP_CONCAT(distinct nhacungcap.TenNCC SEPARATOR ', ') AS NCC, DonGiaBan FROM phieunhapvtpt, ct_phieunhapvtpt, vtpt, nhacungcap WHERE phieunhapvtpt.SoPhieuNhap = ct_phieunhapvtpt.SoPhieuNhap AND vtpt.MaVTPT = ct_phieunhapvtpt.MaVTPT AND phieunhapvtpt.MaNCC = nhacungcap.MaNCC AND (nhacungcap.TenNCC LIKE '%$valueSearch%' OR TenVTPT LIKE '%$valueSearch%')";
                  } else {
                     $sel_import_detail = "SELECT vtpt.MaVTPT as VT,vtpt.TenVTPT as VTPT,ct_phieunhapvtpt.SoPhieuNhap AS SPN, sum(ct_phieunhapvtpt.SoLuong) AS SL, GROUP_CONCAT(distinct nhacungcap.TenNCC SEPARATOR ', ') AS NCC, DonGiaBan, TonKho, DonGiaGoc FROM phieunhapvtpt, ct_phieunhapvtpt, vtpt, nhacungcap WHERE phieunhapvtpt.SoPhieuNhap = ct_phieunhapvtpt.SoPhieuNhap AND vtpt.MaVTPT = ct_phieunhapvtpt.MaVTPT AND phieunhapvtpt.MaNCC = nhacungcap.MaNCC GROUP BY vtpt.TenVTPT ";
                  }
                  $recordset=mysqli_query($conn,$sel_import_detail);
                  while ($rowData=mysqli_fetch_assoc($recordset)){
               ?>
                  <tr style="font-size: 14px;">
                     <td class="col-3" >
                        <p><b><?php echo $rowData['VTPT'];?></b></p>
                     </td>         
                     <td class="col-1" >
                        <p><b><?php echo $rowData['TonKho']?></b></p>
                     </td>
                     <td class="col-1" >
                        <p><b><?php echo $rowData['DonGiaGoc'];?></b></p>
                     </td>
                     <td class="col-1 text-center">
                        <li class="d-inline-block"><a href="page3_del.php?id=<?php echo $rowData['VT']?>" class="btn btn-danger"><i class="fa fa-times"></i></a></li>
                     </td>
                  </tr>
               <?php
                  }
               ?>
            </tbody>
         </table>
      </div>
      <div class="add-supplies-root hidden">
         <form class="add-supplies-root" method="POST" action="page3_add.php">
            <div class="add-supplies container text-center ">
            <i  class="fa-sharp fa-solid fa-square-xmark cancel" onclick="Supplies()"></i>
            <h1 style="font-weight: 700;">PHIẾU NHẬP HÀNG</h1>
            <div class="year-select d-flex justify-content-center align-items-center mb-3 ">
               <input name="date" style="width: 200px; height: 32px; margin-right: 10px;" type="date" placeholder="Thời gian">
            </div>
            <table class="table table-responsive  ">
               <thead>
                  <tr class="text-center">
                     <th class="col-4">Tên vật liệu</th>
                     <th class="col-1">Số lượng</th>
                     <th class="col-1">Đơn giá</th>
                     <th class="col-5">Nhà cung cấp</th>
                  </tr>
               </thead>
               <tbody class="table table-striped ">
                     <div class="ele">
                        <tr style="font-size: 14px;">
                           <td class="col-4">
                              <div class="d-flex justify-content-center">
                                 <select name="suppliesName" class="form-select" id="supplyName" required>
                                    <option value="">-- Vật liệu --</option>
                                    <?php 
                                       $sel_supplier="SELECT * FROM vtpt";
                                       $recordset=mysqli_query($conn,$sel_supplier);
                                       while ($rowData=mysqli_fetch_assoc($recordset)) { 
                                    ?>
                                          <option value="<?php echo $rowData['TenVTPT'];?>"><?php echo $rowData['TenVTPT'];?></option>
                                    <?php 
                                       }
                                    ?>
                                 </select>
                              </div>
                           </td>
                           <td class="col-2">
                              <div class="d-flex justify-content-center">
                                 <input type="number" name="amount" class="form-control" aria-label="Number" aria-describedby="basic-addon1">
                              </div>
                           </td>
                           <td class="col-2">
                              <div class="d-flex justify-content-center">
                                 <input type="number" name="price" class="form-control" aria-label="Number" aria-describedby="basic-addon1">
                              </div>
                           </td>
                           <td class="col-5">
                              <div class="d-flex justify-content-center">
                                 <select name="supplierName" class="form-select" id="Reason" required>
                                    <option value="">-- Nhà cung cấp --</option>
                                    <?php 
                                       $sel_supplier="SELECT * FROM nhacungcap";
                                       $recordset=mysqli_query($conn,$sel_supplier);
                                       while ($rowData=mysqli_fetch_assoc($recordset)) {
                                    ?>
                                          <option value="<?php echo $rowData['TenNCC'];?>"><?php echo $rowData['TenNCC'];?></option>
                                    <?php 
                                       }
                                    ?>
                                 </select>
                              </div>
                           </td>             
                        </tr>
                     </div>
                  </tbody>
               </table>
               <div class="form-group mb-3 d-flex justify-content-center">
                  <button name="add-new" type="submit" class="btn btn-primary" onclick="">
                  <i class="fa fa-plus-circle mr-1"></i> 
                  NHẬP HÀNG
                  </button>
               </div>
            </div>
         </form>
      </div>                          
      <div class="history-supplies-root hidden">
         <div class="history-supplies container text-center" style="width: 90%">
            <i  class="fa-sharp fa-solid fa-square-xmark cancel" onclick="History()"></i>
            <h1 style="font-weight: 700;">LỊCH SỬ NHẬP HÀNG</h1>
            <div class="year-select d-flex justify-content-center align-items-center mb-3 ">
               <select style="width: 15%; margin-left: 10px;" class="form-select col-3 selMonth" id="Year" required>
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
              <select style="width: 15%;margin-right: 10px;" class="form-select col-3 selYear" id="Year" required>
               <option value="">Năm</option>
                 <option value="2022">2022</option>
                 <option value="2023">2023</option>
              </select>
              <button type="submit" class="btn btn-primary history"> 
                Xem 
             </button>
            </div>
             <table class="table table-responsive table-striped table-hover">
               <thead>
                  <tr class="text-center">
                     <th class="col-2">Ngày nhập</th>
                     <th class="col-2">Nhà cung cấp</th>
                     <th class="col-3">Vật tư phụ tùng</th>
                     <th class="col-2">Số lượng</th>
                     <th class="col-1">Đơn giá</th>
                     <th class="col-3">Thành tiền</th>
                  </tr>
               </thead>
               <tbody id="History" class="text-center">
               </tbody>
            </table>
         </div>
      </div>
   </body>
   <script src="./page3.js"></script>
</html>