<?php
class NhanVien {
    public $MaNV;
    public $HoTen;
    public $NgaySinh;
    public $GioiTinh;
    public $DiaChi;
    public $MaQuyen;
  
    public function __construct($MaNV, $HoTen, $NgaySinh, $GioiTinh, $DiaChi, $MaQuyen) {
      $this->MaNV = $MaNV;
      $this->HoTen = $HoTen;
      $this->NgaySinh = $NgaySinh;
      $this->GioiTinh = $GioiTinh;
      $this->DiaChi = $DiaChi;
      $this->MaQuyen = $MaQuyen;
    }
  
    // Các phương thức getter và setter cho các thuộc tính
  
    public function getMaNV() {
      return $this->MaNV;
    }
  
    public function setMaNV($MaNV) {
      $this->MaNV = $MaNV;
    }
  
    public function getHoTen() {
      return $this->HoTen;
    }
  
    public function setHoTen($HoTen) {
      $this->HoTen = $HoTen;
    }
  
    public function getNgaySinh() {
      return $this->NgaySinh;
    }
  
    public function setNgaySinh($NgaySinh) {
      $this->NgaySinh = $NgaySinh;
    }
  
    public function getGioiTinh() {
      return $this->GioiTinh;
    }
  
    public function setGioiTinh($GioiTinh) {
      $this->GioiTinh = $GioiTinh;
    }
  
    public function getDiaChi() {
      return $this->DiaChi;
    }
  
    public function setDiaChi($DiaChi) {
      $this->DiaChi = $DiaChi;
    }
  
    public function getMaQuyen() {
      return $this->MaQuyen;
    }
  
    public function setMaQuyen($MaQuyen) {
      $this->MaQuyen = $MaQuyen;
    }
  }
?>