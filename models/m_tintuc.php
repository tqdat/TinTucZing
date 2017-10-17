<?php 
include ('database.php');

/**
* 
*/
class M_tintuc extends database
{
	
	function getSlide()
	{
		$sql = "SELECT * FROM slide";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}
	function getMenu()
	{
		$sql = "SELECT tl.*, GROUP_CONCAT(Distinct lt.id,':', lt.Ten,':', lt.TenKhongDau ) AS LoaiTin, tt.id as idTin, tt.TieuDe as TieuDeTin, tt.Hinh as HinhTin, tt.TomTat as TomTatTin, tt.TieuDeKhongDau as TieuDeKhongDauTin FROM theloai tl INNER JOIN loaitin lt ON lt.idTheloai = tl.id INNER JOIN tintuc tt ON tt.idLoaiTin = lt.id  GROUP BY tl.id";
		$this->setQuery($sql);
		return $this->loadAllRows();

	}

	function getTintucByIdLoai($id_loaitin, $vitri=-1, $limit=-1)
	{
		$sql = "SELECT * FROM tintuc WHERE idLoaiTin = $id_loaitin";
		if($vitri>-1 && $limit>1){
			$sql .=" limit $vitri,$limit";
		}
		$this->setQuery($sql);
		return $this->loadAllRows(array($id_loaitin));
	}

	function getTitlebyId($id_loaitin)
	{
		$sql = "SELECT Ten FROM loaitin WHERE id = $id_loaitin";
		$this->setQuery($sql);
		return $this->loadRow(array($id_loaitin));
	}

	function getChitietTin($id)
	{
		$sql = "SELECT * FROM tintuc WHERE id = $id";
		$this->setQuery($sql);
		return $this->loadRow(array($id));
	}

	function getComment($id_tin)
	{
		$sql = "SELECT * FROM comment WHERE idTinTuc = $id_tin";
		$this->setQuery($sql);
		return $this->loadAllRows(array($id_tin));
	}

	function getRelatedNew($alias)
	{
		$sql = "SELECT tt.*,lt.TenKhongDau as TenKhongDau, lt.id as idLoaitin FROM tintuc tt INNER JOIN loaitin lt ON tt.idLoaitin = lt.id WHERE lt.TenKhongDau = '$alias' limit 0,5";
		$this->setQuery($sql);
		return $this->loadAllRows(array($alias));
	}

	function getAliasLoaitin($id_loaitin)
	{
		$sql = "SELECT TenKhongDau FROM loaitin WHERE id= $id_loaitin";
		$this->setQuery($sql);
		return $this->loadRow(array($id_loaitin));
	}

	function getTinNoiBat()
	{
		$sql = "SELECT tt.*,lt.TenKhongDau as TenKhongDau, lt.id as idLoaitin FROM tintuc tt INNER JOIN loaitin lt ON tt.idLoaitin = lt.id WHERE tt.NoiBat = 1 limit 0,5";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}

	function addComment($id_user, $id_tin, $noidung)
	{
		$sql = "INSERT INTO comment(idUser,idTinTuc,NoiDung) VALUES (?,?,?)";
		$this->setQuery($sql);
		return $this->execute(array($id_user, $id_tin, $noidung));
	}

	function search($key)
	{
		$sql = "SELECT tt.*, lt.TenKhongDau as ten_khong_dau FROM tintuc tt INNER JOIN loaitin lt ON tt.idLoaiTin = lt.id WHERE tt.TieuDe like '%$key%' or tt.TomTat like '%$key%' ";
		$this->setQuery($sql);
		return $this->loadAllRows(array($key));
	}
}
 ?>