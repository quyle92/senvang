<?php
require('lib/db.php');
@session_start();


$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];
$trungtam=$_SESSION['TenTrungTam'];
$tungay=@$_POST['tungay'];
$denngay=@$_POST['denngay'];
$dengio = @$_POST['dengio'];
if ($tugio == '' || $tugio == null) $tugio = "00:01";
if ($dengio == '' || $dengio == null) $dengio = "23:00";

$chinhanh=@$_POST['chinhanh'];
$thungan=@$_POST['thungan'];

if($tungay == "")
{
	$tungay = date('d-m-Y');
}
if($denngay == "")
{
	$denngay = date('d-m-Y');
}
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Giải pháp quản lý SPA toàn diện - ZinSPA</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="Phần mềm quản lý nhà hàng ZinRes" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
 <!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style1.css" rel='stylesheet' type='text/css' />
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>


<!----webfonts--->
<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
<link href="images/favicon-zintech.png" rel='icon' type='image/x-icon' />	
<!---//webfonts--->  
<!-- Boostrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
</script>
<style>
.table.doanhthu > tbody > tr:first-child > td {
	color: green;
	font-weight: 700;
}
</style>
</head>
<body>
<div id="wrapper">
     <?php //include 'menu.php'; ?>
        <div id="page-wrapper">
        <div class="col-md-12 graphs">
	   <div class="xs">

  	 <h4>BẠN ĐANG ĐĂNG NHẬP VỚI QUYỀN - <?php echo $ten; ?> </h4>
     <form action="" method="post">
	 <div class="row">
		<div class="col-md-2" style="margin-bottom:5px">Chi nhánh:</div>
		<div class="col-md-3" style="margin-bottom:5px">
			<select name="chinhanh">
				<option value="all">Tat ca</option>
<?php 
	$sql="SELECT * FROM tblDMTrungTam";
	try
	{
		$result_tt = sqlsrv_query($dbCon, $sql);
		if($result_tt != false)
		{
			foreach ($result_tt as $r)
			{
?>
			<?php if($chinhanh == $r['MaTrungTam'])
				{
			 ?>
		 			<option value="<?php echo $r['MaTrungTam'];?>" selected="selected"><?php echo $r['TenTrungTam'];?></option>
			<?php
				}
				else
				{
			?>
					<option value="<?php echo $r['MaTrungTam'];?>"><?php echo $r['TenTrungTam'];?></option>
			<?php
				}
			?>
<?php
			}
		} 
	}
	catch (PDOException $e) {
		echo $e->getMessage();
	}
?>
				</select>
		</div>
		<div class="col-md-2" style="margin-bottom:5px">Thu ngân:</div>
		<div class="col-md-3" style="margin-bottom:5px">
			<select name="thungan">
				<option value="all">Tat ca</option>
<?php 
	$sql="SELECT * FROM tblDMNhanVien Where NhomNhanVien like 'LT'";
	try
	{
		$result_nv = sqlsrv_query($dbCon, $sql);
		if($result_nv != false)
		{
			foreach ($result_nv as $r)
			{
?>
			<?php if($thungan == $r['MaNV'])
				{
			 ?>
		 			<option value="<?php echo $r['MaNV'];?>" selected="selected"><?php echo $r['TenNV'];?></option>
			<?php
				}
				else
				{
			?>
					<option value="<?php echo $r['MaNV'];?>"><?php echo $r['TenNV'];?></option>
			<?php
				}
			?>
<?php
			}
		} 
	}
	catch (PDOException $e) {
		echo $e->getMessage();
	}
