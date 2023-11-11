<?php
    include("../views/base.php");
    $movieID = $_GET['id'];
    $sql = "SELECT * FROM phim WHERE MaPhim = '$movieID'";
    $query = queryDB($sql);
    $count = $query->num_rows;

    if($count > 0)
    {
        $field = mysqli_fetch_assoc($query);

        // get formats ID
        $formatID = $field["MaDD"];
        $sql_formats = "SELECT * FROM dinh_dang";
        $formats = queryDB($sql_formats);

        // get types ID
        $typeID = $field["MaTL"];
        $sql_types = "SELECT * FROM the_loai";
        $types = queryDB($sql_types);

        // get nations ID
        $nationID = $field["MaQG"];
        $sql_nations = "SELECT * FROM quoc_gia";
        $nations = queryDB($sql_nations);

        // get labels ID
        $labelID = $field["MaNhan"];
        $sql_labels = "SELECT * FROM nhan";
        $labels = queryDB($sql_labels);

        // get employees ID
        $employeeID = $field["Ma_NV"];
        $sql_employee = "SELECT * FROM nhan_vien";
        $employees = queryDB($sql_employee);

        if(isset($_POST['tenPhim']) && isset($_POST['anhDaiDien']) && isset($_POST['namSX']) && isset($_POST['thoiLuong']) && isset($_POST['khoiChieu']) 
            && isset($_POST['daoDien']) && isset($_POST['dienVienChinh']) && isset($_POST['noiDung']) && isset($_POST['trailer']) && isset($_POST['dinhDang']) 
            && isset($_POST['theLoai']) && isset($_POST['quocGia']) && isset($_POST['nhan']) && isset($_POST['nhanVien'])){

                // get contents
                $id = $movieID;
                $title = $_POST['tenPhim'];
                $image = $_POST['anhDaiDien'];
                $yearOP = $_POST['namSX'];
                $length = $_POST['thoiLuong'];
                $startDate = $_POST['khoiChieu'];
                $director = $_POST['daoDien'];
                $cast = $_POST['dienVienChinh'];
                $plot = $_POST['noiDung'];
                $trailer = $_POST['trailer'];
                $format = $_POST['dinhDang'];
                $type = $_POST['theLoai'];
                $nation = $_POST['quocGia'];
                $label = $_POST['nhan'];
                $employee = $_POST['nhanVien'];

                $sql_update = "UPDATE phim SET 
                    TenPhim = '$title', 
                    AnhDaiDien = '$image', 
                    NamSX = '$yearOP', 
                    ThoiLuong = '$length',
                    KhoiChieu = '$startDate', 
                    KetThuc = '0000-00-00',
                    DaoDien = '$director',
                    DienVienChinh = '$cast', 
                    NoiDung = '$plot', 
                    Trailer = '$trailer', 
                    MaDD = '$format', 
                    MaTL = '$type', 
                    MaQG = '$nation', 
                    MaNhan = '$label',
                    Ma_NV = '$employee' 
                    WHERE MaPhim = '$id' ";
                echo $sql_update;
                echo $title;
                if(queryDB($sql_update) === TRUE){
                    
                    echo "Update successfully!";
                    // header("Location: http://localhost/movie_booking_project_team2/server/views/?action=getMovie");
                    echo "<script> window.location.href='http://localhost/movie_booking_project_team2/server/views/?action=getMovie' </script>";
                } else {
                    echo "Update unsuccessfully!";
                }
        }
    }
    else echo "<tr><td>Không có dữ liệu trong CSDL</td></tr>";
?>

<div class="card-body">
    <form method="post" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label" for="basic-default-fullname">Mã phim</label>
            <input type="text" class="form-control" name="maPhim" value="<?php echo $field['MaPhim'] ?>" disabled />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-company">Tên phim</label>
            <input type="text" class="form-control" name="tenPhim" value="<?php echo $field['TenPhim'] ?>" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-email">Ảnh đại diện</label>
            <div class="input-group input-group-merge">
                <input type="text" id="basic-default-email" class="form-control" name="anhDaiDien" />
                <image />
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Năm sản xuất</label>
            <input type="text" class="form-control" name="namSX" value="<?php echo $field['NamSX'] ?>" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-message">Thời lượng</label>
            <input class="form-control" name="thoiLuong" value="<?php echo $field['ThoiLuong'] ?>" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-message">Khởi chiếu</label>
            <input type="date" class="form-control" name="khoiChieu" value="<?php echo $field['KhoiChieu'] ?>" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Đạo diễn</label>
            <input type="text" class="form-control" name="daoDien" value="<?php echo $field['DaoDien'] ?>" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Diễn viên chính</label>
            <input type="text" class="form-control" name="dienVienChinh"
                value="<?php echo $field['DienVienChinh'] ?>" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Nội dung</label>
            <input type="text" class="form-control" name="noiDung" value="<?php echo $field['NoiDung'] ?>" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Trailer</label>
            <input type="text" class="form-control" name="trailer" value="<?php echo $field['Trailer'] ?>" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Định dạng</label>
            <select class="form-control" name="dinhDang" id="formats">
                <?php
                    while($format = $formats->fetch_assoc()) {
                        $id_format = $format['MaDD'];
                        $name_format = $format['TenDD'];
                        $selected = '';
                        if ($formatID == $id_format){
                            $selected = 'selected';
                        }
                        echo "<option value='$id_format' $selected>" . $name_format . "</option>";
                    }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Thể loại</label>
            <select class="form-control" name="theLoai" id="types">
                <?php
                    while($type = $types->fetch_assoc()) {
                        $id_type = $type['MaTL'];
                        $name_type = $type['TenTL'];
                        $selected = '';
                        if($typeID == $id_type){
                            $selected = 'selected';
                        }
                        echo "<option value='$id_type' $selected>" . $name_type . "</option>";
                    }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Quốc gia</label>
            <select class="form-control" name="quocGia" id="nations">
                <?php
                    while($nation = $nations->fetch_assoc()) {
                        $id_nation = $nation['MaQG'];
                        $name_nation = $nation['TenQG'];
                        $selected = '';
                        if($nationID == $id_nation){
                            $selected = 'selected';
                        }
                        echo "<option value='$id_nation' $selected>" . $name_nation . "</option>";
                    }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Nhãn</label>
            <select class="form-control" name="nhan" id="labels">
                <?php
                    while($label = $labels->fetch_assoc()) {
                        $id_label = $label['MaNhan'];
                        $name_label = $label['TenNhan'];
                        $selected = '';
                        if($labelID == $id_label){
                            $selected = 'selected';
                        }
                        echo "<option value='$id_label' $selected>" . $id_label. " - " . $name_label . "</option>";
                    }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Nhân viên</label>
            <select class="form-control" name="nhanVien" id="employees">
                <?php
                    while($employee = $employees->fetch_assoc()) {
                        $id_employee = $employee['Ma_NV'];
                        $name_employee = $employee['Ho_ten'];
                        $selected = '';
                        if($employeeID == $id_employee){
                            $selected = 'selected';
                        }
                        echo "<option value='$id_employee' $selected>" . $name_employee . "</option>";
                    }
                ?>
            </select>
        </div>
        <button type="button" onclick="back()" class="btn btn-primary">Back</button>
        <button type="submit" class="btn btn-info">Confirm</button>
    </form>
</div>

<script>
function back() {
    console.log("back!");
    window.location.href = "http://localhost/movie_booking_project_team2/server/views/?action=getMovie";
}
</script>