<?php
include("./models/Connector.php");
include("BaseController.php");

class UsersController extends BaseController
{
    private $table = "thanh_vien";
    private $primaryKey = "ma_thanh_vien";

    public function __construct($requestMethod)
    {
        parent::__construct($requestMethod);
    }

    public function getUsers()
    {
        $users = parent::get($this->table);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($users);
        return $response;
    }

    public function getUserById($id)
    {
        $user = parent::getById($this->table, $this->primaryKey, $id);
        if ($user) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($user);
        } else {
            $response = $this->notFoundResponse();
        }
        return $response;
    }

    public function createUser()
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

    public function updateUser($id)
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

    public function deleteUser($id)
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
                    $response = $this->getUserById($id);
                } else {
                    $response = $this->getUsers();
                }
                break;
            case 'POST':
                $response = $this->createUser();
                break;
            case 'PUT':
                $response = $this->updateUser($id);
                break;
            case 'DELETE':
                $response = $this->deleteUser($id);
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