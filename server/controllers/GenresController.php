<?php
    include('./models/Connector.php');
    include('BaseController.php');

    class GenresController extends BaseController 
    {
        private $table = "The_loai";
        private $tableId = "MaTL";
        
        public function __construct($requestMethod)
        {
            parent::__construct($requestMethod);
        }

        public function getGenres()
        {
            $genres = parent::get($this->table);
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($genres);
            return $response;
        }

        public function getGenreById($id) 
        {
            $genre = parent::getById($this->table, $this->tableId, $id);
            echo json_encode($genre);
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($genre);
            return $response;
        }

        public function createGenre()
        {
            $response = null;
            $input = (array) json_decode(file_get_contents('php://input'), true);
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $result = parent::post($this->table, $input);
            print_r($result);
            return $response;
        }

        public function updateGenre($id)
        {
            $response = null;
            $input = (array) json_decode(file_get_contents('php://input'), true);
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $result = parent::put($this->table, $this->tableId, $id, $input);
            $response['body'] = json_encode($result);
            return $response;
        }

        public function deleteGenre($id)
        {
            $genre = parent::delete($this->table, $this->tableId, $id);
            echo json_encode($genre);
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($genre);
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
                        $response = $this->getGenreById($id);
                    } else {
                        $response = $this->getGenres();
                    }
                    break;
                
                case 'POST':
                    $response = $this->createGenre();
                    break;

                case 'PUT':
                    $response = $this->updateGenre($id);
                    break;
                
                case 'DELETE':
                    $response = $this->deleteGenre($id);
                    break;
            }
            header($response['status_code_header']);
            if ($response['body']) {
                echo $response['body'];
            }
        }
    }
?>