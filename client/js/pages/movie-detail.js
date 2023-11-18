function getMovieDetail(id) {
  if (id) {
    let url = `http://localhost/movie_booking_project_team2/api/v1/movies/${id}`;
    fetch(url)
      .then((res) => {
        return res.json();
      })
      .then((data) => {
        let html = `<h4 class="page-heading" id='movie-name'>${data.TenPhim}</h4>
        <div class="movie__info">
            <div class="col-sm-4 col-md-3 movie-mobile">
                <div class="movie__images">
                    <span class="movie__rating">5.0</span>
                    <img alt='' src="images/movies/${data.AnhDaiDien}">
                </div>
            </div>

            <div class="col-sm-8 col-md-9">
                <p class="movie__time">169 min</p>

                <p class="movie__option"><strong>Quốc gia: </strong><a href="#">Việt Nam</a></p>
                <p class="movie__option"><strong>Năm: </strong><a href="#">${data.NamSX}</a></p>
                <p class="movie__option"><strong>Thể loại: </strong><a href="#">Adventure</a>, <a
                        href="#">Fantazy</a></p>
                <p class="movie__option"><strong>Ngày chiếu: </strong>${data.KhoiChieu}</p>
                <p class="movie__option"><strong>Đạo diễn: </strong><a href="#">${data.DaoDien}</a></p>
                <p class="movie__option"><strong>Diễn viên: </strong>${data.DienVienChinh}</p>


                <div class="movie__btns movie__btns--full">
                    <a href="#" class="btn btn-md btn--warning">Đặt vé cho phim này</a>
                </div>

            </div>
        </div>`;
        $(".movie .page-heading").html(`${data.TenPhim}`);
        $(".movie .movie__info").html(html);
        $(".movie .noi-dung").html(`${data.NoiDung}`);
      });
  }
}
function selectTime(id) {
  $(".time-select").click(function (event) {
    // Kiểm tra xem thành phần được nhấp có class 'time-select__item' không
    if ($(event.target).hasClass("time-select__item")) {
      // Lấy giá trị data-time từ phần tử được click
      var selectedTime = $(event.target).data("id");
      var maPhong = $(event.target).data("phong");

      // Lưu giá trị vào Local Storage
      localStorage.setItem("selectedTime", selectedTime);
      localStorage.setItem("time", $(event.target).data("time"));
      var name = $("#movie-name").text();
      localStorage.setItem("name", name);
      localStorage.setItem("maPhim", id);
      localStorage.setItem("maPhong", maPhong);

      // Chuyển hướng sang trang "book2"
      console.log("test");
      if (!localStorage.getItem("maThanhVien")) {
        window.location.href = "login.php";
      } else {
        window.location.href = "book2.html";
      }
    }
  });
}

async function getAllTimeOfMovie(id) {
  let url = `http://localhost/movie_booking_project_team2/api/v1/ktg/getAllTimeOfMovieId?maphim=${id}`;
  try {
    const res = await fetch(url);
    const data = await res.json();
    console.log(data);

    const ulElem = document.querySelector("#ktg");
    let html = "";
    data.forEach((item) => {
      let convertedTime = item.GioChieu.slice(0, 5);
      html += `<li class="time-select__item" data-id='${item.MaKTG}' data-time="${convertedTime}" data-phong=${item.MaPhong}>${convertedTime}</li>`;
    });

    ulElem.innerHTML = html;
  } catch (err) {
    console.log(err);
  }
}

async function showComment(id) {
  const res = await fetch(
    `http://localhost/movie_booking_project_team2/api/v1/comments?maPhim=${id}`
  );
  const data = await res.json();
  console.log(data);
  let html = ``;
  data.forEach((item) => {
    html += `<div class="comment">
    <a class="comment__author" style="margin:-24px;">${item.HoTen}</a>
    <p class="comment__date">${item.createdDate}</p>
    <p class="comment__message">${item.content}</p>
</div>`;
  });
  document.querySelector("#comments").innerHTML = html;
}

async function addComment(id) {
  const maPhim = localStorage.getItem("maPhim");
  const maThanhVien = localStorage.getItem("maThanhVien");
  const content = document.getElementById("comment-text").value;
  data = {
    maPhim,
    maThanhVien,
    content,
  };
  const json = JSON.stringify(data);
  const res = await fetch(
    "http://localhost/movie_booking_project_team2/api/v1/comments",
    {
      method: "POST",
      headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
      },
      body: json,
    }
  );
  document.getElementById("comment-text").value = "";
  showComment(id);
}

$(document).ready(function () {
  if (localStorage.getItem("tenThanhVien")) {
    $("#btn-login").text(localStorage.getItem("tenThanhVien"));
    $("#btn-login").css("pointer-events", "none");
  }
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  id = urlParams.get("id");
  localStorage.setItem("maPhim", id);

  getMovieDetail(id);
  getAllTimeOfMovie(id);
  selectTime(id);
  showComment(id);

  $("#comment").click(function () {
    addComment(id);
  });

  $("#search-btn").click(function (event) {
    event.preventDefault();
    let val = $("#search-input").val();
    window.location.href = `index.html?q=${val}`;
  });
});
