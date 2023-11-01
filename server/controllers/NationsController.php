<?php
    include('./models/Connector.php');
    include('BaseController.php');

    class NationsController extends BaseController
    {
        private $table = "quoc_gia";
        private $tableId = "";

        public function __construct($requestMethod)
        {
            parent::__construct($requestMethod);
        }

        public function getNations()
        {
            $nations = parent::get($this->table);
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($nations);
            return $response;
        }

        public function getNationById($id)
        {
            $nation = parent::getById($this->table, $this->tableId, $id);
            echo json_encode($nation);
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($nation);
            return $response;
        }

        public function createNation()
        {
            $response = null;
            $input = (array) json_decode(file_get_contents('php://input'), true);
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $result = parent::post($this->table, $input);
            print_r($result);
            return $response;
        }

        public function updateNation($id)
        {
            $response = null;
            $input = (array) json_decode(file_get_contents('php://input'), true);
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $result = parent::put($this->table, $this->tableId, $id, $input);
            $response['body'] = json_encode($result);
            return $response;
        }

        public function deleteNation($id)
        {
            $nation = parent::delete($this->table, $this->tableId, $id);
            echo json_encode($nation);
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($nation);
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
            switch($this->requestMethod){
                case 'GET':
                    if(isset($id)) {
                        $response = $this->getNationById($id);
                    } else {
                        $response = $this->getNations();
                    }
                    break;
                
                case 'POST':
                    $response = $this->createNation();
                    break;

                case 'PUT':
                    $response = $this->updateNation($id);
                    break;
                
                case 'DELETE':
                    $response = $this->deleteNation($id);
                    break;
            }
            header($response['status_code_header']);
            if ($response['body']) {
                echo $response['body'];
            }
        }
    }
?>