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
        PHIẾU SỬA CHỮA
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

        <div class="supplies">
            <h1 style="font-weight: 700;">VẬT LIỆU SỬA CHỮA</h1>
            <table class="table table-responsive table-striped">
               <thead>
                  <tr class="text-center">
                     <th class="col-3">Tên vật liệu</th>
                     <th class="col-3">Đơn giá</th>
                     <th class="col-2">Số lượng</th>
                     <th class="col-3">Giá tiền</th>
                     <th class="col-3"></th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                     $strsql="SELECT TiLeTinhDonGiaBan FROM thamso";
                     $resSQL=mysqli_query($conn,$strsql);
                     $get_array=mysqli_fetch_assoc($resSQL);
                     $getRate=$get_array['TiLeTinhDonGiaBan'];

                     $query_SP = "SELECT SoPhieuSC FROM phieusuachua WHERE BienSo = '$getID'";
                     if (mysqli_num_rows(mysqli_query($conn,$query_SP)) > 0){
                        $querySoPhieu = mysqli_query($conn,"SELECT SoPhieuSC FROM phieusuachua WHERE BienSo = '$getID'");
                        $getSoPhieu = mysqli_fetch_row($querySoPhieu);
                        $resSoPhieu = $getSoPhieu[0];  // get SoPhieuSC

                     $sel_vtpt="SELECT TenVTPT,sum(SoLuong) as SL, sum(ThanhTien) as TT, DonGiaBan FROM ct_phieusuachua, vtpt WHERE vtpt.MaVTPT=ct_phieusuachua.MaVTPT AND SoPhieuSC=$resSoPhieu GROUP BY ct_phieusuachua.MaVTPT";
                     $recordset=mysqli_query($conn,$sel_vtpt);
                     while ($rowData=mysqli_fetch_assoc($recordset)) {
                  ?>
                     <div class="ele">
                        <tr style="font-size: 14px;">
                           <td class="col-3 text-center">
                              <p><b><?php echo $rowData['TenVTPT']?></b></p>
                           </td>
                           <td class="col-1 text-center" >
                              <p><b><?php echo $rowData['DonGiaBan']?></b></p>
                           </td>
                           <td class="col-1 text-center" >
                              <p><b><?php echo $rowData['SL']?></b></p>
                           </td>
                           <td class="col-2 text-center">
                              <p><b><?php echo $rowData['SL']*$rowData['DonGiaBan']?></b></p>
                           </td>
                           <td class="col-1 text-center">
                              <li class="d-inline-block"><a href="#" class="btn btn-danger"><i class="fa fa-times"></i></a></li>
                           </td>
                        </tr>
                     </div>
                  <?php
                     }
                  }
                  ?>
               </tbody>
            </table>
        </div>

        <div class="cost">
            <h1 style="font-weight: 700;">TIỀN CÔNG</h1>
            <table class="table table-responsive table-striped">
               <thead>
                  <tr class="text-center">
                     <th class="col-7">Tên tiền công</th>
                     <th class="col-3">Giá tiền</th>
                     <th class="col-2"></th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                     $query_SP = "SELECT SoPhieuSC FROM phieusuachua WHERE BienSo = '$getID'";
                     if (mysqli_num_rows(mysqli_query($conn,$query_SP))){
                        $querySoPhieu = mysqli_query($conn,"SELECT SoPhieuSC FROM phieusuachua WHERE BienSo = '$getID'");
                        $getSoPhieu = mysqli_fetch_row($querySoPhieu);
                        $resSoPhieu = $getSoPhieu[0];  // get SoPhieuSC

                     $sel_cost="SELECT * FROM ct_phieusuachua, tiencong WHERE ct_phieusuachua.MaTC=tiencong.MaTC AND SoPhieuSC=$resSoPhieu";
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
                  }
                  ?>
               </tbody>
            </table>
        </div>

        <!-- TONG TIEN -->
        <div style="left: 70%;" class="total">
        <?php
         if (mysqli_num_rows(mysqli_query($conn,"SELECT * FROM ct_phieusuachua, phieusuachua WHERE ct_phieusuachua.SoPhieuSC = phieusuachua.SoPhieuSC AND phieusuachua.BienSo = '$getID'")) > 0){
               $queryTong = mysqli_query($conn,"SELECT sum(ThanhTien) FROM ct_phieusuachua, phieusuachua WHERE ct_phieusuachua.SoPhieuSC = phieusuachua.SoPhieuSC AND phieusuachua.BienSo = '$getID'");
               $getTong = mysqli_fetch_row($queryTong);
               $resTong = $getTong[0]; 
               echo "<p><b>Tổng tiền:   </b><b style='color: red;'>".$resTong." $</b>   </p>";
         }
         ?>
         <form method="POST" action="update_state.php?id=<?php echo $getID?>">
            <button name="confirm" type="submit" class="btn btn-primary mt-1 mb-3" > 
                XÁC NHẬN
            </button>
         </form>
        </div>
    </div>

    <!-- FORM VAT TU PHU TUNG -->
    <div class="supplies-form-root hidden">
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
           <button name="add-new" type="submit" class="btn btn-primary mt-1" > 
            THÊM
         </button> 
        </div>
      </form>
    </div>

</body>
    <script src="page2.js"></script>
</html>