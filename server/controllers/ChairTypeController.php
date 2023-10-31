<?php
include("./models/Connector.php");
include("BaseController.php");
class ChairTypeController extends BaseController
{
  private $tableId = "MaLG";
  private $table = "loai_ghe";

  public function __construct($requestMethod)
  {
    parent::__construct($requestMethod);
  }

  public function getChairTypes()
  {

    $chairtypes = parent::get($this->table);

    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode($chairtypes);
    return $response;
  }

  public function getChairTypeById($id)
  {
    $chairtype = parent::getById($this->table, $this->tableId, $id);
    echo json_encode($chairtype);
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode($chairtype);
    return $response;

  }

  public function createChairType()
  {
    $response = null;
    $input = (array) json_decode(file_get_contents('php://input'), TRUE);
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $result = parent::post($this->table, $input);
    print_r($result);
    return $response;
  }

  public function updateChairType()
  {
    $response = null;
    return $response;
  }

  public function deleteChairType()
  {
    $response = null;
    return $response;
  }

  private function notFoundResponse()
  {
    $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
    $response['body'] = null;
    return $response;
  }

  public function processRequest($id)
  {
    switch ($this->requestMethod) {
      case 'GET':
        if (isset($id)) {
          $response = $this->getChairTypeById($id);
        }else {
          $response = $this->getChairTypes();
        }
        break;
      case 'POST':
        $response = $this->createChairType();
        break;
      case 'PUT':
        break;
      case 'Delete':
        break;

    }
    header($response['status_code_header']);
    if ($response['body']) {
      echo $response['body'];
    }
  }
}

?>