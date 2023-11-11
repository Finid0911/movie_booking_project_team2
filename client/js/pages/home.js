function getAllMovies() {
  let url = "http://localhost:800/movie_booking_project_team2/api/v1/movies";
  $.ajax({
    url: url,
    success: function (result) {
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

function handleSearch() {
  $("#search-btn").click(function () {
    let value = $("#search-input").val();
    let url = `http://localhost:800/movie_booking_project_team2/api/v1/movies?q=${value}`;
    $.ajax({
      url: url,
      success: function (result) {
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
  });
}

// A $( document ).ready() block.
$(document).ready(function () {
  getAllMovies();
  handleSearch();
});
