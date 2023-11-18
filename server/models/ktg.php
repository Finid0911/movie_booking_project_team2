<?php
class KTG {
    public $MaKTG;
    public $NgayChieu;
    public $GioChieu;
  
    public function __construct($MaKTG, $NgayChieu, $GioChieu) {
      $this->MaKTG = $MaKTG;
      $this->NgayChieu = $NgayChieu;
      $this->GioChieu = $GioChieu;
    }
  
    // Các phương thức getter và setter cho các thuộc tính
  
    public function getMaKTG() {
      return $this->MaKTG;
    }
  
    public function setMaKTG($MaKTG) {
      $this->MaKTG = $MaKTG;
    }
  
    public function getNgayChieu() {
      return $this->NgayChieu;
    }
  
    public function setNgayChieu($NgayChieu) {
      $this->NgayChieu = $NgayChieu;
    }
  
    public function getGioChieu() {
      return $this->GioChieu;
    }
  
    public function setGioChieu($GioChieu) {
      $this->GioChieu = $GioChieu;
    }
  }
?>