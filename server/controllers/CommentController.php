<?php
include("./models/Connector.php");
include("BaseController.php");
require("./controllers/uuidv4Gen.php");
class CommentController extends BaseController
{
    private $tableId = "commentID";
    private $table = "comments";

    public function __construct($requestMethod)
    {
        parent::__construct($requestMethod);
    }

    public function getComments()
    {

        $maPhim = $_GET["maPhim"];
        $query = "Select * from comments inner join thanh_vien on comments.ma_thanh_vien = thanh_vien.Ma_thanh_vien ";
        if (isset($maPhim)) {
            $query = $query . "where maPhim = '$maPhim' ";
        }
        $query = $query . "order by createdDate desc";
        $result = $this->connection->query($query);
        $comments = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $comments[] = $row;
            }
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($comments);
        return $response;
    }

    public function getCommentID($id)
    {
        $comments = parent::getById($this->table, $this->tableId, $id);
        echo json_encode($comments);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($comments);
        return $response;

    }

    public function createComment()
    {
        $response = null;
        $body = json_decode(file_get_contents('php://input'), true);
        $maThanhVien = $body['maThanhVien'];
        $content = $body['content'];
        $maPhim = $body['maPhim'];
        $commentID = guidv4();
        $query = "Insert into comments(commentID, content, MaPhim, ma_thanh_vien, createdDate) Values('$commentID', '$content', '$maPhim', '$maThanhVien', now())";
        $this->connection->query($query);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode(array("message" => "Thành công"));
        return $response;
    }

    public function updateComment()
    {
        $response = null;
        return $response;
    }

    public function deleteComment()
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

    private function handleUrl($method)
    {
        $response = null;
        return $response;
    }

    public function processRequest($id, $method)
    {
        switch ($this->requestMethod) {
            case 'GET':
                if (isset($id)) {
                    $response = $this->getCommentID($id);
                } else {
                    if (!isset($method))
                        $response = $this->getComments();
                    else
                        $response = $this->handleUrl($method);
                }
                break;
            case 'POST':
                $response = $this->createComment();
                break;
            case 'PUT':
                $response = $this->updateComment();
                break;
            case 'Delete':
                $response = $this->deleteComment();
                break;

        }

        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }
}


?>