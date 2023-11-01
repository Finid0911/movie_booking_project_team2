<?php
include("./models/Connector.php");
include("BaseController.php");
class RolesController extends BaseController
{
    private $table = "quyen";
    private $primaryKey = "ma_quyen";

    public function __construct($requestMethod)
    {
        parent::__construct($requestMethod);
    }

    public function getRoles()
    {
        $roles = parent::get($this->table);
        
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($roles);
        return $response;
    }

    public function getRoleById($id)
    {
        $role = parent::getById($this->table, $this->primaryKey, $id);
        
        if ($role) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($role);
        } else {
            $response = $this->notFoundResponse();
        }
        
        return $response;
    }

    public function createRole()
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

    public function updateRole($id)
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

    public function deleteRole($id)
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
                    $response = $this->getRoleById($id);
                } else {
                    $response = $this->getRoles();
                }
                break;
            case 'POST':
                $response = $this->createRole();
                break;
            case 'PUT':
                $response = $this->updateRole($id);
                break;
            case 'DELETE':
                $response = $this->deleteRole($id);
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