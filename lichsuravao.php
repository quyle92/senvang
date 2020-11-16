
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
//
// convert to japan date format to filter data
//
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
<meta name="keywords" content="Phần mềm quản lý nhân sự ZinHR" />
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
		<div class="col-md-2" style="margin-bottom:5px">Nhân viên:</div>
		<div class="col-md-3" style="margin-bottom:5px">
			<select name="nhanvien"><option value="all">Tat ca</option>
<?php
	$tongsonhanvien = 0;
	$sqlnv = "Select MaNV,TenNV from tblDMNhanVien where DaNghiViec = 0 and TenNV not like 'admin'";
	try
	{
		$result_nv = sqlsrv_query($dbCon, $sqlnv);
		if($result_nv != false)
		{
			//foreach ($result_nv as $rnv)
			while($rnv = sqlsrv_fetch_array($result_nv) )
			{
				$tongsonhanvien = $tongsonhanvien + 1;
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
		echo $e1->getMessage();
	}
?>
			</select>
		</div>
		<div class="col-md-2" style="margin-bottom:5px">
		</div>
	 </div>
     <div class="row">
          <div class="col-md-2" style="margin-bottom:5px">Từ ngày:</div>
          <div class="col-md-3" style="margin-bottom:5px"><input name="tungay" type="text"  value="<?php echo @$tungay ?>" id="tungay" /></div>
          <div class="col-md-2" style="margin-bottom:5px">Đến ngày: </div>
          <div class="col-md-3" style="margin-bottom:5px"><input name="denngay" type="text"  value="<?php echo @$denngay ?>" id="denngay" /></div>
		  <div class="col-md-2"></div>
	</div>
	<div class="row">
		 <div class="col-md-2" style="margin-bottom:5px"></div>
		 <div class="col-md-3" style="margin-bottom:5px">
		 	<input type="submit" value="Lọc" style="padding-top: 10px; padding-left:10px;padding-right:10px">
		 </div>
		 <div class="col-md-2" style="margin-bottom:5px"></div>
		 <div class="col-md-3" style="margin-bottom:5px"></div>
		 <div class="col-md-2"></div>
	</div>
     </form>
<?php
	$countSoChamCong = 0;
	$sqltip="SELECT a.MaThe, a.GioVao, 
case when DATEDIFF(minute,ISNULL(a.GioVao,getdate()),ISNULL(a.GioRa,getdate())) = 0 then null else a.GioRa end as GioRa, a.MaNhanVien, b.TenNV, DATEDIFF(minute,ISNULL(a.GioVao,getdate()),ISNULL(a.GioRa,getdate())) as SoPhut FROM [SENVANG].[dbo].[tblHR_QuetTheChamCong] a, [SENVANG].[dbo].[tblDMNhanVien] b WHERE a.MaNhanVien = b.MaNV";
	//
	//----loc theo ngay ----//
	if($tungay_converted != "")
	{
		$sqltip = $sqltip . " and Convert(varchar,isnull(GioVao,getdate()),111) >= '$tungay_converted'";
	}
	if($denngay_converted != "")
	{
		$sqltip = $sqltip . " and Convert(varchar,isnull(GioVao,getdate()),111) <= '$denngay_converted'";
	}
	
	if($kythuatvien != "" && $kythuatvien != "all")
		$sqltip = $sqltip." and a.MaNhanVien like '$kythuatvien'";

	$sqltip = $sqltip." Group by a.MaThe, a.GioVao, a.GioRa, a.MaNhanVien, b.TenNV Order by a.GioVao, a.MaNhanVien";
	
	try
	{
		//$result_tip = $dbCon->query($sqltip);
		$result_tip = sqlsrv_query($dbCon, $sqltip);
		if($result_tip != false)
		{
			//foreach ($result_tip as $rtip)
			while ( sqlsrv_fetch_array($result_tip) )
			{
				$countSoChamCong = $countSoChamCong + 1;
			}
		}
	}
	catch (PDOException $e2) {

		echo $e2->getMessage();
	}
	
	//echo $sqltip;
?>
	<h3 class="title">TỔNG LƯỢT CHẤM CÔNG: <?php echo number_format($countSoChamCong,0); ?></h3>
  	<div class="bs-example4" data-example-id="contextual-table">
    <table class="table">
      <thead>
        <tr>
          <th>Mã NV</th>
          <th>Tên NV</th>
          <th>Vân tay</th>
		  <th>Giờ vào</th>
          <th>Giờ ra</th>
		  <th>Số giờ</th>
		  <th>Ghi chú</th>
        </tr>
      </thead>
      <tbody>
<?php
	try
	{
		//$result_ct = $dbCon->query($sqltip);
		$result_ct = sqlsrv_query($dbCon, $sqltip);
		if($result_ct != false)
		{
			//foreach ($result_ct as $r2)
			while ( $r2 = sqlsrv_fetch_array($result_ct) )
			{
				$sogio = 0;
				$sogio = floatval($r2['SoPhut'])/60;
?>      
        <tr class="success">
		  <td><?php echo $r2['MaNhanVien'];?></td>
		  <td><?php echo $r2['TenNV'];?></td>
		  <td><?php echo $r2['MaThe'];?></td>
		  <td><?= ( $r2['GioVao'] ) ? $r2['GioVao']->format('H:i') : "";?></td>	
		  <td><?= ( $r2['GioRa'] ) ? $r2['GioRa']->format('H:i') : "";?></td>	
		  <td><?php echo round($sogio,2);?></td>
		  <td><?php //echo $r2['GhiChu'];?></td>
        </tr>
<?php 
    		}
		}
	}
	catch (PDOException $e3) {
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
