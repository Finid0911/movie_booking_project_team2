<?php
include('./models/Connector.php');
include('BaseController.php');
require("./controllers/uuidv4Gen.php");
class TicketsController extends BaseController
{
  private $table = "Ve";
  private $tableId = "MaVe";

  public function __construct($requestMethod)
  {
    parent::__construct($requestMethod);
  }

  public function getVe()
  {
    $ve = parent::get($this->table);
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode($ve);
    return $response;
  }

  public function getVeById($id)
  {
    $ve = parent::getById($this->table, $this->tableId, $id);
    echo json_encode($ve);
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode($ve);
    return $response;
  }

  public function createVe()
  {
    $response = null;
    $input = (array) json_decode(file_get_contents('php://input'), true);
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $result = parent::post($this->table, $input);
    print_r($result);
    return $response;
  }
  public function createNewTicket()
  {
    $body = json_decode(file_get_contents('php://input'), true); // Lấy toàn bộ body dưới dạng một mảng
    // Xử lý body ở đây
    $dsGheDat = $body['dsGheDatArray'];
    $maphim = $body['maPhim'];
    $maktg = $body['maKTG'];
    $maPhong = $body["maPhong"];
    $ma_thanh_vien = $body["maThanhVien"]; 

    try {
      // Bắt đầu transaction
      $this->connection->begin_transaction();

      // Insert vé và lấy mã vé
      $queryAddTicket = "INSERT INTO ve (MaVe, MaPhim, MaKTG, SoGhe, MaPhong, MaGia) VALUES ";
      $maVeArray = array();
      foreach ($dsGheDat as $ghe) {
        $maVe = guidv4();
        $laybaogia = "SELECT bao_gia.MaGia FROM so_ghe,phong,ghe,loai_ghe,bao_gia
        WHERE so_ghe.SoGhe = ghe.SoGhe
          and phong.MaPhong = ghe.MaPhong
            and ghe.MaLG = loai_ghe.MaLG
            and loai_ghe.MaLG = bao_gia.MaLG
            and phong.MaPhong = '$maPhong'
            and so_ghe.SoGhe = '$ghe'";
        $res = $this->connection->query($laybaogia);
        $baogia = ""; // Tạo biến để lưu giá trị từ cột đầu tiên

        if ($res->num_rows > 0) {
          $baogia_row = $res->fetch_assoc(); // Lấy hàng đầu tiên từ kết quả truy vấn

          // Kiểm tra xem cột đầu tiên có tồn tại trong hàng kết quả không
          if (isset($baogia_row)) {
            // Lấy giá trị từ cột đầu tiên (sử dụng chỉ mục hoặc tên cột nếu biết)
            $baogia = reset($baogia_row); // Sử dụng reset để lấy giá trị đầu tiên trong mảng kết quả
          }
        }
        $queryAddTicket .= "('$maVe', '$maphim', '$maktg', '$ghe', '$maPhong', '$baogia'),";
        array_push($maVeArray, $maVe);
      }
      $queryAddTicket = rtrim($queryAddTicket, ',');
      $this->connection->query($queryAddTicket);

      // Update trạng thái ghế 
      $dsGhe = implode("','", $dsGheDat);
      $queryUpdateChairState = "UPDATE ghe SET MaTT = 1 WHERE MaPhong = '$maPhong' AND SoGhe IN ('$dsGhe')";
      $this->connection->query($queryUpdateChairState);

      // Insert ds vé đặt
      $queryInsertDSVeDat = "INSERT INTO DS_VE_DAT (Ma_Thanh_Vien, MaVe, NgayDat) VALUES ";
      foreach ($maVeArray as $maVe) {
        $ngayDat = date("Y-m-d H:i:s");
        $queryInsertDSVeDat .= "('$ma_thanh_vien', '$maVe', '$ngayDat'),";
      }
      $queryInsertDSVeDat = rtrim($queryInsertDSVeDat, ',');
      $this->connection->query($queryInsertDSVeDat);

      // Commit transaction nếu mọi thứ thành công
      $this->connection->commit();

      $response['status_code_header'] = 'HTTP/1.1 200 OK';
      $response['body'] = json_encode(array("message" => "Thành công"));
    } catch (Exception $e) {
      // Nếu có lỗi xảy ra, rollback transaction
      $this->connection->rollback();
      echo "Lỗi: " . $e->getMessage();
      $response['status_code_header'] = 'HTTP/1.1 500 Internal Server Error';
      $response['body'] = json_encode(array("message" => "Thất bại: " . $e->getMessage()));
    }

    return $response;


  }

