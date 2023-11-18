<?php
class Phim {
    public $MaPhim;
    public $TenPhim;
    public $AnhDaiDien;
    public $NamSX;
    public $ThoiLuong;
    public $KhoiChieu;
    public $KetThuc;
    public $DaoDien;
    public $DienVienChinh;
    public $NoiDung;
    public $Trailer;
    public $MaDD;
    public $MaTL;
    public $MaQG;
    public $MaNhan;
    public $Ma_NV;
  
    public function __construct($MaPhim, $TenPhim, $AnhDaiDien, $NamSX, $ThoiLuong, $KhoiChieu, $KetThuc, $DaoDien, $DienVienChinh, $NoiDung, $Trailer, $MaDD, $MaTL, $MaQG, $MaNhan, $Ma_NV) {
      $this->MaPhim = $MaPhim;
      $this->TenPhim = $TenPhim;
      $this->AnhDaiDien = $AnhDaiDien;
      $this->NamSX = $NamSX;
      $this->ThoiLuong = $ThoiLuong;
      $this->KhoiChieu = $KhoiChieu;
      $this->KetThuc = $KetThuc;
      $this->DaoDien = $DaoDien;
      $this->DienVienChinh = $DienVienChinh;
      $this->NoiDung = $NoiDung;
      $this->Trailer = $Trailer;
      $this->MaDD = $MaDD;
      $this->MaTL = $MaTL;
      $this->MaQG = $MaQG;
      $this->MaNhan = $MaNhan;
      $this->Ma_NV = $Ma_NV;
    }
  
    // Các phương thức getter và setter cho các thuộc tính
  
    public function getMaPhim() {
      return $this->MaPhim;
    }
  
    public function setMaPhim($MaPhim) {
      $this->MaPhim = $MaPhim;
    }
  
    public function getTenPhim() {
      return $this->TenPhim;
    }
  
    public function setTenPhim($TenPhim) {
      $this->TenPhim = $TenPhim;
    }
  
    public function getAnhDaiDien() {
      return $this->AnhDaiDien;
    }
  
    public function setAnhDaiDien($AnhDaiDien) {
      $this->AnhDaiDien = $AnhDaiDien;
    }
  
    public function getNamSX() {
      return $this->NamSX;
    }
  
    public function setNamSX($NamSX) {
      $this->NamSX = $NamSX;
    }
  
    public function getThoiLuong() {
      return $this->ThoiLuong;
    }
  
    public function setThoiLuong($ThoiLuong) {
      $this->ThoiLuong = $ThoiLuong;
    }
  
    public function getKhoiChieu() {
      return $this->KhoiChieu;
    }
  
    public function setKhoiChieu($KhoiChieu) {
      $this->KhoiChieu = $KhoiChieu;
    }
  
    public function getKetThuc() {
      return $this->KetThuc;
    }
  
    public function setKetThuc($KetThuc) {
      $this->KetThuc = $KetThuc;
    }
  
    public function getDaoDien() {
      return $this->DaoDien;
    }
  
    public function setDaoDien($DaoDien) {
      $this->DaoDien = $DaoDien;
    }
  
    public function getDienVienChinh() {
      return $this->DienVienChinh;
    }
  
   public function setDienVienChinh($DienVienChinh) {
      $this->DienVienChinh = $DienVienChinh;
    }
  
    public function getNoiDung() {
      return $this->NoiDung;
    }
  
    public function setNoiDung($NoiDung) {
      $this->NoiDung = $NoiDung;
    }
  
    public function getTrailer() {
      return $this->Trailer;
    }
  
    public function setTrailer($Trailer) {
      $this->Trailer = $Trailer;
    }
  
    public function getMaDD() {
      return $this->MaDD;
    }
  
    public function setMaDD($MaDD) {
      $this->MaDD = $MaDD;
    }
  
    public function getMaTL() {
      return $this->MaTL;
    }
  
    public function setMaTL($MaTL) {
      $this->MaTL = $MaTL;
    }
  
    public function getMaQG() {
      return $this->MaQG;
    }
  
    public function setMaQG($MaQG) {
      $this->MaQG = $MaQG;
    }
  
    public function getMaNhan() {
      return $this->MaNhan;
    }
  
    public function setMaNhan($MaNhan) {
      $this->MaNhan = $MaNhan;
    }
  
    public function getMa_NV() {
      return $this->Ma_NV;
    }
  
    public function setMa_NV($Ma_NV) {
      $this->Ma_NV = $Ma_NV;
    }
  }
?>