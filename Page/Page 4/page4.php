<?php
   require '../../login-form/connect.php'; 
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="./page4.css">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
      <link rel="stylesheet" href="../fontawsome/css/all.min.css">
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@100;300;400;700&display=swap" rel="stylesheet">
      <title>Document</title>
   </head>
   <body>
      <h1 class="title">QUẢN LÍ NHÂN VIÊN</h1>
      <div class="container">
         <div class="container-heading">
            <form method="POST" action="page4.php">
               <div class="col-sm-12 col-xs-12">
                  <a href="#" class="btn btn-sm btn-primary fa-pull-left mb-1" onclick="Staff()">
                  <i class="fa fa-plus-circle"></i> 
                  THÊM MỚI
                  </a>      
                  <button name="search" class="btn btn-sm btn-dark fa-pull-right">
                  <i class="fa fa-search"></i>
                  </button>
                  <input type="text" name="ValueSearch" id="search" class="fa-pull-right" placeholder="Tìm kiếm">
               </div>
            </form>
         </div>
         <table class="table table-responsive table-striped ">
            <thead>
               <tr>
                  <th>#</th>
                  <th class="col-3">Tên nhân viên</th>
                  <th class="col-4">Thông tin</th>
                  <th class="col-2">Quyền hạn</th>
                  <th class="col-2"></th>
               </tr>
            </thead>
            <tbody>
               <?php
                  if(isset($_POST['search']) && $_POST['search']!=" "){
                     $valueSearch = $_POST['ValueSearch'];
                     $sel_user="SELECT * FROM user, user_info, permission WHERE user.USER_ID = user_info.ID_USER AND user.ID_PERMISSION = permission.PERMISSION_ID AND (iNFO_NAME LIKE '%$valueSearch%' OR CCCD LIKE '%$valueSearch%' OR ADDRESS LIKE '%$valueSearch%' OR INFO_NAME LIKE '%$valueSearch%' OR PERMISSION_NAME LIKE '%$valueSearch%')";
                  }else{
                     $sel_user="SELECT * FROM user, user_info, permission WHERE user.USER_ID = user_info.ID_USER AND user.ID_PERMISSION = permission.PERMISSION_ID";
                  }
                  $recordset=mysqli_query($conn,$sel_user);
                  $i=0;
                  while ($rowData=mysqli_fetch_assoc($recordset)) {
                     $i++;
               ?>
                  <div class="ele">
                     <tr style="font-size: 14px;">
                        <td>
                           <p><b><?php echo $i;?></b></p>
                        </td>
                        <td class="col-3" >
                           <p"><b><?php echo $rowData['INFO_NAME'];?></b></p>
                        </td>
                        <td class="col-5">
                           <p class="mb-0">Số CCCD: <b><?php echo $rowData['CCCD'];?></b></p>
                           <p class="mb-0">Số điện thoại: <b><?php echo $rowData['INFO_PHONE'];?></b></p>
                           <p class="mb-0">Địa chỉ: <b><?php echo $rowData['ADDRESS'];?></b></p>
                           <p class="mb-0">Ngày vào làm: <b><?php echo $rowData['WORK_DATE'];?></b></p>
                        </td>
                        <td class="col-2">
                           <p><b><?php echo $rowData['PERMISSION_NAME'];?></b></p>
                        </td>
                        <td class="col-1 text-center">
                           <ul class="action-list " style="list-style: none; font-size:15px;">
                              <li class="d-inline-block"><a href="page4_del.php?id=<?php echo $rowData['INFO_ID'];?>" class="btn btn-danger"><i class="fa fa-times"></i></a></li>
                           </ul>
                        </td>
                     </tr>
                  </div>
               <?php
                  }
               ?>
            </tbody>
         </table>
      </div>
      <div class="staff-root hidden">
         <div class="staff container text-center ">
            <form action=""></form>
            <i class="fa-sharp fa-solid fa-square-xmark cancel" onclick="Staff()"></i>
            <h1 style="font-weight: 700;">THÊM NHÂN VIÊN</h1>
            <div class="row mt-3 d-flex justify-content-center">
               <div class="col-12 col-md-6">
                  <form class="form-inline" method="POST" action="page4_add.php">
                     <div class="form-group mb-3 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-user mr-1"></i>
                        <input type="text" class="form-control" id="Owner" name="employeeName"
                           placeholder="Tên nhân viên" required>
                     </div>
                     <div class="form-group mb-3 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-id-card mr-1"></i>
                        <input type="text" class="form-control" id="LisencePlate" name="CCCD"
                           placeholder="CCCD" required>
                     </div>
                     <div class="form-group mb-3 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-phone mr-1"></i>
                        <input type="text" class="form-control" id="Phone" name="phoneNumber"
                           placeholder="Số điện thoại" required>
                     </div>
                     <div class="form-group mb-3 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-location-dot mr-1"></i>
                        <input type="text" class="form-control" id="Address" name="address"
                           placeholder="Địa chỉ" required>
                     </div>
                     <div class="form-group mb-3 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-calendar-days mr-1"></i>
                        <input type="date" class="form-control" id="Date" name="workDate"
                           placeholder="Ngày vào làm" required>
                     </div>
                     <div class="form-group mb-3 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary" name="add-new">
                        <i class="fa fa-plus-circle mr-1"></i> 
                        Thêm mới 
                        </button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <div class="staff-edit-root hidden">
         <div class="staff-edit container text-center ">
            <i class="fa-sharp fa-solid fa-square-xmark cancel" onclick="StaffEdit()"></i>
            <h1 style="font-weight: 700;">SỬA THÔNG TIN NHÂN VIÊN</h1>
            <div class="row mt-3 d-flex justify-content-center">
               <div class="col-12 col-md-6">
                  <form class="form-inline">
                     <div class="form-group mb-3 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-user mr-1"></i>
                        <input type="text" class="form-control" id="Owner"
                           placeholder="Tên nhân viên" required>
                     </div>
                     <div class="form-group mb-3 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-id-card mr-1"></i>
                        <input type="text" class="form-control" id="LisencePlate"
                           placeholder="CCCD" required>
                     </div>
                     <div class="form-group mb-3 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-phone mr-1"></i>
                        <input type="text" class="form-control" id="Phone" 
                           placeholder="Số điện thoại" required>
                     </div>
                     <div class="form-group mb-3 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-location-dot mr-1"></i>
                        <input type="text" class="form-control" id="Address" 
                           placeholder="Địa chỉ" required>
                     </div>
                     <div class="form-group mb-3 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-calendar-days mr-1"></i>
                        <input type="date" class="form-control" id="Date" 
                           placeholder="Ngày vào làm" required>
                     </div>
                     <div class="form-group mb-3 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-pen"></i>
                        <select class="form-select" id="carBrand" required>
                           <option value="">-- Quyền hạn --</option>
                           <option value="option1">Option 1</option>
                           <option value="option2">Option 2</option>
                        </select>
                     </div>
                     <div class="form-group mb-3 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">
                        <i class="fa fa-plus-circle mr-1"></i> 
                        CẬP NHẬT
                        </button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </body>
   <script src="./page4.js"></script>
</html>