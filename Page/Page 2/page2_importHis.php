<?php
    require '../../login-form/connect.php'; 

    if (isset($_POST['MONTH']) && isset($_POST['YEAR'])){
        $getMonth = $_POST['MONTH'];
        $getYear = $_POST['YEAR'];

        $sel_history="SELECT * FROM phieutiepnhan WHERE MONTH(NgayTiepNhan) = '$getMonth' AND YEAR(NgayTiepNhan) = '$getYear'";
        $recordset=mysqli_query($conn,$sel_history);
        $i=0;
        while ($rowData=mysqli_fetch_assoc($recordset)) {
            $i++;
            echo "<tr style='font-size: 14px;'>
                    <td class='col-1 text-center'>
                    <p><b>".$i."</b></p>
                    </td>
                    <td class='col-3 text-center'>
                        <p><b>".$rowData['NgayTiepNhan']."</b></p>
                    </td>
                    <td class='col-3 text-center' >
                        <p class='mb-0'>Biển số: <b>".$rowData['BienSo']."</b></p>
                        <p class='mb-0'>Hiệu xe: <b>".$rowData['HieuXe']."</b></d>
                    </td>
                    <td class='col-5 text-center'>
                        <p class='mb-0'>Chủ xe: <b>".$rowData['TenKH']."</b></p>
                        <p class='mb-0'>Địa chỉ: <b>".$rowData['DiaChi']."</b></p>
                        <p class='mb-0'>Số điện thoại: <b>".$rowData['DienThoai']."</b></p>
                    </td>
                </tr>";
        }
    }
?>