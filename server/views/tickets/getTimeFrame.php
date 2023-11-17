<?php
    include("../base.php");
    if (!empty($_POST['tenPhim'])) {
        $movieID = $_POST['tenPhim'];
        
        $sql = "SELECT TenPhim, NgayChieu, GioChieu, ktg.MaKTG FROM ktg 
                INNER JOIN Lich_chieu ON ktg.MaKTG = lich_chieu.MaKTG 
                INNER JOIN phim ON lich_chieu.MaPhim = phim.MaPhim 
                WHERE phim.MaPhim = '$movieID'";
        $ktg = queryDB($sql);

        $optionsHTML = '';
        while ($row = mysqli_fetch_assoc($ktg)) {
            $optionsHTML .= "<option value='{$row['MaKTG']}'>{$row['NgayChieu']} - {$row['GioChieu']}</option>";
        }

        echo $optionsHTML;
    }
?>