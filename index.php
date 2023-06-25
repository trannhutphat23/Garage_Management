<?php
    require 'login-form/connect.php';
    session_start();
    if (isset($_COOKIE['getInfo'])){
       $getInfo=$_COOKIE['getInfo'];
    }
    $querySupplier = mysqli_query($conn,"SELECT ID_PERMISSION FROM user, user_info WHERE user.USER_ID = user_info.ID_USER AND INFO_NAME = '$getInfo'");
    $getSupplierID = mysqli_fetch_row($querySupplier);
    $resSupplierID = $getSupplierID[0]; //MaNCC
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="fontawesome-free-6.3.0-web/fontawsome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@100;300;400;700&display=swap"
        rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <title>Quản lý Gara ô tô - Nhóm 18</title>
</head>

<body class="hstack body_content">
    <script>
        $(document).ready(function(){
            $("#logout").click(function(){
                window.location.replace("logout.php");
            });
            $per = $("#getValue").val();
            var Button2 = document.querySelector('.selector-2');
            var Page2 = document.querySelector('.page-2');

            function viewPage2() {
                Page2.classList.remove("hidden");
                Button2.classList.add("onChose");
            }

            if ($per==2){
                $(".selector-1").hide();
                $(".selector-4").hide();
                $(".selector-5").hide();
                $(".page-1").hide();
                viewPage2();
            }
        });
        window.history.forward();
    </script>
    <input value=<?php echo $resSupplierID?> class="hidden" id="getValue" type="text">
    <div class="menu">
        <img src="logo.png" alt="logo-img">
        <nav class="vstack">
            <button class="ele selector-1 onChose" onclick="viewPage1()">
                <i class="fa-solid fa-house"></i>
                <p>Thống kê & báo cáo</p>
            </button>
            <button class="ele selector-2 " onclick="viewPage2()">
                <i class="fa-solid fa-taxi"></i>
                <p>Quản lí & sửa chữa</p>
                <i style="font-size: 20px;" class="ok2 fa-solid fa-caret-left"></i>
            </button>
            <div class="dropdown2 hidden">
                <div class="more2 hi">
                    <div onclick="Chose2(this); viewPage21()" class="Chose">
                        <i class="fa-regular fa-circle-dot"></i>
                        <p>Phiếu tiếp nhận xe</p>
                    </div>
                    <div id="loadRepair" onclick="Chose2(this); viewPage22()">
                        <i class="fa-regular fa-circle"></i>
                        <p>Phiếu sửa chữa</p>
                    </div>
                    <div id="loadSearch" onclick="Chose2(this); viewPage23()">
                        <i class="fa-regular fa-circle"></i>
                        <p>Tra cứu xe</p>
                    </div>
                </div>
            </div>
            <button id="loadWarehouse" class="ele selector-3" onclick="viewPage3()">
                <i class="fa-solid fa-warehouse"></i>
                <p>Kho hàng</p>
                <i style="font-size: 20px;" class="ok3 fa-solid fa-caret-left"></i>
            </button>
            <div class="dropdown3 hidden">
                <div class="more3">
                    <div onclick="Chose3(this); viewPage31()" class="Chose">
                        <i class="fa-regular fa-circle-dot"></i>
                        <p>Quản lí kho hàng</p>
                    </div>
                    <div onclick="Chose3(this); viewPage32()">
                        <i class="fa-regular fa-circle"></i>
                        <p>Quản lí tồn kho</p>
                    </div>
                </div>
            </div>
            <button id="loadFrame1" class="ele selector-4" onclick="viewPage4()">
                <i class="fa-solid fa-id-card"></i>
                <p>Quản lí nhân viên</p>
            </button>
            <button class="ele selector-5" onclick="viewPage5()">
                <i class="fa-solid fa-list"></i>
                <p>Quản lí chung</p>
                <i style="font-size: 20px;" class="ok5 fa-solid fa-caret-left"></i>
            </button>
            <div class="dropdown5 hidden">
                <div class="more5">
                    <div onclick="Chose5(this); viewPage51()" class="Chose">
                        <i class="fa-regular fa-circle-dot"></i>
                        <p>Quản lí hiệu xe</p>
                    </div>
                    <div onclick="Chose5(this); viewPage52()">
                        <i class="fa-regular fa-circle"></i>
                        <p>Quản lí nhà cung cấp</p>
                    </div>
                    <div id="loadFrame2" onclick="Chose5(this); viewPage53()">
                        <i class="fa-regular fa-circle"></i>
                        <p>Quản lí vật tư</p>
                    </div>
                    <div onclick="Chose5(this); viewPage54()">
                        <i class="fa-regular fa-circle"></i>
                        <p>Quản lí tiền công</p>
                    </div>
                </div>
            </div>
        </nav>
        <nav class="hstack infouser">
            <div class="user">
                <p><b><?php echo $getInfo?></b></p>
            </div>
            <i id="logout" class="fa-solid fa-right-from-bracket logout"></i>
        </nav>
        <nav class="hstack infouser" onclick="Setting()">
            <div class="setting">
                <i class="fa-solid fa-gear"></i>
                <p><b>Cài đặt chung</b></p>
            </div>
        </nav>
    </div>
    <div class="page">
        <form method="POST" action="update.php">
            <div class="settingSCR hidden">
                <?php 
                    $query = mysqli_query($conn,"SELECT * FROM thamso");
                    $get = mysqli_fetch_row($query);
                    $resNumcar = $get[0]; 
                    $resNumcarBrand = $get[1]; 
                    $resRate = $get[2]; 
                    $resVTPT = $get[3]; 
                    $resTC = $get[4]; 
                ?>
                <p>Số xe nhận trong ngày: <b><?php echo $resNumcar?></b> <input name="numCaraDay" type="number"></p>
                <p>Tỉ lệ tính đơn giá bán: <b><?php echo $resRate?></b><b>%</b> <input name="numRate" type="number"></p>
                <p>Số lượng hiệu xe tối đa: <b><?php echo $resNumcarBrand?></b> <input name="maxCar" type="number"></p>
                <p>Số loại vật tư trong kho: <b><?php echo $resVTPT?></b> <input name="numSupply" type="number"></p>
                <p>Số loại tiền công: <b><?php echo $resTC?></b> <input name="numCost" type="number"></p>
                <button name="update_button" type="submit" class="btn btn-primary mb-2">
                    <i class="fa fa-plus-circle mr-1"></i> 
                    Cập nhật
                </button>
            </div>
        </form>
        <div class="p-ele page-1  ">
            <iframe src="./Page/Page 1/page1.php"></iframe>
        </div>
        <div class="p-ele page-2 hidden ">
            <iframe src="./Page/Page 2/page2.php" class="is1 "></iframe>
            <iframe id="loadIRepair" src="./Page/Page 2/repair.php" class="is2 hidden "></iframe>
            <iframe id="loadISearch" src="./Page/Page 2/search.php" class="is3 hidden"></iframe>
        </div>
        <div class="p-ele page-3 hidden">
            <iframe id="loadIframe3" src="./Page/Page 3/page3.php" frameborder="0" class="it1 "></iframe>
            <iframe src="./Page/Page 3/TonKho.php" frameborder="0" class="it2 hidden "></iframe>
        </div>
        <div class="p-ele page-4 hidden ">
            <?php
                echo "<iframe id='loadIframe1' src='./Page/Page 4/page4.php'></iframe>";
            ?>
        </div>
        <div class="p-ele page-5 hidden">
            <iframe src="./Page/Page 5/CarBrand.php" frameborder="0" class="if1 "></iframe>
            <iframe src="./Page/Page 5/Supplier.php" frameborder="0" class="if2 hidden "></iframe>
            <iframe id="loadIframe2" src="./Page/Page 5/Supplies.php" frameborder="0" class="if3 hidden"></iframe>
            <iframe src="./Page/Page 5/Cost.php" frameborder="0" class="if4 hidden"></iframe>
        </div>
    </div>


</body>
<script src="index.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>

</html>