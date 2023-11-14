<?php
    include("../views/base.php");
    require("../../server/controllers/uuidv4Gen.php");

    $myuuid = guidv4();

    // get formats ID
    $sql_formats = "SELECT * FROM dinh_dang";
    $formats = queryDB($sql_formats);

    // get types ID
    $sql_types = "SELECT * FROM the_loai";
    $types = queryDB($sql_types);

    // get nations ID
    $sql_nations = "SELECT * FROM quoc_gia";
    $nations = queryDB($sql_nations);

    // get labels ID
    $sql_labels = "SELECT * FROM nhan";
    $labels = queryDB($sql_labels);

    // get employees ID
    $sql_employee = "SELECT * FROM nhan_vien";
    $employees = queryDB($sql_employee);
    
?>

<div class="card-body">
    <form method="post" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label" for="basic-default-fullname">Mã phim</label>
            <input type="text" class="form-control" name="maPhim" value="<?php echo $myuuid ?>" disabled />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-company">Tên phim</label>
            <input type="text" class="form-control" name="tenPhim" />
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
            <input type="text" class="form-control" name="namSX" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-message">Thời lượng</label>
            <input class="form-control" name="thoiLuong" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-message">Khởi chiếu</label>
            <input type="date" class="form-control" name="khoiChieu" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Đạo diễn</label>
            <input type="text" class="form-control" name="daoDien" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Diễn viên chính</label>
            <input type="text" class="form-control" name="dienVienChinh" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Nội dung</label>
            <input type="text" class="form-control" name="noiDung" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Trailer</label>
            <input type="text" class="form-control" name="trailer" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Định dạng</label>
            <select class="form-control" name="dinhDang" id="formats">
                <?php
                    $selectedValue = "2D";
                    while($format = $formats->fetch_assoc()) {
                        $id_format = $format['MaDD'];
                        $name_format = $format['TenDD'];
                        $selected = ($name_format == $selectedValue) ? 'selected' : '';
                        // if ($formatID == $id_format){
                        //     $selected = 'selected';
                        // }
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
                        // if($typeID == $id_type){
                        //     $selected = 'selected';
                        // }
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
                        // if($nationID == $id_nation){
                        //     $selected = 'selected';
                        // }
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
                        // if($labelID == $id_label){
                        //     $selected = 'selected';
                        // }
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
                        // if($employeeID == $id_employee){
                        //     $selected = 'selected';
                        // }
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