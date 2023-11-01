<?php
include("./models/Connector.php");
include("BaseController.php");

class KhungThoiGianController extends BaseController
{
    private $table = "ktg";
    private $primaryKey = "MaKTG";

    public function __construct($requestMethod)
    {
        parent::__construct($requestMethod);
    }

    public function getKhungThoiGian()
    {
        $khungThoiGian = parent::get($this->table);

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($khungThoiGian);
        return $response;
    }

    public function getKhungThoiGianById($id)
    {
        $khungThoiGian = parent::getById($this->table, $this->primaryKey, $id);

        if ($khungThoiGian) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($khungThoiGian);
        } else {
            $response = $this->notFoundResponse();
        }

        return $response;
    }

    public function createKhungThoiGian()
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

    public function updateKhungThoiGian($id)
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

    public function deleteKhungThoiGian($id)
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

    public function processRequest($id = null)
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($id) {
                    $response = $this->getKhungThoiGianById($id);
                } else {
                    $response = $this->getKhungThoiGian();
                }
                break;
            case 'POST':
                $response = $this->createKhungThoiGian();
                break;
            case 'PUT':
                $response = $this->updateKhungThoiGian($id);
                break;
            case 'DELETE':
                $response = $this->deleteKhungThoiGian($id);
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
}
?>