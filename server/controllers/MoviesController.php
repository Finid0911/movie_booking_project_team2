<?php
include("./models/Connector.php");
include("BaseController.php");

class MoviesController extends BaseController
{
  private $tableId = "MaPhim";
  private $table = "Phim";

  public function __construct($requestMethod)
  {
    parent::__construct($requestMethod);
  }

  public function getMovies()
  {
    $movies = parent::get($this->table);
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode($movies);
    return $response;
  }

  public function getMovieById($id)
  {
    $movie = parent::getById($this->table, $this->tableId, $id);
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode($movie);
    return $response;

  }

  public function createMovie()
  {
    $response = null;
    $input = (array) json_decode(file_get_contents('php://input'), TRUE);
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $result = parent::post($this->table, $input);
    print_r($result);
    return $response;
  }

  public function getTop5Movie()
  {
    $response = null;
    $sql = "SELECT p.ten_phim, So_ve_dat
    FROM Phim p
    ORDER BY So_ve_dat DESC
    LIMIT 5";
    $result = $this->connection->query($sql);
    $movie = array();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $movie[] = $row;
      }
    }
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode($movie);
    return $response;
  }

  public function updateMovie()
  {
    $response = null;
    return $response;
  }

  public function deleteMovie()
  {
    $response = null;
    return $response;
  }

  private function notFoundResponse()
  {
    $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
    $response['body'] = null;
    return $response;
  }

  public function filter()
  {
    $startDate = isset($_GET['KhoiChieu']) ? $_GET['KhoiChieu'] : null;
    $endDate = isset($_GET['KetThuc']) ? $_GET['KetThuc'] : null;
    $query = isset($_GET['q']) ? '%' . strtolower($_GET['q']) . '%' : null;
    $orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : null;

    $sql = "SELECT * FROM $this->table Where 1";

    // Khởi tạo mảng điều kiện
    $conditions = array();

    if ($startDate !== null) {
      $sql .= " AND KhoiChieu >= ?";
      $conditions[] = $startDate;
    }

    if ($endDate !== null) {
      $sql .= " AND KetThuc <= ?";
      $conditions[] = $endDate;
    }

    if ($query !== null) {
      $sql .= " AND LOWER(TenPhim) LIKE ?";
      $conditions[] = $query;
    }

    // Thêm sắp xếp theo "soluongveban"
    if ($orderBy !== null) {
      $sql .= " ORDER BY soluongveban $orderBy";
    }

    $stmt = $this->connection->prepare($sql);

    // Kiểm tra nếu có điều kiện
    if (!empty($conditions)) {
      $types = str_repeat('s', count($conditions)); // Tạo chuỗi loại tham số
      $stmt->bind_param($types, ...$conditions); // Sử dụng unpacking
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $data = array();

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $data[] = $row;
      }
    }
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode($data);
    return $response;
  }


  public function processRequest($id)
  {
    switch ($this->requestMethod) {
      case 'GET':
        if (isset($id)) {
          $response = $this->getMovieById($id);
        } else {
          $response = $this->filter();
        }
        break;
      case 'POST':
        $response = $this->createMovie();
        break;
      case 'PUT':
        break;
      case 'Delete':
        break;

    }
    header($response['status_code_header']);
    if ($response['body']) {
      echo $response['body'];
    }
  }
}

?>