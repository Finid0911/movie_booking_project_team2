<?php
include('./models/Connector.php');
include('BaseController.php');

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
    public function taoChiTietVe()
    {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $body = json_decode(file_get_contents('php://input'), true); // Lấy toàn bộ body dưới dạng một mảng
        // Xử lý body ở đây
        $dsghe = $body['dsghe'];
        $maphim = $body['maPhim'];
        $maktg = $body['maKtg'];
        $mave = $body['maVe'];
        
        try {
            
            // Xử lý danh sách ghế và thực hiện INSERT SQL
            foreach ($dsghe as $soghe) {
                $stmt = $conn->prepare("INSERT INTO  Ve (mave,soghe, maphim, maktg) VALUES ($mave,$soghe,$maphim,$maktg)");
                $stmt->bind_param('ssss', $mave,$soghe,$maphim,$maktg);
                $stmt->execute();
            }
            
            echo "Insert thành công vào CSDL.";
        } catch(Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
        
      }
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
      $response['body'] = json_encode($data );
  
      return $response; 
    }

    private function handleUrl($method) {
        if($method === "getFinalVe") {
          return $this->getFinalVe();
        }
    }

    public function processRequest($id, $method)
  {
    switch ($this->requestMethod) {
      case 'GET':
        if (isset($id)) {
          $response = $this->getVeById($id);
        }else {
          if(!isset($method))
              $response = $this->getVe();
          else $response = $this->handleUrl($method);
        }

        break;
      case 'POST':
        $response = $this->createVe();
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

    // public function processRequest($id)
    // {
    //     switch ($this->requestMethod)
    //     {
    //         case 'GET':
    //             if(isset($id)){
    //                 $response = $this->getVeById($id);
    //             } else {
    //                 $response = $this->getVe();
    //             }
    //             break;

    //         case 'POST':
    //             $response = $this->createVe();
    //             break;

    //         case 'PUT':
    //             $response = $this->updateVe($id);
    //             break;

    //         case 'DELETE':
    //             $response = $this->deleteVe($id);
    //             break;
    //     }
    //     header($response['status_code_header']);
    //     if ($response['body']) {
    //         echo $response['body'];
    //     }
    // }
}
?>