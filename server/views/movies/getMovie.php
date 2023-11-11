<h5 class="card-header">Quản lý Phim</h5>
<button>
    <a href="?action=addMovie">Thêm mới</a>
</button>
<table class="table table-bordered table-hover" id="moviesData">
    <thead id="t-header">
        <tr>
            <th>Tên phim</th>
            <th>Năm sản xuất</th>
            <th>Thời lượng</th>
            <th>Ngày khởi chiếu</th>
            <th>Đạo diễn</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody class="t-body">

        <?php
        include("../views/base.php");

            $sql = "SELECT * FROM phim";
            $query = queryDB($sql);
            $count = $query->num_rows;

            if($count > 0)
                while($field = mysqli_fetch_array($query))
                { 
        ?>
        <tr>
            <td><?php echo $field["TenPhim"] ?></td>
            <td><?php echo $field["NamSX"] ?></td>
            <td><?php echo $field["ThoiLuong"] ?></td>
            <td><?php echo $field["KhoiChieu"] ?></td>
            <td><?php echo $field["DaoDien"] ?></td>
            <td>
                <a href="?action=seedetail">
                    <img src="../assets/img/icons/info.png" style="width: 35px; height: 35px; margin-right: 5px"
                        alt="detail">
                </a>
                <a href="?action=updateMovie&id=<?php echo $field["MaPhim"] ?>">
                    <img src=" ../assets/img/icons/edits.png" style="width: 35px; height: 35px; margin-right: 5px"
                        alt="edit">
                </a>
                <a href="?action=deleteMovie">
                    <img src="../assets/img/icons/remove.png" style="width: 35px; height: 35px; margin-right: 5px"
                        alt="delete">
                </a>
            </td>
        </tr>
        <?php     
        }
    else echo "<tr><td>Không có dữ liệu trong CSDL</td></tr>";
?>
    </tbody>
</table>