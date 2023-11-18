function getAllMovies() {
  let url = "http://localhost:800/movie_booking_project_team2/api/v1/movies";
  $.ajax({
    url: url,
    success: function (result) {
      let html = "";
      $.each(result, function (index, item) {
        html += ` <div class="movie movie--test movie--test--dark movie--test--left" data-maphim=${item.MaPhim}>
            <div class="movie__images">
                <a href="movie-page-full.html?id=${item.MaPhim}" class="movie-beta__link">
                <img alt='' src="images/movies/${item.AnhDaiDien}">
                </a>
            </div>

            <div class="movie__info">
                <a href='movie-page-full.html?id=${item.MaPhim}' class="movie__title">${item.TenPhim}</a>

                <p class="movie__time">${item.ThoiLuong} min</p>
                <p class="movie__option"><a href="#">Sci-Fi</a> | <a href="#">Thriller</a> | <a
                        href="#">Drama</a></p>
                <div class="movie__rate">
                    <div class="score"></div>
                    <span class="movie__rating">4.1</span>
                </div>
            </div>
        </div>`;
      });
      $("#movie-now").html(html);
    },
  });
}

function handleSearch() {
  $("#search-btn").click(function () {
    let value = $("#search-input").val();
    getMovieFiter(value);
  });
}

function getMovieFiter(query) {
  let url = `http://localhost:800/movie_booking_project_team2/api/v1/movies?q=${query}`;
  $.ajax({
    url: url,
    success: function (result) {
      console.log(result);
      let html = "";
      $.each(result, function (index, item) {
        html += ` <div class="movie movie--test movie--test--dark movie--test--left">
            <div class="movie__images">
                <a href="movie-page-full.html?id=${item.MaPhim}" class="movie-beta__link">
                <img alt='' src="images/movies/${item.AnhDaiDien}">
                </a>
            </div>

            <div class="movie__info">
                <a href='movie-page-full.html?id=${item.MaPhim}' class="movie__title">${item.TenPhim}</a>

                <p class="movie__time">${item.ThoiLuong} min</p>
                <p class="movie__option"><a href="#">Sci-Fi</a> | <a href="#">Thriller</a> | <a
                        href="#">Drama</a></p>
                <div class="movie__rate">
                    <div class="score"></div>
                    <span class="movie__rating">4.1</span>
                </div>
            </div>
        </div>`;
      });
      $("#movie-now").html(html);
    },
  });
}

function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(";");
  for (let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == " ") {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function getTop5Movie() {}

$(document).ready(function () {
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  let q = urlParams.get("q");
  console.log(q);
  if (q) {
    $("#search-input").val(q);
    getMovieFiter(q);
  } else {
    getAllMovies();
  }

  handleSearch();

  const tenThanhVien = decodeURIComponent(getCookie("tenThanhVien"));
  const maThanhVien = getCookie("maThanhVien");
  localStorage.setItem("maThanhVien", maThanhVien);
  localStorage.setItem("tenThanhVien", tenThanhVien);
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
                                    <li><a href="logout.php" class="auth__function-item sign-out" >Đăng xuất</a></li>
                                </ul>`;
  }

  document
    .querySelector("#username")
    .addEventListener("click", function (event) {
      // Kiểm tra xem phần tử con được nhấp có class là "abc" hay không
      if (event.target.classList.contains("sign-out")) {
        // Ngăn chặn hành vi mặc định của thẻ <a>
        event.preventDefault();

        localStorage.removeItem("maThanhVien");
        localStorage.removeItem("tenThanhVien");
        localStorage.removeItem("selectedPlaces");
        localStorage.removeItem("selectedTime");
        localStorage.removeItem("maPhim");

        window.location.href = "logout.php";
      }
    });
});
