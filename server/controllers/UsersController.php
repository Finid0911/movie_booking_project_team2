<?php
class UsersControllers extends BaseController
{
    private $table = "thanh_vien";
    private $tableId = "Ma_thanh_vien";
    public function __construct($requestMethod)
    {
        parent::__construct($requestMethod);
    }

    public function get()
    {
        $user = parent::get($this->table);
        $response = null;
        if ($user) {

        }
    }
}

?>