?>
				</select>
		</div>
		<div class="col-md-2" style="margin-bottom:5px"></div>
	 </div>
    <div class="row">
          <div class="col-md-2" style="margin-bottom:5px">Từ ngày:</div>
            <div class="col-md-3" style="margin-bottom:5px"><input name="tungay" type="text"  value="<?php echo @$tungay ?>" id="tungay" /></div>
            <div class="col-md-2" style="margin-bottom:5px">Từ giờ: </div>
            <div class="col-md-3" style="margin-bottom:5px"><input name="tugio" type="time"  value="<?php echo @$tugio ?>" id="tugio" /></div>
            <div class="col-md-2" style="margin-bottom:5px"></div>
	</div>
	<div class="row">
          <div class="col-md-2" style="margin-bottom:5px">Đến ngày:</div>
            <div class="col-md-3" style="margin-bottom:5px"><input name="denngay" type="text"  value="<?php echo @$denngay ?>" id="denngay" /></div>
            <div class="col-md-2" style="margin-bottom:5px">Đến giờ: </div>
            <div class="col-md-3" style="margin-bottom:5px"><input name="dengio" type="time"  value="<?php echo @$dengio ?>" id="dengio" /></div>
            <div class="col-md-2" style="margin-bottom:5px"><input type="submit" value="Lọc"></div>
	</div>
     </form>
