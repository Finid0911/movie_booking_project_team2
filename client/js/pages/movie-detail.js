function getMovieDetail(id) {
  if (id) {
    let url = `http://localhost:800/movie_booking_project_team2/api/v1/movies/${id}`;
    fetch(url)
      .then((res) => {
        return res.json();
      })
      .then((data) => {
        console.log(data);
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

                <p class="movie__option"><strong>Country: </strong><a href="#">Việt Nam</a></p>
                <p class="movie__option"><strong>Year: </strong><a href="#">${data.NamSX}</a></p>
                <p class="movie__option"><strong>Category: </strong><a href="#">Adventure</a>, <a
                        href="#">Fantazy</a></p>
                <p class="movie__option"><strong>Release date: </strong>${data.KhoiChieu}</p>
                <p class="movie__option"><strong>Director: </strong><a href="#">${data.DaoDien}</a></p>
                <p class="movie__option"><strong>Actors: </strong>${data.DienVienChinh}</p>


                <div class="movie__btns movie__btns--full">
                    <a href="#" class="btn btn-md btn--warning">book a ticket for this movie</a>
                    <a href="#" class="watchlist">Add to watchlist</a>
                </div>

            </div>
        </div>`;
        $(".movie .page-heading").html(`${data.TenPhim}`);
        $(".movie .movie__info").html(html);
        $(".movie .noi-dung").html(`${data.NoiDung}`);
      });
  }
}

function selectTime() {
  $(".time-select__item").click(function () {
    // Lấy giá trị data-time từ phần tử được click
    var selectedTime = $(this).data("time");

    // Lưu giá trị vào Local Storage
    localStorage.setItem("selectedTime", selectedTime);
    var name = $("#movie-name").text();
    localStorage.setItem("name", name);

    // Chuyển hướng sang trang "book2"
    if (!localStorage.getItem("email")) {
      window.location.href = "login.html";
    } else {
      window.location.href = "book2.html";
    }
  });
}

// A $( document ).ready() block.
$(document).ready(function () {
  if (localStorage.getItem("email")) {
    $("#btn-login").text(localStorage.getItem("email"));
    $("#btn-login").css("pointer-events", "none");
  }
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const id = urlParams.get("id");
  getMovieDetail(id);
  selectTime();
});
