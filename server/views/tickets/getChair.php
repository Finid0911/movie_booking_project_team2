<?php
    include("../base.php");
    $timeFrame = null;
    if (!empty($_POST['ktg'])) {
        $timeFrame = $_POST['ktg'];
        
        $sql = "SELECT phong.MaPhong, ghe.MaGhe, ktg.MaKTG, ghe.SoGhe, TenPhong  
                    FROM ktg INNER JOIN lich_chieu ON ktg.MaKTG = lich_chieu.MaKTG
                    INNER JOIN phong ON lich_chieu.MaPhong = phong.MaPhong
                    INNER JOIN ghe ON phong.MaPhong = ghe.MaPhong
                    INNER JOIN so_ghe ON so_ghe.SoGhe = ghe.SoGhe 
                    INNER JOIN trang_thai ON ghe.MaTT = trang_thai.MaTT 
                    WHERE ktg.MaKTG = '$timeFrame' AND trang_thai.MaTT = '0'";
        
        $chair = queryDB($sql);

        $optionsHTML = '';
        while ($row = mysqli_fetch_assoc($chair)) {
            $optionsHTML .= "<option value='{$row['SoGhe']}'> {$row['SoGhe']} - {$row['TenPhong']}</option>";
        }

        echo $optionsHTML;
    }
?>