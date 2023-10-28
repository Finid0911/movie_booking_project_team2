<?php
class BaseController
{
    protected $connection; // Kết nối đến cơ sở dữ liệu
    protected $requestMethod;

    public function __construct($requestMethod)
    {
        $this->connection = Connector::getInstance()->getConnection();
        $this->requestMethod = $requestMethod;
    }

    /**
     * Get method 
     * Author: ptrung26
     * @param string $table Tên của bảng 
     * 
     */
    public function get($table)
    {

        $sql = "SELECT * FROM $table";
        $result = $this->connection->query($sql);
        $data = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    /**
     * Get by id 
     * Author: ptrung26
     * @param string $table Tên của bảng 
     * @param string $tableId Tên khóa chính
     * @param string $id Id của khóa chính
     */
    public function getById($table, $tableId, $id)
    {
        $sql = "SELECT * FROM $table WHERE $tableId = '$id'";
        $result = $this->connection->query($sql);
        $data = null;
        if ($result->num_rows == 1) {
            $data = $result->fetch_assoc();
        }

        return $data;

    }

    /**
     * Post method 
     * Author: ptrung26
     * @param string $table Tên bảng 
     * @param mixed $data Thông tin bản ghi cần thêm
     */
    public function post($table, $data)
    {
        // Chuẩn bị dữ liệu và thực hiện truy vấn INSERT
        $columns = implode(', ', array_keys($data));
        $values = "'" . implode("', '", $data) . "'";
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        // uuidv4: nghiên cứu 
        printf("uniqid(): %s\r\n", uniqid());

        if ($this->connection->query($sql) === TRUE) {
            return "Thêm bản ghi thành công";
        } else {
            return $this->connection->error;
        }

    }

    /**
     * Put method 
     * Author: ptrung26
     * @param string $table Tên bảng 
     * @param string $tableId Tên khóa chính
     * @param string $id Id của khóa chính
     * @param mixed $data Thông tin bản ghi cần cập nhật
     */
    public function put($table, $tableId, $id, $data)
    {
        // Chuẩn bị dữ liệu và thực hiện truy vấn UPDATE
        $setClause = "";
        foreach ($data as $key => $value) {
            $setClause .= "$key = '$value', ";
        }
        $setClause = rtrim($setClause, ', '); // Loại bỏ dấu phẩy cuối cùng

        $sql = "UPDATE $table SET $setClause WHERE $tableId = $id";

        if ($this->connection->query($sql) === TRUE) {
            return "Tài nguyên đã được cập nhật";
        } else {
            return "Lỗi khi cập nhật tài nguyên: " . $this->connection->error;
        }
    }
    /**
     * Delete method 
     * Author: ptrung26
     * @param string $table Tên bảng 
     * @param string $tableId Tên khóa chính
     * @param string $id Id của khóa chính
     */
    public function delete($table, $tableId, $id)
    {
        $sql = "DELETE FROM $table WHERE $tableId = $id";

        if ($this->connection->query($sql) === TRUE) {
            return "Tài nguyên đã bị xóa";
        } else {
            return "Lỗi khi xóa tài nguyên: " . $this->connection->error;
        }
    }
}


?>