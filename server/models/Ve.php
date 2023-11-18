<?php
class Ve {
    public $MaVe;
    public $MaPhim;
    public $MaKTG;
    public $SoGhe;
    public $MaPhong;
    public $MaGia;
  
    public function __construct($MaVe, $MaPhim, $MaKTG, $SoGhe, $MaPhong, $MaGia) {
      $this->MaVe = $MaVe;
      $this->MaPhim = $MaPhim;
      $this->MaKTG = $MaKTG;
      $this->SoGhe = $SoGhe;
      $this->MaPhong = $MaPhong;
      $this->MaGia = $MaGia;
    }
  
    // Các phương thức getter và setter cho các thuộc tính
  
    public function getMaVe() {
      return $this->MaVe;
    }
  
    public function setMaVe($MaVe) {
      $this->MaVe = $MaVe;
    }
  
    public function getMaPhim() {
      return $this->MaPhim;
    }
  
    public function setMaPhim($MaPhim) {
      $this->MaPhim = $MaPhim;
    }
  
    public function getMaKTG() {
      return $this->MaKTG;
    }
  
    public function setMaKTG($MaKTG) {
      $this->MaKTG = $MaKTG;
    }
  
    public function getSoGhe() {
      return $this->SoGhe;
    }
  
    public function setSoGhe($SoGhe) {
      $this->SoGhe = $SoGhe;
    }
  
    public function getMaPhong() {
      return $this->MaPhong;
    }
  
    public function setMaPhong($MaPhong) {
      $this->MaPhong = $MaPhong;
    }
  
    public function getMaGia() {
      return $this->MaGia;
    }
  
    public function setMaGia($MaGia) {
      $this->MaGia = $MaGia;
    }
  }
?>