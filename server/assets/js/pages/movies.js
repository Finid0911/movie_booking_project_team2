function getAllMovies() {
  console.log("test");
  let url = "http://localhost:80/movie_booking_project_team2/api/v1/movies";
  $.ajax({
    url: url,
    success: function (result) {
      $("#t-header").html(`
        <tr>
            <th>Tên phim</th>
            <th>Năm sản xuất</th>
            <th>Thời lượng</th>
            <th>Ngày khởi chiếu</th>
            <th>Đạo diễn</th>
            <th>Action</th>
        </tr>
    `);
      let html = "";
      $.each(result, function (index, item) {
        html += ` <tr> 
    <td>${item.TenPhim}</td>
    <td>${item.NamSX}</td>
    <td>${item.ThoiLuong} mins</td>
    <td>${item.KhoiChieu}</td>
    <td>${item.DaoDien}</td>
    <td>
      <a href="../../views/index.php">
          <img src="../assets/img/icons/info.png" style="width: 35px; height: 35px; margin-right: 5px" alt="detail">
      </a>
      <a>
          <img src="../assets/img/icons/edits.png" style="width: 35px; height: 35px; margin-right: 5px" alt="edit">
      </a>
      <a>
          <img src="../assets/img/icons/remove.png" style="width: 35px; height: 35px; margin-right: 5px" alt="delete">
      </a>
    </td>
    </tr>`;
      });

      $("#moviesData .t-body").html(html);
    },
    error: function (err) {
      console.log(err);
    },
  });
}

function creatNewMovies() {
  let url = "http://localhost:80/movie_booking_project_team2/api/v1/movies";
  $.ajax({
    type: "POST",
    url: url,
    data: JSON.stringify(newGenreData),
    contentType: "application/json",
    success: function (response) {
      console.log(response);
    },
    error: function (xhr, status, error) {
      console.error(error);
    },
  });
}

$(document).ready(function () {
  $(".nav").on("click", function () {
    var id = $(this).attr("id");
    handleGetData(id);
  });
});

function handleGetData(id) {
  console.log(id);
  switch (id) {
    case "nav-phim":
      getAllMovies();
      break;
  }
}
