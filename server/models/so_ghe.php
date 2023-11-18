<?php
class BaoGia {
    public $MaDD;
    public $MaKTG;
    public $MaLG;
    public $MaGia;
  
    public function __construct($MaDD, $MaKTG, $MaLG, $MaGia) {
      $this->MaDD = $MaDD;
      $this->MaKTG = $MaKTG;
      $this->MaLG = $MaLG;
      $this->MaGia = $MaGia;
    }
  
    // Các phương thức getter và setter cho các thuộc tính
  
    public function getMaDD() {
      return $this->MaDD;
    }
  
    public function setMaDD($MaDD) {
      $this->MaDD = $MaDD;
    }
  
    public function getMaKTG() {
      return $this->MaKTG;
    }
  
    public function setMaKTG($MaKTG) {
      $this->MaKTG = $MaKTG;
    }
  
    public function getMaLG() {
      return $this->MaLG;
    }
  
    public function setMaLG($MaLG) {
      $this->MaLG = $MaLG;
    }
  
    public function getMaGia() {
      return $this->MaGia;
    }
  
    public function setMaGia($MaGia) {
      $this->MaGia = $MaGia;
    }
  }
?>