<?php 
	// convert to japan date format to filter data
	$tungay_converted = "";
	$denngay_converted = "";
	if($tungay != "")
	{
		 $tungay_converted = substr($tungay,6) . "/" . substr($tungay,3,2) . "/" . substr($tungay,0,2);
	}
	
	if($denngay != "")
	{
		$denngay_converted = substr($denngay,6) . "/" . substr($denngay,3,2) . "/" . substr($denngay,0,2);
	}
	
	$sql="SELECT SUM(CASE WHEN 1=1 THEN 1 ELSE 0 END) as TongSoHoaDon, ISNULL(SUM(TongTien),0) as TongTien, ISNULL(SUM(TienThucTra),0) as TienThucTra, ISNULL(SUM(TienDichVu),0) as TienDichVu, ISNULL(SUM(TienGio),0) as TienKhachTip, ISNULL(SUM(TienGiamGia),0) as TienGiamGia,
	SUM(CASE WHEN MaKhu LIKE '%LT3%' THEN 1 ELSE 0 END) as SoHoaDonThuong, SUM(CASE WHEN MaKhu LIKE '%LT3%' THEN TienThucTra ELSE 0 END) as TienThucTraThuong, SUM(CASE WHEN MaKhu LIKE '%LT3%' THEN TienDichVu ELSE 0 END) as TienDichVuThuong, SUM(CASE WHEN MaKhu LIKE '%LT3%' THEN TienGio ELSE 0 END) as TienKhachTipThuong, SUM(CASE WHEN MaKhu LIKE '%LT3%' THEN TienGiamGia ELSE 0 END) as TienGiamGiaThuong, 
	SUM(CASE WHEN MaKhu LIKE '%LT2%' THEN 1 ELSE 0 END) as SoHoaDonVIP, SUM(CASE WHEN MaKhu LIKE '%LT2%' THEN TienThucTra ELSE 0 END) as TienThucTraVIP, SUM(CASE WHEN MaKhu LIKE '%LT2%' THEN TienDichVu ELSE 0 END) as TienDichVuVIP, SUM(CASE WHEN MaKhu LIKE '%LT2%' THEN TienGio ELSE 0 END) as TienKhachTipVIP, SUM(CASE WHEN MaKhu LIKE '%LT2%' THEN TienGiamGia ELSE 0 END) as TienGiamGiaVIP, 
	SUM(CASE WHEN MaKhu LIKE '%LT4%' THEN 1 ELSE 0 END) as SoHoaDonSupperVIP, SUM(CASE WHEN MaKhu LIKE '%LT4%' THEN TienThucTra ELSE 0 END) as TienThucTraSupperVIP, SUM(CASE WHEN MaKhu LIKE '%LT4%' THEN TienDichVu ELSE 0 END) as TienDichVuSupperVIP, SUM(CASE WHEN MaKhu LIKE '%LT4%' THEN TienGio ELSE 0 END) as TienKhachTipSupperVIP, SUM(CASE WHEN MaKhu LIKE '%LT4%' THEN TienGiamGia ELSE 0 END) as TienGiamGiaSupperVIP,
	SUM(CASE WHEN MaKhu LIKE '%LT1%' THEN 1 ELSE 0 END) as SoHoaDonFoot, SUM(CASE WHEN MaKhu LIKE '%LT1%' THEN TienThucTra ELSE 0 END) as TienThucTraFoot, SUM(CASE WHEN MaKhu LIKE '%LT1%' THEN TienDichVu ELSE 0 END) as TienDichVuFoot, SUM(CASE WHEN MaKhu LIKE '%LT1%' THEN TienGio ELSE 0 END) as TienKhachTipFoot, SUM(CASE WHEN MaKhu LIKE '%LT1%' THEN TienGiamGia ELSE 0 END) as TienGiamGiaFoot, 
	SUM(CASE WHEN MaKhu LIKE '%HT%' THEN 1 ELSE 0 END) as SoHoaDonHotel, SUM(CASE WHEN MaKhu LIKE '%HT%' THEN TienThucTra ELSE 0 END) as TienThucTraHotel, SUM(CASE WHEN MaKhu LIKE '%HT%' THEN TienDichVu ELSE 0 END) as TienDichVuHotel, SUM(CASE WHEN MaKhu LIKE '%HT%' THEN TienGio ELSE 0 END) as TienKhachTipHotel, SUM(CASE WHEN MaKhu LIKE '%HT%' THEN TienGiamGia ELSE 0 END) as TienGiamGiaHotel 
		FROM [SENVANG].[dbo].[tblLichSuPhieu]  where PhieuHuy = 0 and DaTinhTien = 1 and ThoiGianDongPhieu is not null 
		and TienThucTra >0 ";
	//
	//----loc theo gio-----//
	//
	if($tugio != "")
	{
		$sql = $sql . "	and Substring(Convert(varchar,isnull(ThoiGianDongPhieu,getdate()),8),1,5) >= '$tugio'";
	}
	if($dengio != "")
	{
		$sql = $sql . " and Substring(Convert(varchar,isnull(ThoiGianDongPhieu,getdate()),8),1,5) <= '$dengio'";
	}
	
	//----loc theo ngay-----//
	if($tungay_converted != "")
	{
		$sql = $sql . "	and Convert(varchar,isnull(ThoiGianDongPhieu,getdate()),111) >= '$tungay_converted'";
	}
	if($denngay_converted != "")
	{
		$sql = $sql . " and Convert(varchar,isnull(ThoiGianDongPhieu,getdate()),111) <= '$denngay_converted'";
	}
	//----loc theo trung tam -----//
	if($chinhanh != "" && $chinhanh	!= "all")
		$sql = $sql . " and Left(MaLichSuPhieu,2) = '$chinhanh'";
	//
	//----loc theo thu ngân ------//
	//
	if($thungan != "" && $thungan != "all")
		$sql = $sql . " and NVTinhTienMaNV like '$thungan'";
	
	$tongsohoadon = 0; $tiendichvu = 0; $tiengiamgia = 0; $tienthuctra = 0; $tienkhachtip = 0;
	$sohoadon_th =0; $tiendichvu_th = 0; $tiengiamgia_th =0; $tienthuctra_th = 0; $tienkhachtip_th = 0;
	$sohoadon_vip =0; $tiendichvu_vip = 0; $tiengiamgia_vip =0; $tienthuctra_vip = 0; $tienkhachtip_vip = 0;
	$sohoadon_svip =0; $tiendichvu_svip = 0; $tiengiamgia_svip =0; $tienthuctra_svip = 0; $tienkhachtip_svip = 0;
	$sohoadon_foot=0; $tiendichvu_foot = 0; $tiengiamgia_foot =0; $tienthuctra_foot = 0; $tienkhachtip_foot = 0;
	$sohoadon_hotel=0; $tiendichvu_hotel = 0; $tiengiamgia_hotel =0; $tienthuctra_hotel = 0; $tienkhachtip_hotel = 0;
	try
	{
		$result_dt = sqlsrv_query($dbCon, $sql);
		if($result_dt != false)
		{	
			$r1 = sqlsrv_fetch_array($result_dt);
			//foreach ($result_dt as $r1)
			//{
				$tongsohoadon = $r1['TongSoHoaDon'];
				$tiendichvu = $r1['TienDichVu'];
				$tiengiamgia = $r1['TienGiamGia'];
				$tienthuctra = $r1['TienThucTra'];
				$tienkhachtip = $r1['TienKhachTip'];

				$sohoadon_th = $r1['SoHoaDonThuong'];
				$tiendichvu_th = $r1['TienDichVuThuong'];
				$tiengiamgia_th = $r1['TienGiamGiaThuong'];
				$tienthuctra_th = $r1['TienThucTraThuong'];
				$tienkhachtip_th = $r1['TienKhachTipThuong'];

				$sohoadon_vip = $r1['SoHoaDonVIP'];
				$tiendichvu_vip = $r1['TienDichVuVIP'];
				$tiengiamgia_vip = $r1['TienGiamGiaVIP'];
				$tienthuctra_vip = $r1['TienThucTraVIP'];
				$tienkhachtip_vip = $r1['TienKhachTipVIP'];

				$sohoadon_svip = $r1['SoHoaDonSupperVIP'];
				$tiendichvu_svip = $r1['TienDichVuSupperVIP'];
				$tiengiamgia_svip = $r1['TienGiamGiaSupperVIP'];
				$tienthuctra_svip = $r1['TienThucTraSupperVIP'];
				$tienkhachtip_svip = $r1['TienKhachTipSupperVIP'];

				$sohoadon_foot = $r1['SoHoaDonFoot'];
				$tiendichvu_foot = $r1['TienDichVuFoot'];
				$tiengiamgia_foot = $r1['TienGiamGiaFoot'];
				$tienthuctra_foot = $r1['TienThucTraFoot'];
				$tienkhachtip_foot = $r1['TienKhachTipFoot'];

				$sohoadon_hotel = $r1['SoHoaDonHotel'];
				$tiendichvu_hotel = $r1['TienDichVuHotel'];
				$tiengiamgia_hotel = $r1['TienGiamGiaHotel'];
				$tienthuctra_hotel = $r1['TienThucTraHotel'];
				$tienkhachtip_hotel = $r1['TienKhachTipHotel'];
			//}
		} 
	}
	catch (PDOException $e) {
		echo $e->getMessage();
	}
	
