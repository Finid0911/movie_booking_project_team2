<?php

include("./models/Connector.php");
include("BaseController.php");

class ChairsController extends BaseController
{
    private $table = "Ghe";
    private $primaryKey = "MaGhe";

    public function __construct($requestMethod)
    {
        parent::__construct($requestMethod);
    }

    public function getGhe()
    {
        $ghe = parent::get($this->table);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($ghe);
        return $response;
    }

    public function getGheById($id)
    {
        $ghe = parent::getById($this->table, $this->primaryKey, $id);
        if ($ghe) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($ghe);
        } else {
            $response = $this->notFoundResponse();
        }
        return $response;
    }

    public function createGhe()
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

    public function updateGhe($id)
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

    public function deleteGhe($id)
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
                    $response = $this->getGheById($id);
                } else {
                    $response = $this->getGhe();
                }
                break;
            case 'POST':
                $response = $this->createGhe();
                break;
            case 'PUT':
                $response = $this->updateGhe($id);
                break;
            case 'DELETE':
                $response = $this->deleteGhe($id);
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