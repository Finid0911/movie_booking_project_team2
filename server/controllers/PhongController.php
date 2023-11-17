<?php

include("./models/Connector.php");
include("BaseController.php");

class PhongController extends BaseController
{
    private $table = "Phong";
    private $primaryKey = "MaPhong";

    public function __construct($requestMethod)
    {
        parent::__construct($requestMethod);
    }

    public function getPhong()
    {
        $phong = parent::get($this->table);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($phong);
        return $response;
    }

    public function getPhongById($id)
    {
        $phong = parent::getById($this->table, $this->primaryKey, $id);
        if ($phong) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($phong);
        } else {
            $response = $this->notFoundResponse();
        }
        return $response;
    }

    public function createPhong()
    {
        $input = (array) json_decode(file_get_contents('php://input'), true);
        $result = parent::post($this->table, $input);
        if ($result) {
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = json_encode($result);
        } else {
            $response['status_code_header'] = 'HTTP/1.1 500 Internal Server Error';
            $response['body'] = null;
        }
        return $response;
    }

    public function updatePhong($id)
    {
        $input = (array) json_decode(file_get_contents('php://input'), true);
        $result = parent::put($this->table, $this->primaryKey, $id, $input);
        if ($result) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($result);
        } else {
            $response = $this->notFoundResponse();
        }
        return $response;
    }

    public function deletePhong($id)
    {
        $result = parent::delete($this->table, $this->primaryKey, $id);
        if ($result) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = null;
        } else {
            $response = $this->notFoundResponse();
        }
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
    public function getPhongbyPhimAndKtg()
    {
      $response = null;
  
      // Lấy tham số từ yêu cầu Ajax
      $phimID = $_GET['maPhim'];
      $timeID = $_GET['maKTG']; 
      $sql = "select ktg.MaKTG,NgayChieu,GioChieu,lich_chieu.MaPhong,lich_chieu.MaPhim,TenPhong,TenPhim from ktg,lich_chieu,phong,phim 
                where ktg.MaKTG = lich_chieu.MaKTG 
                and lich_chieu.MaPhong = phong.MaPhong
                and phim.MaPhim = lich_chieu.MaPhim
                and ktg.MaKTG = '$timeID' 
                and lich_chieu.MaPhim = '$phimID';";
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
        if($method === "getPhongbyPhimAndKtg") {
          return $this->getPhongbyPhimAndKtg();
        }
      }

      public function processRequest($id, $method)
      {
          switch ($this->requestMethod) {
              case 'GET':
                  if (isset($id)) {
                      $response = $this->getPhongById($id);
                  } else {
                      if(!isset($method))
                        $response = $this->getPhong();
                      else $response = $this->handleUrl($method);
                  }
                  break;
              case 'POST':
                  $response = $this->createPhong();
                  break;
              case 'PUT':
                  $response = $this->updatePhong($id);
                  break;
              case 'DELETE':
                  $response = $this->deletePhong($id);
                  break;
              default:
                  $response = $this->notFoundResponse();
                  break;
          }
          header($response['status_code_header']);
          if ($response['body']) {
              echo $response['body'];
          }
      }
    // public function processRequest($id = null)
    // {
    //     switch ($this->requestMethod) {
    //         case 'GET':
    //             if ($id) {
    //                 $response = $this->getPhongById($id);
    //             } else {
    //                 $response = $this->getPhong();
    //             }
    //             break;
    //         case 'POST':
    //             $response = $this->createPhong();
    //             break;
    //         case 'PUT':
    //             $response = $this->updatePhong($id);
    //             break;
    //         case 'DELETE':
    //             $response = $this->deletePhong($id);
    //             break;
    //         default:
    //             $response = $this->notFoundResponse();
    //             break;
    //     }
    //     header($response['status_code_header']);
    //     if ($response['body']) {
    //         echo $response['body'];
    //     }
    // }
}
?>