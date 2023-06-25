<?php
    require '../../login-form/connect.php'; 

    if (isset($_POST['his'])){
        $his = $_POST['his'];

        $sel_psc="SELECT *, sum(ThanhTien) as TT, GROUP_CONCAT(TenVTPT SEPARATOR '<br>') as VTPT, GROUP_CONCAT(TenTienCong SEPARATOR '<br>') as TC FROM phieusuachua, ct_phieusuachua, vtpt, tiencong WHERE phieusuachua.SoPhieuSC = ct_phieusuachua.SoPhieuSC AND vtpt.MaVTPT = ct_phieusuachua.MaVTPT AND tiencong.MaTC = ct_phieusuachua.MaTC AND BienSo='$his' GROUP BY NgaySuaChua";
        $recordset=mysqli_query($conn,$sel_psc);
        $i=0;
        while ($rowData=mysqli_fetch_assoc($recordset)) {
            $i++;
            echo "<tr style='font-size: 14px;'>
                <td class='col-2 text-center'>
                <p><b>".$rowData['NgaySuaChua']."</b></p>
                </td>
                <td class='col-4 text-center' >
                <p class='mb-0'><b>".$rowData['VTPT']."</b></p>
                </td>
                <td class='col-4 text-center'>
                <p class='mb-0'><b>".$rowData['TC']."</b></p>
                </td>
                <td class='col-3 text-center'>
                <p style='color: red; font-size: 17px;'><b>".$rowData['TT']."</b></p>
                </td>";
        }
    }
?>