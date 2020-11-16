
<?php
require('lib/db.php');
@session_start();
$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];
$trungtam=$_SESSION['TenTrungTam'];
$tungay=@$_POST['tungay'];
$denngay=@$_POST['denngay'];

//echo $kythuatvien;

$chinhanh=@$_POST['chinhanh'];
$loaidichvu=@$_POST['loaidichvu'];

if($tungay == "")
{
	$tungay = date('d-m-Y');
}
if($denngay == "")
{
	$denngay = date('d-m-Y');
}

// convert to japan date format to filter data yyyy/MM/dd
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
		<div class="col-md-2" style="margin-bottom:5px">Loại thẻ:</div>
		<div class="col-md-3" style="margin-bottom:5px">
			<select name="loaidichvu">
				<option value="all" <?php if($loaidichvu == "" || $loaidichvu == "all") {?>selected="selected" <?php } ?>>Tat ca</option>
				<option value="spa" <?php if($loaidichvu == "spa") {?>selected="selected"<?php } ?>>SPA</option>
				<option value="gym" <?php if($loaidichvu == "gym") {?>selected="selected"<?php } ?>>GYM</option>
				<option value="yoga" <?php if($loaidichvu == "yoga") {?>selected="selected"<?php } ?>>YOGA</option>
				<option value="swim" <?php if($loaidichvu == "swim") {?>selected="selected"<?php } ?>>BƠI</option>
			</select>
		</div>
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
	$sql="SELECT SUM(CASE WHEN a.NgungThe = 0 THEN 1 ELSE 0 END) as TongTheDangSuDung, SUM(CASE WHEN a.NgungThe = 0 THEN 1 ELSE 0 END) as TongTheTamNgung, SUM(CASE WHEN a.NgungThe = 0 and convert(varchar,NgayApDung,111) < '$tungay_converted' THEN 1 ELSE 0 END) as TongTheKhachCu, SUM(CASE WHEN a.NgungThe = 0 and convert(varchar,NgayApDung,111) >= '$tungay_converted' and convert(varchar,NgayApDung,111) <= '$denngay_converted' THEN 1 ELSE 0 END) as TongTheKhachMoi, SUM(CASE WHEN a.NgungThe = 1 and convert(varchar,NgayApDung,111) >= '$tungay_converted' and convert(varchar,NgayApDung,111) <= '$denngay_converted' THEN 1 ELSE 0 END) as TongTheKhachNgung FROM tblKhachHang_TheVip a, tblDMKHNCC b WHERE a.MaKhachHang = b.MaDoiTuong";
	//
	//----loc theo ngay ----//
	if($loaidichvu != "" && $loaidichvu != "all")
	{
		if($loaidichvu == "spa")
			$sql = $sql . " and a.LoaiTheVip not like 'GM%' and a.LoaiTheVip not like 'YG%' and a.LoaiTheVip not like 'B%'";
		else if($loaidichvu == "gym")
			$sql = $sql . " and b.IdVanTay is not null and b.IdVanTay <> '' and a.LoaiTheVip like 'GM%'";
		else if($loaidichvu == "yoga")
			$sql = $sql . " and a.LoaiTheVip like 'YG%";
		else if($loaidichvu == "swim")
			$sql = $sql . " and a.LoaiTheVip like 'B%";
	}
	
	
	$tongthekhachcu = 0; $tongthekhachmoi_giahan = 0; $tongthekhach_tamngung = 0;
		
	try
	{
		$result_tt = sqlsrv_query($dbCon, $sql);
		if($result_tt != false)
		{
			foreach ($result_tt as $r)
			{
				$tongthekhachcu = $r['TongTheKhachCu'];
				$tongthekhachmoi_giahan = $r['TongTheKhachMoi'];
				$tongthekhach_tamngung = $r['TongTheKhachNgung'];
			}
		}
	}
	catch (PDOException $e1) {
		echo $e1->getMessage();
	}
?>
<h3 class="title">TỔNG HỢP THẺ KHÁCH HÀNG</h3>
     <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
				<div class="panel-body no-padding">
					<table class="table table-striped">
						<thead>
							<tr class="warning">
								<th>Số thẻ cũ</th>
								<th>Số thẻ cấp mới, gia hạn</th>
								<th>Số thẻ bị tạm ngưng</th>
								<th></th>								
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php echo number_format( $tongthekhachcu,0); ?></td>
								<td><?php echo number_format( $tongthekhachmoi_giahan,0); ?></td>
								<td><?php echo number_format( $tongthekhach_tamngung,0); ?></td>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>
	</div>
     <h3 class="title">DANH SÁCH THẺ CHI TIẾT</h3>
  	<div class="bs-example4" data-example-id="contextual-table">
    <table class="table">
      <thead>
        <tr>
          <th>Khách hàng</th>
          <th>Điện thoại</th>
		  <th>Loại thẻ</th>
		  <th>Ngày</th>
          <th>Tình trạng</th>
        </tr>
      </thead>
      <tbody>
<?php 		
	$sql2="SELECT TenDoiTuong, DienThoai, TenLoaiThe, NgayApDung, case when ISNULL(a.NgungThe,0) = 0 then N'Đang sử dụng' else N'Tạm ngưng' end as TinhTrangThe FROM tblKhachHang_TheVip a, tblDMKHNCC b, tblDMLoaiTheVip c Where a.MaKhachHang = b.MaDoiTuong and a.LoaiTheVip = c.MaLoaiThe";
	$sql2 = $sql2 . " and Convert(varchar,isnull(NgayApDung,getdate()),111) >= '$tungay_converted'";
	$sql2 = $sql2 . " and Convert(varchar,isnull(NgayApDung,getdate()),111) <= '$denngay_converted'";
	
	try
	{
		$result_kh = $dbCon->query($sql2);
		if($result_kh != false)
		{
			foreach ($result_kh as $r2)
			{
?>      
        <tr class="success">
			<td><?php echo $r2['TenDoiTuong'];?></td>
			<td><?php echo $r2['DienThoai'];?></td>
			<td><?php echo $r2['TenLoaiThe'];?></td>
			<td><?php echo $r2['NgayApDung'];?></td>
            <td><?php echo $r2['TinhTrangThe'];?></td>
        </tr>
<?php 
			}
		}
	}
	catch (PDOException $e1) {
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
