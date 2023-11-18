// Lấy giá trị từ local storage
var selectedPlaces = JSON.parse(localStorage.getItem('selectedPlaces'));
var sumMoney = localStorage.getItem('sumMoney');

// Xây dựng chuỗi từ mảng
var formattedPlaces = selectedPlaces.join(', ');

// Cập nhật giá trị trong mã HTML
document.querySelector('.booking-ticket').textContent = formattedPlaces;
document.querySelector('.booking-cost').textContent = sumMoney + " VNĐ";

$(document).ready(function () {
    getPhongbyPhimAndKtg();
    handleBuyTicket();

    const maThanhVien = localStorage.getItem("maThanhVien");
    const tenThanhVien = localStorage.getItem("tenThanhVien");
    const mainContentDiv = document.getElementById("username");
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

function getPhongbyPhimAndKtg() {
    let url =
        `http://localhost/movie_booking_project_team2/api/v1/phong/getPhongbyPhimAndKtg?maPhim=${localStorage.getItem("maPhim")}&maKTG=${localStorage.getItem("selectedTime")}`;
    $.ajax({
        url: url,
        success: function (result) {
            let html = '';
            $.each(result, function (index, item) {

                html += ` <div class="checkout-wrapper">
            <h2 class="page-heading">Movie</h2>
                <ul class="book-result">
                    <li class="book-result__item">Movie: <span class="book-result__count">${item.TenPhim}</span>
                    </li>
                    <li class="book-result__item">Ngày chiếu: <span
                            class="book-result__count">${item.NgayChieu}</span></li>
                    <li class="book-result__item">Suất chiếu: <span class="book-result__count ">${item.GioChieu}</span>
                    </li>
                    <li class="book-result__item">Phòng chiếu: <span class="book-result__count ">${item.TenPhong}</span>
                    </li>
                </ul>
            </div>`;
            });
            $("#movie_phong").html(html);

        },

    });

}

function handleBuyTicket() {
    const buyElem = document.querySelector("#purchase");
    buyElem.addEventListener("click", async function (event) {
        event.preventDefault();
        const url = `http://localhost/movie_booking_project_team2/api/v1/tickets/createTicket`;
        const maKTG = localStorage.getItem("selectedTime");
        const dsGheDat = localStorage.getItem("selectedPlaces");
        const maPhim = localStorage.getItem("maPhim");
        const maThanhVien = localStorage.getItem("maThanhVien");
        const maPhong = localStorage.getItem("maPhong");
        const dsGheDatArray = JSON.parse(dsGheDat);
        const data = {
            maKTG,
            dsGheDatArray,
            maPhim,
            maPhong,
            maThanhVien,
        }

        const json = JSON.stringify(data);

        const res = await fetch(url, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: json
        });

        const result = await res.json();
        console.log(result);
        if (result) {
            alert("Đặt vé thành công");
            setTimeout(() => {
                window.location.href = "book-final.html";
            }, 1000)
        }

    })
}