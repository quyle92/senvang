
<?php
require('lib/db.php');
@session_start();
$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];
$trungtam=$_SESSION['TenTrungTam'];
$tungay=@$_POST['tungay'];
$denngay=@$_POST['denngay'];
$chinhanh=@$_POST['chinhanh'];

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

$l_iTuNgay_Ngay = 1; $l_iTuNgay_Thang = 1; $l_iTuNgay_Nam = 2020;
$l_iDenNgay_Ngay = 28; $l_iDenNgay_Thang = 1; $l_iDenNgay_Nam = 2020;
//
// convert to japan date format to filter data
$tungay_converted = "";
$denngay_converted = "";
if($tungay != "")
{
	$tungay_converted = substr($tungay,6) . "/" . substr($tungay,3,2) . "/" . substr($tungay,0,2);
	$l_iTuNgay_Ngay = intval(substr($tungay,0,2));
	$l_iTuNgay_Thang = intval(substr($tungay,3,2));
	$l_iTuNgay_Nam = intval(substr($tungay,6));
}

if($denngay != "")
{
	$denngay_converted = substr($denngay,6) . "/" . substr($denngay,3,2) . "/" . substr($denngay,0,2);
	$l_iDenNgay_Ngay = intval(substr($denngay,0,2));
	$l_iDenNgay_Thang = intval(substr($denngay,3,2));
	$l_iDenNgay_Nam = intval(substr($denngay,6));
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
		<div class="col-md-2" style="margin-bottom:5px">Nhân viên:</div>
		<div class="col-md-3" style="margin-bottom:5px">
			<select name="nhanvien"><option value="all">Tat ca</option>
<?php
	$tongsonhanvien = 0;
	$sqlnv = "Select MaNV,TenNV from tblDMNhanVien where DaNghiViec = 0 and TenNV not like 'admin'";
	try
	{
		$result_nv = $dbCon->query($sqlnv);
		if($result_nv != false)
		{
			foreach ($result_nv as $rnv)
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
          <div class="col-md-2" style="margin-bottom:5px"></div>
          <div class="col-md-3" style="margin-bottom:5px"><input type="submit" value="Lọc" style="padding-top: 10px;padding-left:10px;padding-right:10px"></div>
          <div class="col-md-2" style="margin-bottom:5px"></div>
          <div class="col-md-3" style="margin-bottom:5px"></div>
		  <div class="col-md-2"></div>
	</div>
    </form>
<?php 
	$sql="SELECT a.MaNV, b.TenNV, a.Thang, a.Nam, Sum(CongNgay) as CongNgay, Sum(DiTreVeSom) as DiTreVeSom, Sum(TangCa) as TangCa FROM tblHR_ChamCong a, tblDMNhanVien b WHERE a.MaNV = b.MaNV";
	//
	//----loc theo ngay ----//
	if($tungay_converted != "")
	{
		$sql = $sql . " and Ngay >= '$l_iTuNgay_Ngay' and Thang = '$l_iTuNgay_Thang' and Nam = '$l_iTuNgay_Nam'";
	}
	if($denngay_converted != "")
	{
		$sql = $sql . " and Ngay <= '$l_iDenNgay_Ngay' and Thang = '$l_iDenNgay_Thang' and Nam = '$l_iDenNgay_Nam'";
	}
	$sql = $sql." Group by a.MaNV, b.TenNV, a.Thang, a.Nam";
?>
    <h3 class="title">TỔNG HỢP CHẤM CÔNG</h3>
  	<div class="bs-example4" data-example-id="contextual-table">
    <table class="table">
      <thead>
        <tr>
          <th>Tên NV</th>
		  <th>Công ngày</th>
          <th>Đi Trễ/Về sớm</th>
          <th>Tăng ca</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
<?php 		
	try
	{
		//echo $sql;
		$result_tour = sqlsrv_query($dbCon, $sql);
		if($result_tour != false)
		{
			foreach ($result_tour as $r2)
			{
?>      
        <tr class="success">
			<td><?php echo $r2['TenNV'];?></td>
            <td><?php echo number_format($r2['CongNgay'],0);?></td>
            <td><?php echo number_format($r2['DiTreVeSom'],0);?></td>
            <td><?php echo number_format($r2['TangCa'],0);?></td>
            <td></td>
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
