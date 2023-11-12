<?php
include("./models/Connector.php");
include("BaseController.php");
class ChairTypeController extends BaseController
{
  private $tableId = "MaLG";
  private $table = "loai_ghe";

  public function __construct($requestMethod)
  {
    parent::__construct($requestMethod);
  }

  public function getChairTypes()
  {

    $chairtypes = parent::get($this->table);

    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode($chairtypes);
    return $response;
  }

  public function getChairTypeById($id)
  {
    $chairtype = parent::getById($this->table, $this->tableId, $id);
    echo json_encode($chairtype);
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode($chairtype);
    return $response;

  }

  public function createChairType()
  {
    $response = null;
    $input = (array) json_decode(file_get_contents('php://input'), TRUE);
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $result = parent::post($this->table, $input);
    print_r($result);
    return $response;
  }

  public function getAllChairofTimeid()
  {
    $response = null;

    // Lấy tham số từ yêu cầu Ajax
    $phimID = $_GET['maPhim'];
    $timeID = $_GET['maKTG']; 
    $sql = "SELECT * FROM phim LEFT JOIN lich_chieu ON phim.MaPhim = lich_chieu.MaPhim
     LEFT JOIN ktg ON lich_chieu.MaKTG = ktg.MaKTG 
     LEFT JOIN phong ON lich_chieu.MaPhong = phong.MaPhong 
     LEFT JOIN ghe ON phong.MaPhong = ghe.MaPhong 
     LEFT JOIN trang_thai ON ghe.MaTT = trang_thai.MaTT
      LEFT JOIN so_ghe ON ghe.SoGhe = so_ghe.SoGhe 
      where phim.MaPhim = '$phimID' and ktg.MaKTG = '$timeID';
    ";
    $result = $this->connection->query($sql);
    $data = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    // Trả về kết quả
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode($data );

    return $response; 
  }
  public function updateChairType()
  {
    $response = null;
    return $response;
  }

  public function deleteChairType()
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

  private function handleUrl($method) {
    if($method === "getAllChairs") {
      return $this->getAllChairofTimeid();
    }
  }

  public function processRequest($id, $method)
  {
    switch ($this->requestMethod) {
      case 'GET':
        if (isset($id)) {
          $response = $this->getChairTypeById($id);
        }else {
          if(!isset($method))
              $response = $this->getChairTypes();
          else $response = $this->handleUrl($method);
        }

        break;
      case 'POST':
        $response = $this->createChairType();
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