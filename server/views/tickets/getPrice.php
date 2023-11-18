<?php
    include("../base.php");
    if (!empty($_POST['tenPhim']) && !empty($_POST['ktg']) && !empty($_POST['chair'])) {
        $timeFrame = $_POST['ktg'];
        $movieID = $_POST['tenPhim'];
        $chairID = $_POST['chair'];
        
        $sql = "SELECT distinct gia.MaGia, DonGia FROM gia INNER JOIN Bao_Gia ON gia.MaGia = Bao_gia.MaGia 
                                    INNER JOIN dinh_dang ON Bao_gia.MaDD = dinh_dang.MaDD 
                                    INNER JOIN phim ON Dinh_dang.MaDD = phim.MaDD 
                                    INNER JOIN loai_ghe ON loai_ghe.MaLG = Bao_gia.MaLG 
                                    INNER JOIN ghe ON ghe.MaLG = Loai_ghe.MaLG 
                                    INNER JOIN so_ghe ON ghe.SoGhe = so_ghe.SoGhe 
                                    INNER JOIN phong ON phong.MaPhong = ghe.MaPhong 
                                    INNER JOIN Lich_chieu ON Lich_chieu.MaPhong = phong.MaPhong 
                                    INNER JOIN ktg ON ktg.MaKTG = lich_chieu.MaKTG
                                        WHERE Lich_chieu.MaKTG = '$timeFrame'
                                            AND phim.MaPhim = '$movieID'
                                            AND so_ghe.SoGhe = '$chairID'
                                            and bao_gia.MaKTG = ktg.MaKTG
                                            and lich_chieu.MaPhim = phim.MaPhim";
        
        $total = queryDB($sql);

        $optionsHTML = '';
        while ($row = mysqli_fetch_assoc($total)) {
            $optionsHTML .= "<input type=\"text\" class=\"form-control\" name=\"price\" id=\"price\" value='{$row['DonGia']}' readonly/>";
        }

        echo '<div class="mb-3">
              <label class="form-label" for="basic-default-fullname">Giá tiền</label>
              ' . $optionsHTML . '
          </div>';

        echo $sql;
    }
?>