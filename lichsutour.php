
<?php
require('lib/db.php');
@session_start();
$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];
$trungtam=$_SESSION['TenTrungTam'];

//lay gia tri post
$tungay=@$_POST['tungay'];
$denngay=@$_POST['denngay'];
$chinhanh=@$_POST['chinhanh'];

$kythuatvien = "";
$kythuatvien = @$_POST['nhanvien'];

//echo $kythuatvien;

$chinhanh=@$_POST['chinhanh'];

if($tungay == "")
{
	$tungay = date('d-m-Y');
}
if($denngay == "")
{
	$denngay = date('d-m-Y');
}

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

?>

<!DOCTYPE HTML>
<html>
<head>
<title>Giải pháp quản lý SPA toàn diện - ZinSPA</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Phần mềm quản lý nhà hàng ZinRes" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
 <!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style1.css" rel='stylesheet' type='text/css' />
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- jQuery -->

<!----webfonts--->
<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
<link href="images/favicon-zintech.png" rel='icon' type='image/x-icon' />	
<!---//webfonts--->  
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
</head>
<body>
<div id="wrapper">
     <?php include 'menu.php'; ?>
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
		//lay ket qua query tong gia tri the
		$result_tt = sqlsrv_query($dbCon, $sql);
		if($result_tt != false)
		{
			//show the results
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

		//loi ket noi db -> show exception
		echo $e->getMessage();
	}
?>
				</select>
		</div>
		<div class="col-md-2" style="margin-bottom:5px"><?php echo $chinhanh; ?></div>
		<div class="col-md-3" style="margin-bottom:5px"></div>
		<div class="col-md-2" style="margin-bottom:5px"></div>
	 </div>
     <div class="row">
          <div class="col-md-2" style="margin-bottom:5px">Từ ngày:</div>
          <div class="col-md-3" style="margin-bottom:5px"><input name="tungay" type="text"  value="<?php echo @$tungay ?>" id="tungay" /></div>
          <div class="col-md-2" style="margin-bottom:5px">Đến ngày: </div>
          <div class="col-md-3" style="margin-bottom:5px"><input name="denngay" type="text"  value="<?php echo @$denngay ?>" id="denngay" /></div>
		  <div class="col-md-2"></div>
	</div>
	<div class="row">
		 <div class="col-md-2" style="margin-bottom:5px">Nhân viên:</div>
		 <div class="col-md-3" style="margin-bottom:5px"><select name="nhanvien"><option value="all">Tat ca</option>
<?php
	$sqlnv = "Select MaNV,TenNV from tblDMNhanVien where DaNghiViec = 0 and NhomNhanVien in (Select Ma from tblDMNhomNhanVien where IsDieuTour = 1)";
	
	try
	{
		//lay ket qua query chi tiet nap tien vao the
		$result_nv = $dbCon->query($sqlnv);
		if($result_nv != false)
		{
			//show the results
			foreach ($result_nv as $rnv)
			{
				if($kythuatvien == $rnv['MaNV'])
				{
			 ?>
		 			<option value="<?php echo $rnv['MaNV'];?>" selected="selected"><?php echo $rnv['TenNV'];?></option>
			<?php
				}
				else
				{
			?>
					<option value="<?php echo $rnv['MaNV'];?>"><?php echo $rnv['TenNV'];?></option>
			<?php
				}
			}
		}
	}
	catch (PDOException $e1) {

		//loi ket noi db -> show exception
		echo $e1->getMessage();
	}
?>
		 </div>
		 <div class="col-md-2" style="margin-bottom:5px"><input type="submit" value="Lọc" style="padding-left:10px;padding-right:10px"></div>
		 <div class="col-md-3" style="margin-bottom:5px"></div>
		 <div class="col-md-2"></div>
	</div>
     </form>
<?php
	$sqltip="SELECT ISNULL(SUM(TienChietKhau),0) as TienKhachTip, ISNULL(SUM(TongTien),0) as TienThucNhan FROM tblPhieuThuChi WHERE LoaiPhieu like 'CHH'";
	//----loc theo ngay ----//
	if($tungay_converted != "")
	{
		$sqltip = $sqltip . " and Convert(varchar,isnull(NgayLap,getdate()),111) >= '$tungay_converted'";
	}
	if($denngay_converted != "")
	{
		$sqltip = $sqltip . " and Convert(varchar,isnull(NgayLap,getdate()),111) <= '$denngay_converted'";
	}
	
	if($kythuatvien != "" && $kythuatvien != "all")
		$sqltip = $sqltip." and MaNV like '$kythuatvien'";

	$sqltip = $sqltip." Group by MaNV";

	$tongthucnhan = 0;
	try
	{
		//lay ket qua query chi tiet nap tien vao the
		$result_tip = $dbCon->query($sqltip);
		if($result_tip != false)
		{
			//show the results
			foreach ($result_tip as $rtip)
			{
				$tongthucnhan = $rtip['TienThucNhan'];
			}
		}
	}
	catch (PDOException $e2) {

		//loi ket noi db -> show exception
		echo $e2->getMessage();
	}
?>
	 <h3 class="title">TỔNG TIỀN NHẬN: <?php echo number_format($tongthucnhan,0); ?> VNĐ</h3>
     <h3 class="title">CHI TIẾT TIP</h3>
  	<div class="bs-example4" data-example-id="contextual-table">
    <table class="table">
      <thead>
        <tr>
          <th>Mã NV</th>
          <th>Tên NV</th>
		  <th>Nội dung</th>
          <th>Khách Tip (VNĐ)</th>
		  <th>Thực nhận (VNĐ)</th>
		  <th>Mã Bill</th>
          <th>Thời gian</th>
        </tr>
      </thead>
      <tbody>
<?php 		
	$sql2="select a.MaNV, b.TenNV, a.LyDo, a.MaLichSuPhieu, a.TienChietKhau, a.TongTien, a.NgayLap
                 from tblPhieuThuChi a left join tblDMNhanVien b on a.MaNV = b.MaNV 
                 where LoaiPhieu like 'CHH'";
				 
	//----loc theo ngay ----//
	if($tungay_converted != "")
	{
		$sql2 = $sql2 . " and Convert(varchar,isnull(NgayLap,getdate()),111) >= '$tungay_converted'";
	}
	if($denngay_converted != "")
	{
		$sql2 = $sql2 . " and Convert(varchar,isnull(NgayLap,getdate()),111) <= '$denngay_converted'";
	}
	
	if($kythuatvien != "" && $kythuatvien != "all")
		$sql2 = $sql2." and a.MaNV like '$kythuatvien'";
	
	//----loc theo quay -----//
	//if($maquay != "")
	//	$sql2 = $sql2 . " and MaKhu in (Select MaKhu from tblDMKhu where MaQuay like '$maquay')";
	$sql2 = $sql2 . " Order by a.MaLichSuPhieu";
	
	try
	{
		//lay ket qua query chi tiet nap tien vao the
		$result_ct = $dbCon->query($sql2);
		if($result_ct != false)
		{
			//show the results
			foreach ($result_ct as $r2)
			{
?>      
        <tr class="success">
		  <td><?php echo $r2['MaNV'];?></td>
		  <td><?php echo $r2['TenNV'];?></td>
		  <td><?php echo $r2['LyDo'];?></td>
		  <td><?php echo number_format($r2['TienChietKhau'],0);?></td>
		  <td><?php echo number_format($r2['TongTien'],0);?></td>
		  <td><?php echo $r2['MaLichSuPhieu'];?></td>
		  <td><?php echo date_format($r2['NgayLap'],'d-m-Y H:i:s');?></td>				
        </tr>
        <?php }
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
