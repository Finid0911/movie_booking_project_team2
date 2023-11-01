<?php

include("./models/Connector.php");
include("BaseController.php");

class GiaController extends BaseController
{
    private $table = "gia";
    private $primaryKey = "MaGia";

    public function __construct($requestMethod)
    {
        parent::__construct($requestMethod);
    }

    public function getGia()
    {
        $gia = parent::get($this->table);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($gia);
        return $response;
    }
 
    public function getGiaById($id)
    {
        $gia = parent::getById($this->table, $this->primaryKey, $id);
        if ($gia) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($gia);
        } else {
            $response = $this->notFoundResponse();
        }
        return $response;
    }

    public function createGia()
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

    public function updateGia($id)
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

    public function deleteGia($id)
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
                    $response = $this->getGiaById($id);
                } else {
                    $response = $this->getGia();
                }
                break;
            case 'POST':
                $response = $this->createGia();
                break;
            case 'PUT':
                $response = $this->updateGia($id);
                break;
            case 'DELETE':
                $response = $this->deleteGia($id);
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