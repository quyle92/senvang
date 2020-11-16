<?php
require('lib/db.php');
require('lib/SENVANG.php');
require('helper/custom-function.php');
$senvang = new SENVANG;
@session_start();

date_default_timezone_set('Asia/Ho_Chi_Minh');
$timezone = date_default_timezone_get();
$today = date('Y/m/d');;
// $ma_khu = $_POST['ma_khu'];



$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];
$trungtam=$_SESSION['TenTrungTam'];

$chinhanh=@$_POST['chinhanh'];
$thungan=@$_POST['thungan'];

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

<!--  ChartJS   -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<!-- DataLabels plugin --> 
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0/dist/chartjs-plugin-datalabels.min.js"></script>

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

[id^="chart_legends"] ul{
   list-style: none;
   font: 12px Verdana;
   white-space: nowrap;
   margin-top: 10px;
}

[id^="chart_legends"] li span{
   width: 36px;
   height: 12px;
   display: inline-block;
   margin: 0 5px 8px 0;
   vertical-align: -9.4px;
}



.nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover {
	background-color: #fff!important;
	color: #555;
}

.nav-tabs > li > a, .nav-tabs > li > a:focus{
	color: #fff;
}

.form-control .do-phu{
	border: 1px solid #555!important;
	border-radius: 0px!important;
}

</style>
</head>
<body>
<div id="wrapper">
     <?php //include 'menu.php'; ?>
        <div id="page-wrapper">
        <div class="col-md-12 graphs">
	   

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

     </form>

 	<div class="panel with-nav-tabs panel-primary ">
        <div class="panel-heading">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1primary" data-toggle="tab">Hôm nay</a></li>
                    <li><a href="#tab2primary" data-toggle="tab">Khác</a></li>
                </ul>
        </div>
        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="tab1primary">
                    <div class="col-xs-12 col-sm-12 table-responsive">
                        <div class="container-fluid">
                           	<?php
                          	$khu = $senvang->getKhu();//echo sqlsrv_num_rows($khu);
							for ($i = 0; $i < sqlsrv_num_rows($khu); $i++) 
							{ 	$r = sqlsrv_fetch_array($khu, SQLSRV_FETCH_ASSOC , SQLSRV_SCROLL_ABSOLUTE, $i);
								$ma_khu = $r['MaKhu'];
								$ten_khu_raw = $r['MoTa'];
								$ten_khu = stripSpecial(stripUnicode(($r['MoTa'])));

								$file_name = 'dophu/' . $ten_khu . '.php';

								if( !( file_exists($file_name) ) ){
		                            $file_contents = file_get_contents("dophu/template.php");
		                            file_put_contents( $file_name , $file_contents );
		                         }
								
								include('dophu/' . $ten_khu . '.php');
							} 
	                        ?>
						</div>
                   </div>
                </div>
                <div class="tab-pane fade" id="tab2primary">
                  <div class="col-xs-12 col-sm-12 table-responsive">
                    <?php include("dophu-khac/index.php")?>
                  </div>
                </div>

            </div>
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
