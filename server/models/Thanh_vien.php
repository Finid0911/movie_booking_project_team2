<?php
class thanh_vien {
    public $Ma_thanh_vien;
    public $HoTen;
    public $Email;
    public $MatKhau;
    public $SDT;
    public $SoThe;
    public $NgaySinh;
    public $GioiTinh;
    public $TrangThai;
  
    public function __construct($Ma_thanh_vien, $HoTen, $Email, $MatKhau, $SDT, $SoThe, $NgaySinh, $GioiTinh, $TrangThai) {
      $this->Ma_thanh_vien = $Ma_thanh_vien;
      $this->HoTen = $HoTen;
      $this->Email = $Email;
      $this->MatKhau = $MatKhau;
      $this->SDT = $SDT;
      $this->SoThe = $SoThe;
      $this->NgaySinh = $NgaySinh;
      $this->GioiTinh = $GioiTinh;
      $this->TrangThai = $TrangThai;
    }
  
    // Các phương thức getter và setter cho các thuộc tính
  
    public function getMaThanhVien() {
      return $this->Ma_thanh_vien;
    }
  
    public function setMaThanhVien($Ma_thanh_vien) {
      $this->Ma_thanh_vien = $Ma_thanh_vien;
    }
  
    public function getHoTen() {
      return $this->HoTen;
    }
  
    public function setHoTen($HoTen) {
      $this->HoTen = $HoTen;
    }
  
    public function getEmail() {
      return $this->Email;
    }
  
    public function setEmail($Email) {
      $this->Email = $Email;
    }
  
    public function getMatKhau() {
      return $this->MatKhau;
    }
  
    public function setMatKhau($MatKhau) {
      $this->MatKhau = $MatKhau;
    }
  
    public function getSDT() {
      return $this->SDT;
    }
  
    public function setSDT($SDT) {
      $this->SDT = $SDT;
    }
  
    public function getSoThe() {
      return $this->SoThe;
    }
  
    public function setSoThe($SoThe) {
      $this->SoThe = $SoThe;
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
  
    public function getTrangThai() {
      return $this->TrangThai;
    }
  
    public function setTrangThai($TrangThai) {
      $this->TrangThai = $TrangThai;
    }
  }
 ?>