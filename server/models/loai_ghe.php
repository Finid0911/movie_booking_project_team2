<?php
class LoaiGhe {
    public $MaLG;
    public $TenLG;
    public $GiaBan;
  
    public function __construct($MaLG, $TenLG, $GiaBan) {
      $this->MaLG = $MaLG;
      $this->TenLG = $TenLG;
      $this->GiaBan = $GiaBan;
    }
  
    // Các phương thức getter và setter cho các thuộc tính
  
    public function getMaLG() {
      return $this->MaLG;
    }
  
    public function setMaLG($MaLG) {
      $this->MaLG = $MaLG;
    }
  
    public function getTenLG() {
      return $this->TenLG;
    }
  
    public function setTenLG($TenLG) {
      $this->TenLG = $TenLG;
    }
  
    public function getGiaBan() {
      return $this->GiaBan;
    }
  
    public function setGiaBan($GiaBan) {
      $this->GiaBan = $GiaBan;
    }
  }
?>