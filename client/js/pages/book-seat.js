$(document).ready(function () {
    init_BookingTwo();
    getAllSeats();
    localStorage.removeItem("selectedPlaces")
    const maThanhVien = localStorage.getItem("maThanhVien");
    const tenThanhVien = localStorage.getItem("tenThanhVien");
    const mainContentDiv = document.getElementById("username");
    console.log(mainContentDiv);
    if (!maThanhVien) {
        // Người dùng chưa đăng nhập
        console.log("Vui lòng đăng nhập.");
        mainContentDiv.innerHTML = `<a href="#" class="btn btn--sign btn--singin">Đăng ký / Đăng nhập</a>
                        <ul class="auth__function">
                            <li><a href="signup.php" class="auth__function-item">Đăng ký</a></li>
                            <li><a href="login.php" class="auth__function-item">Đăng nhập</a></li>
                        </ul>`;
    } else {
        // Người dùng đã đăng nhập
        console.log(`Xin chào, ${tenThanhVien}!`);
        mainContentDiv.innerHTML = `<a href="#" class="btn btn--sign btn--singin"> ${tenThanhVien} </a>
                        <ul class="auth__function">
                            <li><a href="logout.php" class="auth__function-item">Đăng xuất</a></li>
                        </ul>`;
    }

    $("#search-btn").click(function (event) {
        event.preventDefault();
        let val = $("#search-input").val();
        window.location.href = `index.html?q=${val}`;
    });
});

function getAllSeats() {
    let url = `http://localhost/movie_booking_project_team2/api/v1/chairtype/getAllChairs?maPhim=${localStorage.getItem("maPhim")}&maKTG=${localStorage.getItem("selectedTime")}`;
    $.ajax({
        url: url,
        success: function (result) {
            let html = '';
            let currentRow = '';

            $.each(result, function (index, item) {

                if (item.SoHang !== currentRow) {
                    if (currentRow !== '') {
                        html += `</div>`; // Đóng thẻ div của hàng trước
                    }
                    html += `<div class="sits__row">`; // Mở thẻ div của hàng mới
                    currentRow = item.SoHang;
                }
                if (item.MaTT === '0') {
                    if (item.MaLG === 'LG01') {
                        html += `<span class="sits__place sits-price--cheap" data-maghe="${item.SoGhe}" data-price="${item.DonGia}"> ${item.SoGhe}</span>`;

                    }
                    else if (item.MaLG === 'LG02') {
                        html += `<span class="sits__place sits-price--middle" data-maghe="${item.SoGhe}" data-price="${item.DonGia}"> ${item.SoGhe}</span>`;
                        console.log(item.MaLG);
                    }
                    else
                        html += `<span class="sits__place sits-price--expensive" data-maghe="${item.SoGhe}" data-price="${item.DonGia}"> ${item.SoGhe}</span>`;
                }
                else html += `<span class="sits__place sits-price--cheap sits-state--not" data-maghe="${item.SoGhe}" data-price='${item.DonGia}'> ${item.SoGhe}</span>`;

            });

            html += `</div>`; // Đóng thẻ div của hàng cuối cùng

            $("#sitsContainer").html(html)
            //console.log(html);
        },

    });

}