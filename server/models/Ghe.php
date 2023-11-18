<?php
class Ghe {
    public $MaGhe;
    public $MaLG;
    public $MaPhong;
    public $SoGhe;
    public $MaTT;
  
    public function __construct($MaGhe, $MaLG, $MaPhong, $SoGhe, $MaTT) {
      $this->MaGhe = $MaGhe;
      $this->MaLG = $MaLG;
      $this->MaPhong = $MaPhong;
      $this->SoGhe = $SoGhe;
      $this->MaTT = $MaTT;
    }
  
    // Các phương thức getter và setter cho các thuộc tính
  
    public function getMaGhe() {
      return $this->MaGhe;
    }
  
    public function setMaGhe($MaGhe) {
      $this->MaGhe = $MaGhe;
    }
  
    public function getMaLG() {
      return $this->MaLG;
    }
  
    public function setMaLG($MaLG) {
      $this->MaLG = $MaLG;
    }
  
    public function getMaPhong() {
      return $this->MaPhong;
    }
  
    public function setMaPhong($MaPhong) {
      $this->MaPhong = $MaPhong;
    }
  
    public function getSoGhe() {
      return $this->SoGhe;
    }
  
    public function setSoGhe($SoGhe) {
      $this->SoGhe = $SoGhe;
    }
  
    public function getMaTT() {
      return $this->MaTT;
    }
  
    public function setMaTT($MaTT) {
      $this->MaTT = $MaTT;
    }
  }
?>