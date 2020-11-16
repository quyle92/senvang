
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
		  <div class="col-md-2"><input type="submit" value="Lọc" style="padding-left:10px;padding-right:10px"></div>
	</div>
     </form>
<?php 
	$sql="SELECT ISNULL(Sum(TongTien),0) as ThucNhan, ISNULL(SUM(a.TienChietKhau),0) as TienKhachTip 
		FROM tblPhieuThuChi a WHERE LoaiPhieu like 'CHH'";

		//----loc theo ngay ----//
	if($tungay_converted != "")
	{
		$sql = $sql . " and Convert(varchar,isnull(NgayLap,getdate()),111) >= '$tungay_converted'";
	}
	if($denngay_converted != "")
	{
		$sql = $sql . " and Convert(varchar,isnull(NgayLap,getdate()),111) <= '$denngay_converted'";
	}
	
	$tienthucnhan = 0; $tienkhachtip = 0;
		
	try
	{
		//lay ket qua query chi tiet nap tien vao the
		$result_tt = sqlsrv_query($dbCon, $sql);
		if($result_tt != false)
		{
			//show the results
			foreach ($result_tt as $r)
			{
				$tienthucnhan = $r['ThucNhan'];
				$tienkhachtip = $r['TienKhachTip'];
			}
		}
	}
	catch (PDOException $e1) {

		//loi ket noi db -> show exception
		echo $e1->getMessage();
	}
?>
<h3 class="title">TỔNG HỢP TIỀN TIP</h3>
     <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
				<div class="panel-body no-padding">
					<table class="table table-striped">
						<thead>
							<tr class="warning">
								<th></th>
								<th>Tiền khách tip (VNĐ)</th>
								<th></th>
								<th>Thực nhận (VNĐ)</th>								
							</tr>
						</thead>
						<tbody>
							<tr>
								<td></td>
								<td><?php echo number_format( $tienkhachtip,0); ?></td>
								<td></td>
								<td><?php echo number_format( $tienthucnhan,0); ?></td>
							</tr>
						</tbody>
					</table>
				</div>
	</div>
     <h3 class="title">TỔNG HỢP TIP THEO NHÂN VIÊN</h3>
  	<div class="bs-example4" data-example-id="contextual-table">
    <table class="table">
      <thead>
        <tr>
          <th>Mã NV</th>
          <th>Tên NV</th>
		  <th>Khách Tip (VNĐ)</th>
          <th>Thực nhận (VNĐ)</th>
        </tr>
      </thead>
      <tbody>
<?php 		
	$sql2="SELECT a.MaNV, b.TenNV, ISNULL(Sum(a.TienChietKhau),0) as TienKhachTip, ISNULL(SUM(a.TongTien),0) as TienThucNhan 
		FROM tblPhieuThuChi a left join tblDMNhanVien b On a.MaNV = b.MaNV Where LoaiPhieu like 'CHH' and b.TenNV <> '' and b.TenNV is not null";

		//----loc theo ngay ----//
	if($tungay_converted != "")
	{
		$sql2 = $sql2 . " and Convert(varchar,isnull(NgayLap,getdate()),111) >= '$tungay_converted'";
	}
	if($denngay_converted != "")
	{
		$sql2 = $sql2 . " and Convert(varchar,isnull(NgayLap,getdate()),111) <= '$denngay_converted'";
	}
	
	$sql2 = $sql2 . " group by a.MaNV, b.TenNV";
	
	try
	{
		//lay ket qua query chi tiet nap tien vao the
		$result_tour = $dbCon->query($sql2);
		if($result_tour != false)
		{
			//show the results
			foreach ($result_tour as $r2)
			{
?>      
        <tr class="success">
			<td><?php echo $r2['MaNV'];?></td>
			<td><?php echo $r2['TenNV'];?></td>
            <td><?php echo number_format($r2['TienKhachTip'],0);?></td>
            <td><?php echo number_format($r2['TienThucNhan'],0);?></td>
        </tr>
        <?php }
		}
	}
	catch (PDOException $e1) {

		//loi ket noi db -> show exception
		echo $e1->getMessage();
	} ?>
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
