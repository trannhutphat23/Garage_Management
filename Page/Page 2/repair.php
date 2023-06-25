<?php
   require '../../login-form/connect.php';
   session_start();
   // if (isset($_SESSION['user_id'])) {
   //    $temp=$_SESSION['user_id'];
   // }
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
      <h1 class="title" >SỬA CHỮA</h1>
      <div class="container">
         <div class="container-heading">
            <form method="POST" action="repair.php">
               <div class="col-sm-12 col-xs-12">               
                  <!-- BUTTON TÌM KIẾM THƯỜNG -->
                  <button name="search" class="btn btn-sm btn-dark fa-pull-right search">
                     <i class="fa fa-search"></i>
                  </button>
                  <input type="text" name="ValueSearch" id="search" class="fa-pull-right mb-2" placeholder="Tìm kiếm">   
               </div>
            </form>
         </div>

         <!-- THÔNG TIN TIẾP NHẬN XE -->
         <table class="table table-responsive table-striped table-hover ">
            <thead>
               <tr>
               <th class=" text-center">STT</th>
               <th class="col-2 text-center">Ngày tiếp nhận</th>
               <th class="col-2 text-center">Thông tin xe</th>
               <th class="col-4 text-center">Thông tin chủ xe</th>
               <th class="col-2 text-center"></th>
               <th class="col-4 text-center"></th>
               </tr>
            </thead>
            <tbody style="cursor: pointer;" >
               <?php 
                  // Search
                  if(isset($_POST['search']) && $_POST['search']!=" "){
                     $valueSearch = $_POST['ValueSearch'];
                     $sel_cus = "SELECT * FROM ((SELECT HieuXe,DiaChi,DienThoai,TenKH,BienSo,NgayTiepNhan,TinhTrang,day(NgayTiepNhan) as dday from phieutiepnhan) b INNER JOIN (SELECT BienSo,max(day(NgayTiepNhan)) as maxDay FROM phieutiepnhan GROUP BY BienSo) a on a.BienSo = b.BienSo AND a.maxDay = b.dday) WHERE (a.BienSo LIKE '%$valueSearch%' OR  TenKH LIKE '%$valueSearch%' OR HieuXe LIKE '%$valueSearch%' OR DiaChi LIKE '%$valueSearch%' OR DienThoai LIKE '%$valueSearch%' OR TinhTrang LIKE '%$valueSearch%')";
                  }
                  else{
                     $sel_cus="SELECT * FROM ((SELECT HieuXe,DiaChi,DienThoai,TenKH,BienSo,NgayTiepNhan,TinhTrang,day(NgayTiepNhan) as dday from phieutiepnhan) b INNER JOIN (SELECT BienSo,max(day(NgayTiepNhan)) as maxDay FROM phieutiepnhan GROUP BY BienSo) a on a.BienSo = b.BienSo AND a.maxDay = b.dday)";
                  }
                  $recordset=mysqli_query($conn,$sel_cus);
                  $i=0;
                  while ($rowData=mysqli_fetch_assoc($recordset)) {
                     $i++;
               ?>
                  <tr style="font-size: 14px;">
                     <td class="text-center">
                        <p><b><?php echo $i ?></b></p>
                     </td>
                     <td class="col-2 text-center">
                           <p><b><?php echo $rowData['NgayTiepNhan']; ?></b></p>
                     </td>
                     <td class="col-2 text-center" >
                           <p class="mb-0">Biển số: <b><?php echo $rowData['BienSo']; ?></b></p>
                           <p class="mb-0">Hiệu xe: <b><?php echo $rowData['HieuXe'];?></b></d>
                     </td>
                     <td class="col-4 text-center">
                           <p class="mb-0">Chủ xe: <b><?php echo $rowData['TenKH']?></b></p>
                           <p class="mb-0">Địa chỉ: <b><?php echo $rowData['DiaChi']?></b></p>
                           <p class="mb-0">Số điện thoại: <b><?php echo $rowData['DienThoai']?></b></p>
                     </td>
                     <td class="col-2 text-center">
                           <p><b><?php echo $rowData['TinhTrang']?></b></p>
                     </td>
                     <td class="col-4 text-center">
                        <ul class="action-list " style="list-style: none; font-size:15px;">
                           <li class="d-inline-block"><a href="./detail_repair.php?id=<?php echo $rowData['BienSo'];?>" class="btn btn-primary"><i class="fa-solid fa-screwdriver-wrench"></i></a></li>
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
   </body>
   <script src="./page2.js"></script>
</html>