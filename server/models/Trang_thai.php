<?php
class TrangThai {
    public $MaTT;
    public $TenTT;
  
    public function __construct($MaTT, $TenTT) {
      $this->MaTT = $MaTT;
      $this->TenTT = $TenTT;
    }
  
    // Các phương thức getter và setter cho các thuộc tính
  
    public function getMaTT() {
      return $this->MaTT;
    }
  
    public function setMaTT($MaTT) {
      $this->MaTT = $MaTT;
    }
  
    public function getTenTT() {
      return $this->TenTT;
    }
  
    public function setTenTT($TenTT) {
      $this->TenTT = $TenTT;
    }
  }
?>