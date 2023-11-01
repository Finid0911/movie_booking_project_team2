<?php
    include('./models/Connector.php');
    include('BaseController.php');

    class LabelsController extends BaseController 
    {
        private $table = "Nhan";
        private $tableId = "MaNhan";
        
        public function __construct($requestMethod) 
        {
            parent::__construct($requestMethod);
        }

        public function getLabels()
        {
            $labels = parent::get($this->table);
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($labels);
            return $response;
        }

        public function getLabelById($id)
        {
            $label = parent::getById($this->table, $this->tableId, $id);
            echo json_encode($label);
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($label);
            return $response;
        }

        public function creatLabels()
        {
            $response = null;
            $input = (array) json_decode(file_get_contents('php://input'), true);
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $result = parent::post($this->table, $input);
            print_r($result);
            return $response;
        }

        public function updateLabel($id)
        {
            $response = null;
            $input = (array) json_decode(file_get_contents('php://input'), true);
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $result = parent::put($this->table, $this->tableId, $id, $input);
            $response['body'] = json_encode($result);
            return $response;
        }

        public function deleteLabel($id)
        {
            $label = parent::delete($this->table, $this->tableId, $id);
            echo json_encode($label);
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($label);
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
            switch ($this->requestMethod)
            {
                case 'GET':
                    if(isset($id)){
                        $response = $this->getLabelById($id);
                    } else {
                        $response = $this->getLabels();
                    }
                    break;

                case 'POST':
                    $response = $this->creatLabels();
                    break;

                case 'PUT':
                    $response = $this->updateLabel($id);
                    break;

                case 'DELETE':
                    $response = $this->deleteLabel($id);
                    break;
            }
            header($response['status_code_header']);
            if ($response['body']) {
                echo $response['body'];
            }
        }
    }
?>