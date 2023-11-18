<div style="display: flex; justify-content: space-between; align-items: center">
    <h5 class="card-header">Quản lý Ghế</h5>
    <button class="btn btn-info" style="margin-right: 20px;">
        <a style="color: azure; font-size: 16px" href="?action=addChair">Thêm mới</a>
    </button>
</div>
<table class="table table-bordered table-hover" id="moviesData">
    <thead id="t-header">
        <tr>
            <th>Mã Ghế</th>
            <th>Loại ghế</th>
            <th>Số phòng</th>
            <th>Số ghế</th>
            <th>Trạng thái</th>
        </tr>
    </thead>
    <tbody class="t-body">

        <?php
            include("../views/base.php");
            if(!isset($_GET['page'])){
                $page = 1;
            }
            else {
                $page = intval($_GET['page']);
            }
            $max_results = 10;
            $from = (($page * $max_results) - $max_results);

            $sql = "SELECT * FROM ghe INNER JOIN loai_ghe ON ghe.MaLG = loai_ghe.MaLG 
                                        INNER JOIN phong ON ghe.MaPhong = phong.MaPhong 
                                        INNER JOIN trang_thai ON ghe.MaTT = trang_thai.MaTT 
                                        INNER JOIN so_ghe ON ghe.SoGhe = so_ghe.SoGhe
                                        LIMIT $from, $max_results";
            $query = queryDB($sql);
            $count = $query->num_rows;

            if($count > 0)
                while($field = mysqli_fetch_array($query))
                { 
        ?>
        <tr>
            <td><?php echo $field["MaGhe"] ?></td>
            <td><?php echo $field["TenLG"] ?></td>
            <td><?php echo $field["TenPhong"] ?></td>
            <td><?php echo $field["TenTT"] ?></td>
            <td><?php echo $field["SoGhe"] ?></td>
            <td>
                <a href="?action=seedetail">
                    <img src="../assets/img/icons/info.png" style="width: 35px; height: 35px; margin-right: 5px"
                        alt="detail">
                </a>
                <a href="?action=updateRoom&id=<?php echo $field["MaPhong"] ?>">
                    <img src=" ../assets/img/icons/edits.png" style="width: 35px; height: 35px; margin-right: 5px"
                        alt="edit">
                </a>
                <a href="?action=deleteRoom&id=<?php echo $field["MaPhong"] ?>">
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

</br>

<?php
    
    echo '<div id="phantrang_sp">';
    // Tính tổng kết quả trong toàn DB: 
    $result =  queryDB("SELECT COUNT(*) as Num FROM ghe");  
    while($row = $result->fetch_assoc()) {
        $total_results = $row['Num'];
    }

    // Tính tổng số trang. Làm tròn lên sử dụng ceil()  
    $total_pages = ceil($total_results / $max_results);  

    // Tạo liên kết đến trang trước trang đang xem 
    if($page > 1){  
        $prev = ($page - 1);  
        echo "<a href=\"".$_SERVER['PHP_SELF']."?action=getChair&page=$prev\"><button class='trang'>Trang trước</button></a>&nbsp;";  
    }  

    for($i = 1; $i <= $total_pages; $i++){  
        if(($page) == $i){  
            if($i>1) {
                echo "$i&nbsp;";  
            } 	
        } else {  
            echo "<a href=\"".$_SERVER['PHP_SELF']."?action=getChair&page=$i\"><button class='so'>$i</button></a>&nbsp;";  
        }  
    }  

    // Tạo liên kết đến trang tiếp theo  
    if($page < $total_pages){  
        $next = ($page + 1);  
        echo "<a href=\"".$_SERVER['PHP_SELF']."?action=getChair&page=$next\"><button class='trang'>Trang sau</button></a>";  
    }  
    echo "</center>";
?>