?>
	 <h3 class="title">DOANH THU TỔNG HỢP</h3>
     <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
				<div class="panel-body no-padding">
					<table class="table table-striped doanhthu">
						<thead>
							<tr class="warning">
								<th>Khu</th>
								<th>Số hóa đơn</th>
								<th>Doanh thu thực (VNĐ)</th>
								<th>Tiển dịch vụ (VNĐ)</th>
								<th>Giảm giá (VNĐ)</th>								
								<th>Khách tip (VNĐ)</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Tổng cộng</td>
								<td><?php echo number_format($tongsohoadon,0);?></td>
								<td><?php echo number_format($tiendichvu - $tiengiamgia,0);?></td>
								<td><?php echo number_format($tiendichvu,0);?></td>
								<td><?php echo number_format($tiengiamgia,0);?></td>
								<td><?php echo number_format($tienkhachtip,0);?></td>
							</tr>
							<tr>
								<td>THƯỜNG</td>
								<td><?php echo number_format($sohoadon_th,0);?></td>
								<td><?php echo number_format($tiendichvu_th - $tiengiamgia_th,0);?></td>
								<td><?php echo number_format($tiendichvu_th,0);?></td>
								<td><?php echo number_format($tiengiamgia_th,0);?></td>
								<td><?php echo number_format($tienkhachtip_th,0);?></td>
							</tr>
							<tr>
								<td>VIP</td>
								<td><?php echo number_format($sohoadon_vip,0);?></td>
								<td><?php echo number_format($tiendichvu_vip - $tiengiamgia_vip,0);?></td>
								<td><?php echo number_format($tiendichvu_vip,0);?></td>
								<td><?php echo number_format($tiengiamgia_vip,0);?></td>
								<td><?php echo number_format($tienkhachtip_vip,0);?></td>
							</tr>
							<tr>
								<td>SUPPER VIP</td>
								<td><?php echo number_format($sohoadon_svip,0);?></td>
								<td><?php echo number_format($tiendichvu_svip - $tiengiamgia_svip,0);?></td>
								<td><?php echo number_format($tiendichvu_svip,0);?></td>
								<td><?php echo number_format($tiengiamgia_svip,0);?></td>
								<td><?php echo number_format($tienkhachtip_svip,0);?></td>
							</tr>
							<tr>
								<td>FOOT</td>
								<td><?php echo number_format($sohoadon_foot,0);?></td>
								<td><?php echo number_format($tiendichvu_foot - $tiengiamgia_foot,0);?></td>
								<td><?php echo number_format($tiendichvu_foot,0);?></td>
								<td><?php echo number_format($tiengiamgia_foot,0);?></td>
								<td><?php echo number_format($tienkhachtip_foot,0);?></td>
							</tr>
							<tr>
								<td>HOTEL</td>
								<td><?php echo number_format($sohoadon_hotel,0);?></td>
								<td><?php echo number_format($tiendichvu_hotel - $tiengiamgia_hotel,0);?></td>
								<td><?php echo number_format($tiendichvu_hotel,0);?></td>
								<td><?php echo number_format($tiengiamgia_hotel,0);?></td>
								<td><?php echo number_format($tiengiamgia_hotel,0);?></td>
							</tr>
						</tbody>
					</table>
				</div>
	</div>
     <h3 class="title">CHI TIẾT PHIẾU</h3>
  	<div class="bs-example4" data-example-id="contextual-table">
    <table class="table">
      <thead>
        <tr>
          <th>Khu</th>
          <th>Mã Bill</th>
		  <th>Thời gian</th>
          <th>Thu ngân</th>
		  <th>Tổng tiền (VNĐ)</th>
          <th>Giảm giá</th>
          <th>Khách TIP</th>
          <th>Thực trả(VNĐ)</th>
		  <th>Phiếu Hủy</th>
          <th>Ghi chú</th>
        </tr>
      </thead>
      <tbody>
