<?php
//Constants
define("ALGO","sha1");  					//See hash_algos() for a list of supported algorithms. 
define("SECRET_KEY","Rajat Saxena");		//You can edit the key to any string/hash
define("ENCODED_AMP","_AMP_");				//Encode & inside the nested parameters with some CHAR


/**
 *Class to manage MAC (Message Authentication Code)
 *
 *@Author Rochak Chauhan
 *
 */
class PhpMessageAuthenticationCode{
	
	/**
	 * Function to generate hash of the data using the pre-defined algo
	 *
	 * @param string $data
	 *
	 * @return string
	 */
	public function generateHash($data){		
		if(!empty($data)){
			$hash=hash_hmac(ALGO,$data,SECRET_KEY);
			return $hash;
		}
		else{
			 throw new Exception('FATAL ERROR: Can not hash an empty data');
		}
	}

	/**
	 * Function to compare hash of the data using the pre-defined algo
	 *
	 * @param string $hash
	 * @param string $data
	 * @param boolean $encoded [OPTIONAL]
	 *
	 * @return mixed
	 */
	public function compareHash($hash, $data, $encoded=FALSE){		
		$hash_checksum=$this->generateHash($data);
		if($hash==$hash_checksum){
			$data=str_replace(ENCODED_AMP,"&",$data);
			return $data;
		}
		else{
			return FALSE;
		}
	}
	
	/**
	 * Function to prepare link using the hash and data
	 *
	 * @param string $baseurl
	 * @param string $data
	 * @param boolean $encoded [OPTIONAL]
	 *
	 * @return string
	 */
	public function prepareLink($baseurl, $data, $encoded=0){
		$pos = strpos($baseurl, '?');
		$data=str_replace("&",ENCODED_AMP,$data);
		if($encoded!=0){
			$amp=ENCODED_AMP;			
			$hash=$this->generateHash($data);
		}
		else{
			$amp="&";
			$hash=$this->generateHash($data);
		}
		if($pos){
			$link=$baseurl.$amp."data=".$data.$amp."hash=".$hash;
		}
		else{
			$link=$baseurl."?data=".$data.$amp."hash=".$hash;
		}
		
		if($encoded!=FALSE){
			$link=$link."&encoded=1";
		}
		$link=str_ireplace(ENCODED_AMP."hash","&hash",$link);
		return $link;
	}
}
?>