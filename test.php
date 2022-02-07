<h2>TEST :: PHP Message Authentication Code</h2>
<?php
if(isset($_GET['hash']) &&  isset($_GET['data']) ){
	$data_encoded=0;
	
	extract($_GET);
	require_once("PhpMessageAuthenticationCode.inc.php");
	$obj=new PhpMessageAuthenticationCode();
	if(isset($encoded) && $encoded==1){
		$data_encoded=1;
	}	
	
	$data=$obj->compareHash($hash, $data,$data_encoded);
	if($data !=FALSE){
		echo "Valid Link: Data = $data";
	}
	else{
		throw new Exception('FATAL ERROR: Mismached Hash and Data. Please try again. <a href="usage.php">Usage</a>');
	}
}
else{
		throw new Exception('FATAL ERROR: Invalid or NO Hash and Data. Please try again. <a href="usage.php">Usage</a>');
}
?>