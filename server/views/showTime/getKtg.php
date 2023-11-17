<div style="display: flex; justify-content: space-between; align-items: center">
    <h5 class="card-header">Quản lý Khung thời gian</h5>
    <button class="btn btn-info" style="margin-right: 20px;">
        <a style="color: azure; font-size: 16px" href="?action=addMovie">Thêm mới</a>
    </button>
</div>
<table class="table table-bordered table-hover" id="moviesData">
    <thead id="t-header">
        <tr>
            <th>Mã Khung thời gian</th>
            <th>Ngày chiếu</th>
            <th>Giờ chiếu</th>
            <th>Action</th>
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
            $max_results = 8;
            $from = (($page * $max_results) - $max_results);

            $sql = "SELECT * FROM ktg LIMIT $from, $max_results";
            $query = queryDB($sql);
            $count = $query->num_rows;

            if($count > 0)
                while($field = mysqli_fetch_array($query))
                { 
        ?>
        <tr>
            <td><?php echo $field["MaKTG"] ?></td>
            <td><?php echo $field["NgayChieu"] ?></td>
            <td><?php echo $field["GioChieu"] ?></td>
            <td>
                <a href="?action=seedetail">
                    <img src="../assets/img/icons/info.png" style="width: 35px; height: 35px; margin-right: 5px"
                        alt="detail">
                </a>
                <a href="?action=updateMovie&id=<?php echo $field["MaKTG"] ?>">
                    <img src=" ../assets/img/icons/edits.png" style="width: 35px; height: 35px; margin-right: 5px"
                        alt="edit">
                </a>
                <a href="?action=deleteMovie&id=<?php echo $field["MaKTG"] ?>">
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
    $result =  queryDB("SELECT COUNT(*) as Num FROM phim");  
    while($row = $result->fetch_assoc()) {
        $total_results = $row['Num'];
    }

    // Tính tổng số trang. Làm tròn lên sử dụng ceil()  
    $total_pages = ceil($total_results / $max_results);  

    // Tạo liên kết đến trang trước trang đang xem 
    if($page > 1){  
        $prev = ($page - 1);  
        echo "<a href=\"".$_SERVER['PHP_SELF']."?action=getKtg&page=$prev\"><button class='trang'>Trang trước</button></a>&nbsp;";  
    }  

    for($i = 1; $i <= $total_pages; $i++){  
        if(($page) == $i){  
            if($i>1) {
                echo "$i&nbsp;";  
            } 	
        } else {  
            echo "<a href=\"".$_SERVER['PHP_SELF']."?action=getKtg&page=$i\"><button class='so'>$i</button></a>&nbsp;";  
        }  
    }  

    // Tạo liên kết đến trang tiếp theo  
    if($page < $total_pages){  
        $next = ($page + 1);  
        echo "<a href=\"".$_SERVER['PHP_SELF']."?action=getKtg&page=$next\"><button class='trang'>Trang sau</button></a>";  
    }  
    echo "</center>";
?>