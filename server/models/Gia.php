<?php
class Gia {
    public $MaGia;
    public $DonGia;
  
    public function __construct($MaGia, $DonGia) {
      $this->MaGia = $MaGia;
      $this->DonGia = $DonGia;
    }
  
    // Các phương thức getter và setter cho các thuộc tính
  
    public function getMaGia() {
      return $this->MaGia;
    }
  
    public function setMaGia($MaGia) {
      $this->MaGia = $MaGia;
    }
  
    public function getDonGia() {
      return $this->DonGia;
    }
  
    public function setDonGia($DonGia) {
      $this->DonGia = $DonGia;
    }
  }
?>