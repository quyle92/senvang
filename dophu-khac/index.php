<?php
$tungay = date('d-m-Y');
//$tungay = substr($tungay,6) . "/" . substr($tungay,3,2) . "/" . substr($tungay,0,2);

$denngay = date('d-m-Y');
//$denngay = substr($denngay,6) . "/" . substr($denngay,3,2) . "/" . substr($denngay,0,2);

$tugio =  isset( $_POST['tugio'] ) ? $_POST['tugio'] :"";
if ($tugio == '' || $tugio == null) $tugio = "00:01";

$dengio =  isset( $_POST['dengio'] ) ? $_POST['dengio'] :"";
if ($dengio == '' || $dengio == null) $dengio = "23:00";

$khu = $senvang->getKhu();
$ma_khu_abbr_arr = array();

for ($i = 0; $i < sqlsrv_num_rows($khu); $i++) 
{  
  $r = sqlsrv_fetch_array($khu, SQLSRV_FETCH_ASSOC , SQLSRV_SCROLL_ABSOLUTE, $i);

  $ma_khu_abbr_arr[] = $r['MK'];
}
?>

<form action="" method="post" id="occupied-tables">
  <div class="row">
      	<div class="col-md-2" style="margin-bottom:5px">Từ ngày:</div>
	        <div class="col-md-3" style="margin-bottom:5px"><input name="tungay" type="text"  value="<?=@$tungay?>" id="tungay" /></div>
	        <div class="col-md-2" style="margin-bottom:5px">Từ giờ: </div>
	        <div class="col-md-3" style="margin-bottom:5px"><input name="tugio" type="time"  value="<?=($tugio) ? $tugio : ""?>" id="tugio" /></div>
        <div class="col-md-2" style="margin-bottom:5px"></div>
	</div>
	<div class="row">
      	<div class="col-md-2" style="margin-bottom:5px">Đến ngày:</div>
	        <div class="col-md-3" style="margin-bottom:5px"><input name="denngay" type="text"  value="<?=@$denngay?>" id="denngay" /></div>
	        <div class="col-md-2" style="margin-bottom:5px">Đến giờ: </div>
	        <div class="col-md-3" style="margin-bottom:5px"><input name="dengio" type="time"  value="<?php echo @$dengio ?>" id="dengio" /></div>
        <div class="col-md-2" style="margin-bottom:5px"><input type="submit" value="Lọc"></div>
	</div>
</form>


<?php
$khu = $senvang->getKhu();//echo sqlsrv_num_rows($khu);
for ($i = 0; $i < sqlsrv_num_rows($khu); $i++) 
{   
    $r = sqlsrv_fetch_array($khu, SQLSRV_FETCH_ASSOC , SQLSRV_SCROLL_ABSOLUTE, $i);
    $ma_khu = $r['MaKhu'];
    $ten_khu_raw = $r['MoTa'];
    $ten_khu = stripSpecial(stripUnicode(($r['MoTa'])));

    $file_name = 'dophu-khac/' . $ten_khu . '.php';
    $file_name_ajax = 'dophu-khac/ajax/process-' . $ten_khu . '.php';

    if( !( file_exists($file_name) ) )
    {
      $file_contents = file_get_contents("dophu-khac/template.php");
      file_put_contents( $file_name , $file_contents );
    }

    if( !( file_exists($file_name_ajax) ) ){
      $file_contents = file_get_contents("dophu-khac/ajax/ajax-template.php");
      file_put_contents( $file_name_ajax , $file_contents );
    }

    include( $file_name );

} 
?>