<?php 		
	$sql2="select b.MoTa as TenKhu, TenKhachHang, MaTheVip, MaLichSuPhieu, GioVao, isnull(GioTra,ThoiGianDongPhieu) as GioTra, NVTinhTienMaNV, MaBan, TongTien,TienGiamGia,TienGio, TienThucTra,PhieuHuy, GhiChu from [SENVANG].[dbo].[tblLichSuPhieu] a, [SENVANG].[dbo].[tblDMKhu] b where DaTinhTien = 1 and ThoiGianDongPhieu is not null and a.MaKhu = b.MaKhu and TienThucTra > 0";
	//----loc theo gio-----//
	if($tugio != "")
	{
		$sql2 = $sql2 . "	and Substring(Convert(varchar,isnull(ThoiGianDongPhieu,getdate()),8),1,5) >= '$tugio'";
	}
	if($dengio != "")
	{
		$sql2 = $sql2 . " and Substring(Convert(varchar,isnull(ThoiGianDongPhieu,getdate()),8),1,5) <= '$dengio'";
	}
	//----loc theo ngay ----//
	if($tungay_converted != "")
	{
		$sql2 = $sql2 . " and Convert(varchar,isnull(ThoiGianDongPhieu,getdate()),111) >= '$tungay_converted'";
	}
	if($denngay_converted != "")
	{
		$sql2 = $sql2 . " and Convert(varchar,isnull(ThoiGianDongPhieu,getdate()),111) <= '$denngay_converted'";
	}
	
	//----loc theo chi nanh -----//
	if($chinhanh != "" && $chinhanh != "all")
		$sql2 = $sql2 . " and Left(MaLichSuPhieu,2) = '$chinhanh'";
	//
	//-----loc theo thu ngan -----//
	if($thungan != "" && $thungan != "all")
		$sql2 = $sql2 . " and NVTinhTienMaNV like '$thungan'";
	
	$sql2 = $sql2 . " Order by MaLichSuPhieu, b.MoTa";
		try
	{
		//lay ket qua query chi tiet nap tien vao the
		$result_hd = sqlsrv_query($dbCon, $sql2);
		if($result_hd != false)
		{
			//show the results
			while ( $r2 = sqlsrv_fetch_array($result_hd) )
			{
?>  
		  <tr class="success">
			<td><?php echo $r2['TenKhu'];?></td>
			<td><?php echo $r2['MaLichSuPhieu'];?></td>
			<td><?php echo $r2['GioVao']->format('H:i');?>
          	<td><?php echo $r2['NVTinhTienMaNV'];?></td> 
          	<td><?php echo number_format($r2['TongTien'],0);?></td>
          	<td><?php echo number_format($r2['TienGiamGia'],0);?></td>
          	<td><?php echo number_format($r2['TienGio'],0);?></td>
          	<td><?php echo number_format($r2['TienThucTra'],0);?></td>
          	<!-- <td><?php //echo $r2['MaTheVip'];?></td>-->
		  	<td><?php echo $r2['PhieuHuy'];?></td> 
          	<td><?php echo $r2['GhiChu'];?></td>
        </tr>
<?php 		}
		}
	}
	catch (PDOException $e1) {

		//loi ket noi db -> show exception
		echo $e1->getMessage();
	}  ?>
      </tbody>
    </table>
   </div>
	<h3 class="title">CHI TIẾT DỊCH VỤ</h3>
  	<div class="bs-example4" data-example-id="contextual-table">
    <table class="table">
      <thead>
        <tr>
          <th>Tên dịch vụ</th>
		  <th>Số lượng</th>
          <th>Thành Tiền</th>
        </tr>
      </thead>
      <tbody>
