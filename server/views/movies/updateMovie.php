<?php
    include("../views/base.php");
    $movieID = $_GET['id'];
    $sql = "SELECT * FROM phim WHERE MaPhim = '$movieID'";
    $query = queryDB($sql);
    $count = $query->num_rows;
    if($count > 0)
    {
        $field = mysqli_fetch_array($query);
    }
    else echo "<tr><td>Không có dữ liệu trong CSDL</td></tr>";
?>

<div class="card-body">
    <form method="post" action="">
        <div class="mb-3">
            <label class="form-label" for="basic-default-fullname">Mã phim</label>
            <input type="text" class="form-control" name="maPhim" value="<?php echo $field['MaPhim'] ?>" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-company">Tên phim</label>
            <input type="text" class="form-control" name="tenPhim" value="<?php echo $field['TenPhim'] ?>" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-email">Ảnh đại diện</label>
            <div class="input-group input-group-merge">
                <input type="text" id="basic-default-email" class="form-control" />
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Năm sản xuất</label>
            <input type="text" class="form-control" value="<?php echo $field['NamSX'] ?>" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-message">Thời lượng</label>
            <input class="form-control" value="<?php echo $field['ThoiLuong'] ?>" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Đạo diễn</label>
            <input type="text" class="form-control" value="<?php echo $field['DaoDien'] ?>" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Diễn viên chính</label>
            <input type="text" class="form-control" value="<?php echo $field['DienVienChinh'] ?>" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Nội dung</label>
            <input type="text" class="form-control" value="<?php echo $field['NoiDung'] ?>" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Trailer</label>
            <input type="text" class="form-control" value="<?php echo $field['Trailer'] ?>" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Định dạng</label>
            <input type="text" class="form-control" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Thể loại</label>
            <input type="text" class="form-control" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Quốc gia</label>
            <input type="text" class="form-control" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Nhãn</label>
            <input type="text" class="form-control" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Nhân viên</label>
            <input type="text" class="form-control" />
        </div>
        <button type="menu" class="btn btn-primary">Back</button>
        <button type="submit" class="btn btn-info">Confirm</button>
    </form>
</div>

<?php
    
?>