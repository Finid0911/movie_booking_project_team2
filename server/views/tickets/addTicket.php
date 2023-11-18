<?php
    include("../views/base.php");
    require("../../server/controllers/uuidv4Gen.php");

    $myuuid = guidv4();

    // get movies
    $sql_movies = "SELECT * FROM phim";
    $movies = queryDB($sql_movies);

    // get chair.No
    $sql_chairNo = "SELECT * FROM so_ghe";
    $chairNo = queryDB($sql_chairNo);

    // get rooms
    $sql_rooms = "SELECT * FROM phong";
    $rooms = queryDB($sql_rooms);

    // get prices
    $sql_prices = "SELECT * FROM gia";
    $prices = queryDB($sql_prices);

    // get customers
    $sql_customers = "SELECT * FROM thanh_vien";
    $customers = queryDB($sql_customers);

    if(!empty($_POST['tenPhim']) && !empty($_POST['khachHang']) && !empty($_POST['ktg']) && !empty($_POST['chair'])) {

        $movieID = $_POST['tenPhim'];
        $customerID = $_POST['khachHang'];
        $timeFrame = $_POST['ktg'];
        $chairNo = $_POST['chair'];
        
        $totalPrice = $_POST['price'];
        echo $_POST['tenPhim'];
        $sql_price = "SELECT MaGia FROM Gia WHERE DonGia = '$totalPrice'";
        $priceID = queryDB($sql_price);
        while($row = mysqli_fetch_assoc($priceID)){
            $priceIDD = $row["MaGia"];
        }
        echo $priceIDD;
        
        $sql_room = "SELECT lich_chieu.MaPhong as MP FROM phong INNER JOIN lich_chieu ON phong.MaPhong = lich_chieu.MaPhong
                                                INNER JOIN ghe ON phong.MaPhong = ghe.MaPhong
                                                INNER JOIN so_ghe ON so_ghe.SoGhe = ghe.SoGhe
                                                WHERE lich_chieu.MaPhim = '$movieID'
                                                    AND lich_chieu.MaKTG = '$timeFrame'
                                                    AND so_ghe.SoGhe = '$chairNo'";
        $roomID = queryDB($sql_room);
        while($row = mysqli_fetch_assoc($roomID)){
            $roomIDD = $row["MP"];
        }
        $currentDateTime = date('Y-m-d H:i:s');
        
        // get contents
        $id = $myuuid;
        $sql_insert1 = "INSERT INTO ve VALUES ('$id', '$movieID', '$timeFrame', '$chairNo', '$roomIDD', '$priceIDD')";
        $sql_insert2 = "INSERT INTO ds_ve_dat VALUES ('$customerID', '$id', '$currentDateTime')";
        $sql_update = "UPDATE ghe SET MaTT='1' WHERE SoGhe='$chairNo' AND MaPhong='$roomIDD'";
        
        if(queryDB($sql_insert1) === TRUE && queryDB($sql_insert2) === TRUE && queryDB($sql_update) === TRUE) {
            echo "Book successfully!";
            $message = "Book thành công!";
            echo "<script>alert('$totalPrice');</script>";
            echo "<script> window.location.href='http://localhost/movie_booking_project_team2/server/views/?action=getTicket' </script>";
            //header("Location: http://localhost/movie_booking_project_team2/server/views/?action=getTicket");
        } else {
            //echo "Book unsuccessfully!";
            $message = "Book thất bại!";
            echo "<script>alert('$message');</script>";
            echo "<script> window.location.href='http://localhost/movie_booking_project_team2/server/views/' </script>";
        }
    }
    
?>

<div class="card-body">
    <form method="post" action="" enctype="multipart/form-data" id="form">
        <div class="mb-3">
            <label class="form-label" for="basic-default-fullname">Mã vé</label>
            <input type="text" class="form-control" name="maPhim" value="<?php echo $myuuid ?>" disabled />
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Tên phim</label>
            <select class="form-control" name="tenPhim" id="tenPhim">
                <?php
                    while($movie = $movies->fetch_assoc()){
                        $id_movie = $movie["MaPhim"];
                        $name_movie = $movie["TenPhim"];
                        $yearOP = $movie["NamSX"];
                        $selected = '';
                        echo "<option value='$id_movie' $selected>" . $name_movie . " -  " . $yearOP . "</option>";
                    }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Khách hàng</label>
            <select class="form-control" name="khachHang" id="khachHang">
                <?php
                    while($customer = $customers->fetch_assoc()) {
                        $id_customer = $customer['Ma_thanh_vien'];
                        $name_customer = $customer['HoTen'];
                        $sdt = $customer["SDT"];
                        $selected = '';
                        echo "<option value='$id_customer' $selected>" . $name_customer . " -  " . $sdt . "</option>";
                    }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-message">Khung thời gian</label>
            <select class="form-control" name="ktg" id="ktg">
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-message">Ghế</label>
            <select class="form-control" name="chair" id="chair">
            </select>
        </div>
        <div class="mb-3">
            <div id="total" name="total"></div>
        </div>
        <button type="button" onclick="back()" class="btn btn-primary">Back</button>
        <button type="submit" class="btn btn-info" id="confirm">Confirm</button>
    </form>
</div>

<script>
let selectedMovieId = null;

document.addEventListener("DOMContentLoaded", () => {
    console.log("Hello World!");
    selectedMovieId = document.getElementById("tenPhim").value;
    generate_gio_chieu(selectedMovieId);
});

document.getElementById("tenPhim").addEventListener("change", function() {
    selectedMovieId = this.value;
    generate_gio_chieu(selectedMovieId);
    console.log("ID movie = " + selectedMovieId);
});

function generate_gio_chieu(value) {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            let gioChieuDropdown = document.getElementById("ktg");
            //console.log("Data1", this.responseText);
            gioChieuDropdown.innerHTML = this.responseText;
            let selectedTimeFrame = document.getElementById("ktg").value
            generate_chair(selectedTimeFrame)
        }
    };
    xhr.open("POST", "./tickets/getTimeFrame.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("tenPhim=" + value);
}

function generate_chair(value) {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            let chairDropDown = document.getElementById("chair");
            //console.log("Data2", this.responseText);
            chairDropDown.innerHTML = this.responseText;
            let priceTotal = document.getElementById("chair").value
            let selectedTimeFrame = document.getElementById("ktg").value
            generate_price(selectedMovieId, selectedTimeFrame, priceTotal)
        }
    };
    xhr.open("POST", "./tickets/getChair.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("ktg=" + value);
}

document.getElementById("ktg").addEventListener("change", function() {
    let selectedTimeFrame = this.value;
    generate_chair(selectedTimeFrame);
});

function generate_price(value1, value2, value3) {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            let price = document.getElementById("total");
            console.log("Data3", this.responseText);
            price.innerHTML = this.responseText;
        }
    };
    xhr.open("POST", "./tickets/getPrice.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    let data = "tenPhim=" + value1 + "&ktg=" + value2 + "&chair=" + value3;
    xhr.send(data);
}

document.getElementById("chair").addEventListener("change", function() {
    let selectedChair = this.value;
    let selectedTimeFrame = document.getElementById("ktg").value;

    generate_price(selectedMovieId, selectedTimeFrame, selectedChair);
});

function back() {
    console.log("back!");
    window.location.href = "http://localhost/movie_booking_project_team2/server/views/?action=getTicket";
}

// document.getElementById("confirm").click((event) => {
//     event.preventDefault();
//     console.log(document.getElementById("price").value);
// })
</script>