<?php 		
	$sql3="select TenHangBan, SUM(SoLuong) as SoLuong, SUM(ThanhTien) as ThanhTien from tblLSPhieu_HangBan 
		where ThanhTien > 0 and MaLichSuPhieu in (Select MaLichSuPhieu from tblLichSuPhieu where DaTinhTien = 1 and ThoiGianDongPhieu is not null "; 
	//----loc theo gio-----//
	if($tugio != "")
	{
		$sql3 = $sql3 . "	and Substring(Convert(varchar,isnull(ThoiGianDongPhieu,getdate()),8),1,5) >= '$tugio'";
	}
	if($dengio != "")
	{
		$sql3 = $sql3 . " and Substring(Convert(varchar,isnull(ThoiGianDongPhieu,getdate()),8),1,5) <= '$dengio'";
	}
	
	if($tungay_converted != "")
	{
		$sql3 = $sql3 . " and Convert(varchar,isnull(ThoiGianDongPhieu,getdate()),111) >= '$tungay_converted'";
	}
	if($denngay_converted != "")
	{
		$sql3 = $sql3 . " and Convert(varchar,isnull(ThoiGianDongPhieu,getdate()),111) <= '$denngay_converted'";
	}
	//----loc theo chi nhanh -----//
	if($chinhanh != "" && $chinhanh != "all")
		$sql3 = $sql3 . " and Left(MaLichSuPhieu,2) = '$chinhanh'";
	//
	//----loc theo thu ngan ------//
	if($thungan != "" && $thungan != "all")
		$sql3 = $sql3 . " and NVTinhTienMaNV like '$thungan'";
		
	$sql3 = $sql3 . ")"; // close sub query
	
	$sql3 = $sql3 . " group by TenHangBan order by SoLuong desc";
	
	try
	{
		//lay ket qua query chi tiet dv
		$result_dv = sqlsrv_query($dbCon, $sql3);
		
		if($result_dv != false)
		{
			//show the results
			while ( $r3 = sqlsrv_fetch_array($result_dv) )
			{
	?>      
        <tr class="success">
			<td><?php echo $r3['TenHangBan'];?></td>
          <td><?php echo number_format($r3['SoLuong'],0);?></td>
          <td><?php echo number_format($r3['ThanhTien'],0);?></td>
        </tr>
<?php 
			}
		}
	}
	catch (PDOException $e3) {

		//loi ket noi db -> show exception
		echo $e3->getMessage();
	} 
?>
      </tbody>
    </table>
   </div>
  </div>
 
   </div>
      </div>
      <!-- /#page-wrapper -->
   </div>
    <!-- /#wrapper -->
<!-- Nav CSS -->
<link href="css/custom.css" rel="stylesheet">
<!-- Metis Menu Plugin JavaScript -->
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>
<script type="text/javascript" src="js/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<link href="js/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet" />
<script>
	$('#tungay').datepicker({
		dateFormat:'dd-mm-yy',
		changeMonth:true,
		changeYear:true,
		yearRange:'-99:+0',
	})
	 
	$('#denngay').datepicker({
		dateFormat:'dd-mm-yy',
		changeMonth:true,
		changeYear:true,
		yearRange:'-99:+0',
	})
</script>
</body>
</html>
