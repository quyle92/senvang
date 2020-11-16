<?php
require('lib/db.php');
@session_start();


$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];
$trungtam=$_SESSION['TenTrungTam'];
$tungay=@$_POST['tungay'];
$denngay=@$_POST['denngay'];
$tugio = @$_POST['tugio'];
$dengio = @$_POST['dengio'];
if ($tugio == '' || $tugio == null) $tugio = "00:01";
if ($dengio == '' || $dengio == null) $dengio = "23:00";

$chinhanh=@$_POST['chinhanh'];

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
		<div class="col-md-2" style="margin-bottom:5px"></div>
		<div class="col-md-3" style="margin-bottom:5px"></div>
		<div class="col-md-2" style="margin-bottom:5px"></div>
	</div>
	<div class="row">
		<div class="col-md-2" style="margin-bottom:5px"></div>
		<div class="col-md-3" style="margin-bottom:5px"><input type="submit" value="Lọc" style="padding-top: 10px;padding-left:10px;padding-right:10px"></div>
		<div class="col-md-2" style="margin-bottom:5px"></div>
		<div class="col-md-3" style="margin-bottom:5px"></div>
		<div class="col-md-2" style="margin-bottom:5px"></div>
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
	
	$sql="SELECT a.*, b.Ten as TenNhomNV, c.TenChucVu, d.MoTa as TenCaLamViec FROM tblDMNhanVien a LEFT JOIN tblDMNhomNhanVien b ON a.NhomNhanVien = b.Ma LEFT JOIN  tblDMChucVu c ON a.MaChucVu = c.MaChucVu LEFT JOIN tblHR_CaLamViec d ON a.MaCaLamViec = d.MaCa where a.DaNghiViec = 0";
	//
	//----loc theo trung tam -----//
	//
	if($chinhanh != "" && $chinhanh	!= "all")
		$sql = $sql . " and a.MaTrungTam like '$chinhanh'";
	
	$tongnhanvien = 0; 

	try
	{
		$result_nv = sqlsrv_query($dbCon, $sql);
		if($result_nv != false)
		{
			foreach ($result_nv as $r)
			{
				$tongnhanvien = $tongnhanvien + 1;
			}
		}
	}
	catch (PDOException $e) {
		echo $e->getMessage();
	}
	
?>
    <h3 class="title">TỔNG SỐ NHÂN VIÊN : <?php echo $tongnhanvien; ?></h3>
  	<div class="bs-example4" data-example-id="contextual-table">
    <table class="table">
      <thead>
        <tr>
          <th>Mã</th>
		  <th>Họ Tên</th>
		  <th>Nhóm</th>
          <th>Vân tay</th>
		  <th>Lương CB</th>
		  <th>Chức vụ</th>
          <th>Ca Làm Việc</th>
        </tr>
      </thead>
      <tbody>
<?php
	try
	{
		$result_dsnv = sqlsrv_query($dbCon, $sql);
		if($result_dsnv != false)
		{
			foreach ($result_dsnv as $r2)
			{
?>
		<tr class="success">
			<td><?php echo $r2['MaNV'];?></td>
          	<td><?php echo $r2['TenNV'];?></td>
          	<td><?php echo $r2['TenNhomNV'];?></td>
          	<td><?php echo $r2['MaVanTay'];?></td>
          	<td><?php echo number_format($r2['LuongCB'],0);?></td>
		  	<td><?php echo $r2['TenChucVu'];?></td>
		  	<td><?php echo $r2['TenCaLamViec'];?></td>
        </tr>
<?php 		
			}
		}
	}
	catch (PDOException $e1) {
		echo $e1->getMessage();
	}
?>
      </tbody>
    </table>
   	</div>
  	<!--   END #bs-example4 -->
  	</div>
 	<!--   END #xs -->
   	</div>
    <!-- END #col-md-12 -->
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
