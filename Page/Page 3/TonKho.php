<?php
    require '../../login-form/connect.php';
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
    <h1 class="title">QUẢN LÍ TỒN KHO</h1>
      <div class="container">
         <form method="POST" action="TonKho.php">
            <div class="year-select d-flex justify-content-center align-items-center mb-3 ">
                  <select name="month" style="width: 15%; margin-left: 10px;" class="form-select col-3 month" id="Year" required>
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
               <select name="year" style="width: 15%;margin-right: 10px;" class="form-select col-3 year" id="Year" required>
                  <option value="">Năm</option>
                  <option value="2022">2022</option>
                  <option value="2023">2023</option>
               </select>
               <button name="display" type="submit" class="btn btn-primary"> 
                  Xem 
               </button>
            </div>
         </form>
         <table class="table table-responsive table-striped table-hover">
            <thead>
               <tr class="text-center">
                  <th class="col-3">Tên vật liệu</th>
                  <th class="col-3">Nhà cung cấp</th>
                  <th class="col-2">Tồn đầu</th>
                  <th class="col-2">Phát sinh</th>
                  <th class="col-2">Tồn cuối</th>
               </tr>
            </thead>
            <tbody class="text-center">
               <?php
                  if($_SERVER['REQUEST_METHOD'] == "POST"){
                     $month = $_POST['month'];
                     $year = $_POST['year'];
                  } else{
                      error_reporting(0);
                      ini_set('display_errors',0);
                  }
                     $sel_Ton = "SELECT * FROM baocaoton, vtpt WHERE baocaoton.MaVTPT = vtpt.MaVTPT AND MONTH(ThangNam) = '$month' AND YEAR(ThangNam) = '$year'";
                     $recordset=mysqli_query($conn,$sel_Ton);
                     while ($rowData=mysqli_fetch_assoc($recordset)) {   
               ?>
                  <tr style="font-size: 14px;">
                     <td class="col-3" >
                        <p><b><?php echo $rowData['TenVTPT'];?></b></p>
                     </td>
                     <td class="col-3" >
                        <p><b><?php echo $rowData['TenNCC'];?></b></p>
                     </td>
                     <td class="col-2" >
                        <p><b><?php echo $rowData['TonDau'];?></b></p>
                     </td>
                     <td class="col-2">
                        <p><b><?php echo $rowData['PhatSinh'];?></b></p>
                     </td>
                     <td class="col-2">
                        <p><b><?php echo $rowData['TonCuoi'];?></b></p>
                     </td>
                  </tr>
               <?php
                  }
               ?>
            </tbody>
         </table>
      </div>
</body>
</html>