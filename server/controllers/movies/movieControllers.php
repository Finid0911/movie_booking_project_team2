

<?php 
  include("./models/Connector.php"); 

  class MovieController {
      private $connection;
      private $requestMethod;
  
    public function __construct($requestMethod) {
          $this->connection = Connector::getInstance()->getConnection();
      }
  
    public function getMovies() {
        $movies = array();

        $query = "SELECT * FROM movies";
        $result = $this->connection->query($query);
    
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $movies[] = $row;
            }

            $result->close();
    
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($movies);
            return $response;
         }
      }
  
    public function createMovie() {
        
      }
  
    public function updateMovie() {
        
      }
  
    public function deleteMovie() {
         
      }

    private function notFoundResponse()
      {
          $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
          $response['body'] = null;
          return $response;
      }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                $response = $this->getMovies();
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
    }
  }
   
?>