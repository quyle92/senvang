<?php
class DbConnection {

	protected $serverName = "DELL-PC\SQLEXPRESS";
	protected $connectionInfo = array( "Database"=>"SPA_SENVANG","CharacterSet" => "UTF-8", "UID"=>"sa", "PWD"=>"123");
	protected $conn;

	function __construct() {
			$this->conn =  sqlsrv_connect( $this->serverName, $this->connectionInfo) or die("Database Connection Error"."<br>". mssql_get_last_message()); 
    }
}

class SENVANG extends DbConnection{

	public function getKhu() {
		//$sql = "SELECT MaKhu, MoTa, SUBSTRING(MaKhu,4,10) as MK from [SPA_SENVANG].[dbo].[tblDMKhu]  where IsDieuTour = 1 ";
		$sql = "SELECT  TOP 10 MaKhu, MoTa, SUBSTRING(MaKhu,4,10) as MK from [SPA_SENVANG].[dbo].[tblDMKhu]  order by MoTa ";
		try 
		{
			$rs = sqlsrv_query($this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET));
			
			if( sqlsrv_fetch( $rs ) === false) {
			     die( print_r( sqlsrv_errors(), true));
			}
//print_r(sqlsrv_fetch( $rs ));
			return $rs;

		}
		catch ( PDOException $error )
		{
			echo $error->getMessage();
		}
	}


	public function countOccupiedTables( $date, $ma_khu = NULL ) : int {
		
		if ( $ma_khu == NULL Or $ma_khu == 'all')
		{
			$sql = "SELECT * FROM  [SPA_SENVANG].[dbo].[tblLichSuPhieu] where [ThoiGianDongPhieu] IS NULL and substring( Convert(varchar,[GioVao],111),0,11 ) = '$date'";
		}
		else {
			$sql = "SELECT a.MaBan, b.[MaKhu]  FROM [SPA_SENVANG].[dbo].[tblLichSuPhieu] a Left join
				  [SPA_SENVANG].[dbo].[tblDMBan] b ON a.MaBan=b.MaBan Left join
				  [SPA_SENVANG].[dbo].[tblDMKhu] c ON b.MaKhu=c.MaKhu where [ThoiGianDongPhieu] IS NULL and substring( Convert(varchar,[GioVao],111),0,11 ) = '$date' and  b.[MaKhu]='$ma_khu'";
		}
		try 
		{
			$rs = sqlsrv_query($this->conn, $sql, array(), array( "Scrollable" => 'static' ));

			if( sqlsrv_fetch( $rs ) === false) {
			     die( print_r( sqlsrv_errors(), true));
			}

			return $count = sqlsrv_num_rows($rs);

		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}

	}

	public function countTotalTables( $ma_khu = NULL ) : int {
		if ( $ma_khu == NULL Or $ma_khu == 'all' )
		{
			$sql = "SELECT * FROM  [SPA_SENVANG].[dbo].[tblDMBan]";
		}
		else
		{
			// $sql= "SELECT a.MaBan, b.[MaKhu]  FROM [SPA_SENVANG].[dbo].[tblLichSuPhieu] a Left join
			// 	  [SPA_SENVANG].[dbo].[tblDMBan] b ON a.MaBan=b.MaBan Left join
			// 	  [SPA_SENVANG].[dbo].[tblDMKhu] c ON b.MaKhu=c.MaKhu
			// 	  Where b.[MaKhu]='$ma_khu'";
			$sql = "SELECT * FROM [SPA_SENVANG].[dbo].[tblDMBan] where MaKhu ='$ma_khu'";
		}
		try 
		{
			$rs = sqlsrv_query($this->conn, $sql, array(), array( "Scrollable" => 'static' ));
			
			if( sqlsrv_fetch( $rs ) === false) {
			     die( print_r( sqlsrv_errors(), true));
			}

			return $count = sqlsrv_num_rows($rs);

		}
		catch ( PDOException $error )
		{
			echo $error->getMessage();
		}

	}

	public function getTotalTablesWithBills( $tungay, $denngay, $tugio, $dengio, $ma_khu = NULL) : int {
		if( $ma_khu == NULL Or $ma_khu == 'all')
		{
			$sql = "
		 	SELECT MaBan, count(*) as SoLuong FROM  [SPA_SENVANG].[dbo].[tblLichSuPhieu] where Convert(varchar,isnull(ThoiGianDongPhieu,getdate()),111) >= '$tungay' and Convert(varchar,isnull(ThoiGianDongPhieu,getdate()),111) <= '$denngay' 	and Substring(Convert(varchar,isnull(ThoiGianDongPhieu,getdate()),8),1,5) >= '$tugio' and Substring(Convert(varchar,isnull(ThoiGianDongPhieu,getdate()),8),1,5) <= '$dengio' group by MaBan
			";
		}
		else
		{
			$sql = "
		 	SELECT a.MaBan, count(*) as SoLuong FROM [SPA_SENVANG].[dbo].[tblLichSuPhieu] a Left join
			  [SPA_SENVANG].[dbo].[tblDMBan] b ON a.MaBan=b.MaBan Left join
			  [SPA_SENVANG].[dbo].[tblDMKhu] c ON b.MaKhu=c.MaKhu
  			 where Convert(varchar,isnull(ThoiGianDongPhieu,getdate()),111) >= '$tungay' and Convert(varchar,isnull(ThoiGianDongPhieu,getdate()),111) <= '$denngay' 	and Substring(Convert(varchar,isnull(ThoiGianDongPhieu,getdate()),8),1,5) >= '$tugio' and Substring(Convert(varchar,isnull(ThoiGianDongPhieu,getdate()),8),1,5) <= '$dengio' and b.[MaKhu]='$ma_khu' group by a.MaBan
			";
		}
		try 
		{
			$rs = sqlsrv_query($this->conn, $sql, array(), array( "Scrollable" => 'static' ));
			
			if( sqlsrv_fetch( $rs ) === false) {
			     die( print_r( sqlsrv_errors(), true));
			}

			return $count = sqlsrv_num_rows($rs);

		}
		catch ( PDOException $error )
		{
			echo $error->getMessage();
		}

	}

	

}