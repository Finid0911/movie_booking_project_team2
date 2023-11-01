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

    public function processRequest($id = null)
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($id) {
                    $response = $this->getPhongById($id);
                } else {
                    $response = $this->getPhong();
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
}
?>