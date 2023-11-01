<?php
    include("./models/Connector.php");
    include("BaseController.php");

    class FormatsController extends BaseController
    {
        private $tableId = "MaDD";
        private $table = "Dinh_dang";

        public function __construct($requestMethod)
        {
            parent::__construct($requestMethod);
        }

        public function getFormats(){
            $formats = parent::get($this->table);
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($formats);
            return $response;
        }

        public function getFormatById($id)
        {
            $format = parent::getById($this->table, $this->tableId, $id);
            echo json_encode($format);
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($format);
            return $response;
        }

        public function creatFormat()
        {
            $response = null;
            $input = (array) json_decode(file_get_contents('php://input'), true);
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $result = parent::post($this->table, $input);
            print_r($result);
            return $response;
        }

        public function updateFormat($id){
            $response = null;
            $input = (array) json_decode(file_get_contents('php://input'), true);
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $result = parent::put($this->table, $this->tableId, $id, $input);
            $response['body'] = json_encode($result);
            return $response;
        }

        public function deleteFormat($id)
        {
            $format = parent::delete($this->table, $this->tableId, $id);
            echo json_encode($format);
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($format);
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
                    if(isset($id)) {
                        $response = $this->getFormatById($id);
                    } else {
                        $response = $this->getFormats();
                    }
                    break;

                case 'POST':
                    $response = $this->creatFormat();
                    break;

                case 'PUT':
                    $response = $this->updateFormat($id);
                    break;
                    
                case 'DELETE':
                    $response = $this->deleteFormat($id);
                    break;
            }
            header($response['status_code_header']);
            if ($response['body']) {
                echo $response['body'];
            }
        }
    }
?>