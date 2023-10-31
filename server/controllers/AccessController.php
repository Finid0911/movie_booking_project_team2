<?php
include("./models/Connector.php");
include("BaseController.php");
class AccessController extends BaseController
{
    private $table = 'thanh_vien';
    private $field1 = 'Email';
    private $field2 = 'MatKhau';
    public function __construct($requestMethod)
    {
        parent::__construct($requestMethod);
    }

    private function validateLogin($email, $password)
    {
        
    }

    private function validateSignUp($fullname, $email, $password, $phone, $birthday, $gender)
    {

    }

    public function homeClient() {
    // Xử lý yêu cầu trang chủ client
    // ...
    }

    public function homeAdmin() {
    // Xử lý yêu cầu trang chủ admin
    // ...
    }

    public function login() {
    // Xử lý yêu cầu đăng nhập
        // Kiểm tra thông tin đăng nhập
        if ($this->validateLogin($username, $password)) {
            // Đăng nhập thành công
            // Redirect hoặc hiển thị trang chủ
        } else {
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