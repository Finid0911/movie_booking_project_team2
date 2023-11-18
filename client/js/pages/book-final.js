$(document).ready(function () {
    $('.top-scroll').parent().find('.top-scroll').remove();
    $(".ticket__movie").text(localStorage.getItem('name'));
    $("#time-setted").text(localStorage.getItem("time"));
    $("#cost").text(localStorage.getItem("sumMoney") + " VNĐ");
    var sit = localStorage.getItem("selectedPlaces");
    var selectedPlaces = JSON.parse(sit);
    $("#sit-setted").text(selectedPlaces.join(", "))

    // Lấy ngày tháng năm hiện tại
    var currentDate = new Date();

    // Lấy ngày, tháng và năm từ đối tượng Date
    var day = currentDate.getDate();
    var month = currentDate.getMonth() + 1; // Tháng trong JavaScript bắt đầu từ 0
    var year = currentDate.getFullYear();

    // Định dạng lại ngày, tháng và năm thành "dd/mm/yyyy"
    var formattedDate = (day < 10 ? '0' : '') + day + '/' + (month < 10 ? '0' : '') + month + '/' + year;

    $("#date-now").text(formattedDate);

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