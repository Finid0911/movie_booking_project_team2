<?php
include("./models/Connector.php");
include("BaseController.php");

class EmployeesController extends BaseController
{
    private $table = "nhan_vien";
    private $primaryKey = "ma_nv";

    public function __construct($requestMethod)
    {
        parent::__construct($requestMethod);
    }

    public function getEmployees()
    {
        $employees = parent::get($this->table);
        
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($employees);
        return $response;
    }

    public function getEmployeeById($id)
    {
        $employee = parent::getById($this->table, $this->primaryKey, $id);
        
        if ($employee) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($employee);
        } else {
            $response = $this->notFoundResponse();
        }
        
        return $response;
    }

    public function createEmployee()
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

    public function updateEmployee($id)
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

    public function deleteEmployee($id)
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
                    $response = $this->getEmployeeById($id);
                } else {
                    $response = $this->getEmployees();
                }
                break;
            case 'POST':
                $response = $this->createEmployee();
                break;
            case 'PUT':
                $response = $this->updateEmployee($id);
                break;
            case 'DELETE':
                $response = $this->deleteEmployee($id);
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