  public function updateVe($id)
  {
    $response = null;
    $input = (array) json_decode(file_get_contents('php://input'), true);
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $result = parent::put($this->table, $this->tableId, $id, $input);
    $response['body'] = json_encode($result);
    return $response;
  }

  public function deleteVe($id)
  {
    $ve = parent::delete($this->table, $this->tableId, $id);
    echo json_encode($ve);
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode($ve);
    return $response;
  }

  private function notFoundResponse()
  {
    $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
    $response['body'] = null;
    return $response;
  }

  public function getFinalVe()
  {
    $response = null;

    // Lấy tham số từ yêu cầu Ajax
    $phimID = $_GET['maPhim'];
    $timeID = $_GET['maKTG'];
    $userID = $_GET['maThanhVien'];
    $sql = "SELECT phim.MaPhim, phim.TenPhim, ktg.MaKTG, ktg.NgayChieu, ktg.GioChieu, ds_ve_dat.NgayDat, 
                        thanh_vien.HoTen,thanh_vien.Ma_thanh_vien, SUM(gia.DonGia) AS TongTien, GROUP_CONCAT(so_ghe.SoGhe SEPARATOR ', ') AS ve
                FROM phim
                JOIN ve ON ve.MaPhim = phim.MaPhim
                JOIN ktg ON ve.MaKTG = ktg.MaKTG
                JOIN ds_ve_dat ON ve.MaVe = ds_ve_dat.MaVe
                JOIN thanh_vien ON ds_ve_dat.Ma_thanh_vien = thanh_vien.Ma_thanh_vien
                JOIN phong ON ve.MaPhong = phong.MaPhong
                JOIN gia ON ve.MaGia = gia.MaGia
                JOIN so_ghe ON ve.SoGhe = so_ghe.SoGhe
                WHERE phim.MaPhim = '$phimID'
                    AND ktg.MaKTG = '$timeID'
                    AND ds_ve_dat.NgayDat = CURDATE()
                    AND thanh_vien.Ma_thanh_vien = '$userID'
                GROUP BY phim.MaPhim, ktg.MaKTG, ds_ve_dat.Ma_thanh_vien, ds_ve_dat.NgayDat; ";
    $result = $this->connection->query($sql);
    $data = array();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $data[] = $row;
      }
    }
    // Trả về kết quả
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode($data);

    return $response;
  }

  private function handleUrl($method)
  {

    if ($method === "getFinalVe") {
      return $this->getFinalVe();
    } else if ($method === "createTicket") {
      return $this->createNewTicket();
    }
  }

  public function processRequest($id, $method)
  {
    switch ($this->requestMethod) {
      case 'GET':
        if (isset($id)) {
          $response = $this->getVeById($id);
        } else {
          if (!isset($id))
            $response = $this->getVe();
          else
            $response = $this->handleUrl($method);
        }
        break;
      case 'POST':
        $response = $this->handleUrl($id);
        break;
      case 'PUT':
        $response = $this->updateVe($id);
        break;
      case 'Delete':
        $response = $this->deleteVe($id);
        break;

    }
    header($response['status_code_header']);
    if ($response['body']) {
      echo $response['body'];
    }
  }
}
?>