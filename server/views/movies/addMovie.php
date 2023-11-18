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

    if(!empty($_POST['tenPhim']) && !empty($_POST['namSX']) && !empty($_POST['thoiLuong']) 
    && !empty($_POST['khoiChieu']) && !empty($_POST['daoDien']) && !empty($_POST['dienVienChinh']) && !empty($_POST['noiDung']) 
    && !empty($_POST['trailer']) && !empty($_POST['dinhDang']) && !empty($_POST['theLoai']) && !empty($_POST['quocGia']) 
    && !empty($_POST['nhan']) && !empty($_POST['nhanVien'])) {

        // handle image upload
        $file_tmp= isset($_FILES['anhDaiDien']['tmp_name']) ? $_FILES['anhDaiDien']['tmp_name'] : "";
        $file_name=isset($_FILES['anhDaiDien']['name']) ? $_FILES['anhDaiDien']['name'] : "";
        $file_type=isset($_FILES['anhDaiDien']['type']) ? $_FILES['anhDaiDien']['type'] : "";
        $file_size=isset($_FILES['anhDaiDien']['size']) ? $_FILES['anhDaiDien']['size'] : "";
        $file_error=isset($_FILES['anhDaiDien']['error']) ? $_FILES['anhDaiDien']['error'] : "";
        //Lay gio cua he thong
        $dmyhis= date("Y").date("m").date("d").date("H").date("i").date("s");
        //Lay ngay cua he thong
        $ngay=date("Y").":".date("m").":".date("d").":".date("H").":".date("i").":".date("s");

        $file__name__=$dmyhis.$file_name;
        $upload_dir = "../../client/images/movies/";
        $target_file = $upload_dir . basename($file__name__);
        $imageFileType = strtolower(pathinfo($file__name__, PATHINFO_EXTENSION));

        if($file_name != "" && $imageFileType != "jpg" && $imageFileType != "png" 
        && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }
        if($file_name != ""){
            move_uploaded_file($file_tmp, $target_file);
        }
        
        // get contents
        $id = $myuuid;
        $title = mb_strtoupper($_POST['tenPhim']);
        $image = $file__name__;
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

        $check = !empty($_POST['tenPhim']);

        echo "<script>alert('Insert successfully!')</script>"; 

        $sql_insert = "INSERT INTO phim VALUE('$id', '$title', '$image', '$yearOP', '$length', '$startDate', '0000-00-00', '$director', 
                        '$cast', '$plot', '$trailer', '$format', '$type', '$nation', '$label', '$employee')";
        echo $sql_insert;
        
        if(queryDB($sql_insert) === TRUE){
            echo "Add successfully!";
            // header("Location: http://localhost/movie_booking_project_team2/server/views/?action=getMovie");
            echo "<script> window.location.href='http://localhost/movie_booking_project_team2/server/views/?action=getMovie' </script>";
        } else {
            echo "Add unsuccessfully!";
        }
    }
    
?>

<div class="card-body">
    <form method="post" action="" enctype="multipart/form-data" id="form">
        <div class="mb-3">
            <label class="form-label" for="basic-default-fullname">Mã phim</label>
            <input type="text" class="form-control" name="maPhim" value="<?php echo $myuuid ?>" disabled />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-company">Tên phim</label>
            <input type="text" class="form-control" name="tenPhim" autofocus required />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-email">Ảnh đại diện</label>
            <input type="file" class="form-control" name="anhDaiDien"
                style="margin-top: 10px; padding: 10px; border: 1px solid; height: 45px; max-width: 400px;" required />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Năm sản xuất</label>
            <input type="text" class="form-control" name="namSX" required />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-message">Thời lượng</label>
            <input class="form-control" name="thoiLuong" required />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-message">Khởi chiếu</label>
            <input type="date" class="form-control" name="khoiChieu" required />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Đạo diễn</label>
            <input type="text" class="form-control" name="daoDien" required />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Diễn viên chính</label>
            <input type="text" class="form-control" name="dienVienChinh" required />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Nội dung</label>
            <input type="text" class="form-control" name="noiDung" required />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Trailer</label>
            <input type="text" class="form-control" name="trailer" required />
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