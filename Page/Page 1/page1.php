<?php
    require '../../login-form/connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device
    -width, initi
    al-scccol.0">
    <link rel="stylesheet" href="./page1.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="../fontawsome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@100;300;400;700&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <h1 class="title">DOANH THU</h1>
    <div class="container col-sm-12 col-xs-12 ">
        <div class="container-heading">
          <form method="POST" action="page1.php">
            <div class="d-flex flex-row justify-content-between col-sm-12 col-xs-12 mb-1">
                <div class="d-flex flex-row col-sm-3 col-xs-3">
                    <select name="month" class="form-select" id="Month" required>
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
                     <select name="year" class="form-select" id="Year" required>
                     <option value="">Năm</option>
                         <option value="2021">2021</option>
                         <option value="2022">2022</option>
                         <option value="2023">2023</option>
                      </select>
                      <button name="display" type="submit" class="btn btn-primary"> 
                        Xem 
                     </button>
                </div>
                 <!-- <button type="submit" class="btn btn-success" onclick="Form()"> 
                    Xem doanh thu
                 </button> -->
            </div>
          </form>  
        </div>
        
        <table class="table table-responsive table-striped table-hover ">
            <thead>
                <tr>
                    <th class="col-1 text-center">#</th>
                    <th class="col-3 text-center">Hiệu xe</th>
                    <th class="col-2 text-center">Số lượt sửa</th>
                    <th class="col-2 text-center">Doanh thu</th>
                    <th class="col-2 text-center">Tỷ lệ</th>
                </tr>
            </thead>
            <tbody>
              <?php
                if($_SERVER['REQUEST_METHOD'] == "POST"){
                  $month = $_POST['month'];
                  $year = $_POST['year'];  
                } else{
                  error_reporting(0);
                  ini_set('display_errors',0);
                }    
                  date_default_timezone_set('Asia/Ho_Chi_Minh');
                  $rec_date = date('Y-m-d h:i:s a', time());
                  $YEAR = date('Y', time());
                  $YEAR_INT = (int)$YEAR;
                  $MONTH = date('m', time());
                  $MONTH_INT = (int)$MONTH;
                  $slBCDT="SELECT * FROM baocaodoanhthu WHERE month(Thang_Nam)=$month AND year(Thang_Nam)=$year";
                  $recBCDT=mysqli_num_rows(mysqli_query($conn,$slBCDT));
                  if ($recBCDT==0){
                    if ($month > $MONTH_INT || $year > $YEAR_INT) {
                      echo "<script> alert('Ngày lớn hơn ngày hiện tại'); window.location.href='page1.php'</script>";
                    }else{
                      echo "<script> alert('Không có dữ liệu'); window.location.href='page1.php'</script>";
                    }
                  }
                  else{
                    $querySales = mysqli_query($conn,"SELECT sum(ThanhTien) as TT FROM baocaodoanhthu WHERE month(Thang_Nam)=$month AND year(Thang_Nam)=$year");
                    $getSales = mysqli_fetch_row($querySales);
                    $resSales = $getSales[0]; //TongTien
                    $conn->query("UPDATE baocaodoanhthu SET TiLe = (ThanhTien/$resSales)*100");
                    // $sel_doanhThu = "SELECT * FROM baocaodoanhthu, hieuxe WHERE baocaodoanhthu.MaHieuXe=hieuxe.MaHieuXe AND (month(Thang_Nam)=$month AND year(Thang_Nam)=$year)";
                    $sel_doanhThu = "SELECT *,count(DISTINCT phieuthutien.BienSo) as SLS FROM phieuthutien, xe, hieuxe, baocaodoanhthu WHERE phieuthutien.BienSo=xe.BienSo AND hieuxe.MaHieuXe=xe.MaHieuXe AND baocaodoanhthu.MaHieuXe=hieuxe.MaHieuXe AND (month(Thang_Nam)=$month AND year(Thang_Nam)=$year) GROUP BY TenHieuXe";

                    $recordset=mysqli_query($conn,$sel_doanhThu);
                    $i=0;
                    while ($rowData=mysqli_fetch_assoc($recordset)) {
                      $i++;         
              ?>
                <div class="ele">
                    <tr style="font-size: 14px;">
                        <td class="col-1 text-center"><p><b><?php echo $i?></b></p></td>
                        <td class="col-3 text-center">
                            <p class="mb-0"><b><?php echo $rowData['TenHieuXe'];?></b></p>
                        </td>
                        <td class="col-2 text-center">
                            <p class="mb-0"><b><?php echo $rowData['SLS'];?></b></p>
                        </td>
                        <td class="col-2 text-center">
                            <p class="mb-0"><b><?php echo $rowData['ThanhTien'];?></b></p>
                        </td>
                        <td class="col-2 text-center">
                            <p class="mb-0"><b><?php echo $rowData['TiLe'];?> %</b></p>
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
    <div class="total text-center">
      <?php
          echo "<p>Tổng doanh thu:   <b>".$resSales."</b>   $</p>";
      ?>   
  </div>
</body>
    <script src="page1.js"></script>
</html>