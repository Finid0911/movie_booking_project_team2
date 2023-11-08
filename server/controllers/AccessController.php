<?php
include("./models/Connector.php");
include("BaseController.php");
class AccessController extends BaseController
{
    //Bảng thanh_vien
    private $table1 = 'thanh_vien';
    private $email1 = 'Email';
    private $pass1 = 'MatKhau';
    //Bảng nhan_vien
    private $table2 = 'nhan_vien';
    private $username = 'username';
    private $pass2 = 'password';
    public function __construct($requestMethod)
    {
        parent::__construct($requestMethod);
    }

    private function validateLogin($email, $password)
    {
        $sql1 = "SELECT * FROM $this->table1 WHERE $this->email1 = '$email' AND $this->pass1 = '$password'";
        $result1 = $this->connection->query($sql1);

        $sql2 = "SELECT * FROM $this->table2 WHERE $this->username = '$email' AND $this->pass2 = '$password'";
        $result2 = $this->connection->query($sql2);

        if ($result1->num_rows == 1) {
            return 1;
        } elseif($result2->num_rows == 1){
            return 2;
        }
        return 0;
    }

    private function validateSignUp($fullname, $email, $password, $phone, $birthday, $gender)
    {

    }

    public function login() {
    // Xử lý yêu cầu đăng nhập
        // Kiểm tra thông tin đăng nhập
        $return = $this->validateLogin($username, $password);
        if ($return == 1) {
            // Đăng nhập thành công
            // Redirect hoặc hiển thị trang chủ khách hàng
            header('Location: /client/index.html');
            exit();
        } elseif ($return == 2) {
            // Đăng nhập thành công
            // Redirect hoặc hiển thị trang chủ admin
            header('Location: /server/views/index.php');
            exit();
        } 
        else {
            // Đăng nhập thất bại
            // Hiển thị thông báo lỗi
        }
    }

    public function signup() {
    // Xử lý yêu cầu đăng ký
        // Kiểm tra thông tin đăng ký
        if ($this->validateSignup($username, $password)) {
            // Đăng ký thành công
            // Redirect hoặc hiển thị thông báo thành công
        } else {
            // Đăng ký thất bại
            // Hiển thị thông báo lỗi
        }
    }

    public function processRequest($id)
    {
        switch ($this->requestMethod) {
        case 'GET':
            if (isset($id)) {
            $response = $this->login($id);
            } 
            break;
        case 'POST':
            $response = $this->signUp();
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