<?php
    require '../../login-form/connect.php'; 

    if (isset($_POST['MONTH']) && isset($_POST['YEAR'])){
        $getMonth = $_POST['MONTH'];
        $getYear = $_POST['YEAR'];
        $sel_his = "SELECT nhacungcap.TenNCC as NCC, TenVTPT, SoLuong, NgayNhap, DonGiaNhap, ThanhTien FROM ct_phieunhapvtpt, phieunhapvtpt, vtpt, nhacungcap WHERE ct_phieunhapvtpt.SoPhieuNhap = phieunhapvtpt.SoPhieuNhap AND ct_phieunhapvtpt.MaVTPT = vtpt.MaVTPT AND phieunhapvtpt.MaNCC = nhacungcap.MaNCC AND MONTH(phieunhapvtpt.NgayNhap) = $getMonth and YEAR(phieunhapvtpt.NgayNhap) = '$getYear'";
        // $sel_his = "SELECT nhacungcap.TenNCC AS NCC, sum(SoLuong) AS SL, GROUP_CONCAT(distinct vtpt.TenVTPT SEPARATOR '\n') AS VTPT FROM phieunhapvtpt, ct_phieunhapvtpt, vtpt, nhacungcap WHERE phieunhapvtpt.SoPhieuNhap = ct_phieunhapvtpt.SoPhieuNhap AND vtpt.MaVTPT = ct_phieunhapvtpt.MaVTPT AND phieunhapvtpt.MaNCC = nhacungcap.MaNCC AND MONTH(phieunhapvtpt.NgayNhap) = $getMonth and YEAR(phieunhapvtpt.NgayNhap) = '$getYear' GROUP by nhacungcap.TenNCC";
        $recordset=mysqli_query($conn,$sel_his);
        while ($rowData=mysqli_fetch_assoc($recordset)) {
            echo " <tr style='font-size: 14px;'>
                        <td class='col-5' >
                            <p><b>".$rowData['NgayNhap']."</b></p>
                        </td>
                        <td class='col-5' >
                            <p><b>".$rowData['NCC']."</b></p>
                        </td>
                        <td class='col-5' >
                            <p><b>".$rowData['TenVTPT']."</b></p>
                        </td>
                        <td class='col-2'>
                            <p><b>".$rowData['SoLuong']."</b></p>
                        </td>
                        <td class='col-2'>
                            <p><b>".$rowData['DonGiaNhap']."</b></p>
                        </td>
                        <td class='col-2'>
                            <p><b>".$rowData['ThanhTien']."</b></p>
                        </td>
                    </tr>";
        }
    }
?>