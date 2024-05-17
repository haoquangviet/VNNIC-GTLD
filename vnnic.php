<?php
/*
Mã ngu?n này thu?c s? h?u c?a Hao Quang Viet Software
MuaSSL.com Certificate Authority
Tác gi?: Nguy?n Qu?c Vi?t
Email: viet@haoquangviet.com
*/

class VNNIC{
	protected $vnnicClientID = '';
	protected $vnnicClientSecret = '';
	public $vnnicUrl = 'https://gtld-api.vnnic.vn/v1';
	public $vnnicUrlTest = 'https://gtldapi-ote.vnnic.vn/v1';
	public $debug=false;
    	public $test=true;
	public function __construct($id,$key){
		$this->vnnicClientID = $id;
		$this->vnnicClientSecret = $key;
	}
	public function quocgia(){
		return $this->call('/places/countries');
	}
	public function tinhthanh(){
		return $this->call('/places/provinces');
	}
	public function quanhuyen($id=''){
		return $this->call('/places/districts/'.($id?'/'.$id:''));
	}
	public function phuongxa($id=''){
		return $this->call('/places/wards'.($id?'/'.$id:''));
	}
	public function icann(){
		return $this->call('/categories/icann-registrars');
	}
	public function tracuu($domain=null){
		return $this->call('/registrars/domains'.($domain?'/'.$domain:''));
	}
	public function guiBaobao($data=[]){
		$thamso = array('domainName','registeredDate','expiredDate','ownerName','ownerType','address','wardName','districtName','cityName','countryCode','phone','email','fax','adminName','isAgentManager','icannRegistrarName','note');
		
		return $this->call('/reports/maintain-domains','-H "Content-Type: application/json"',$data,'POST');
	}
	public function guibaobaoBiendong($data=[]){
		$thamso = array('domainName','registeredDate','expiredDate','ownerName','ownerType','address','wardName','districtName','cityName','countryCode','phone','email','fax','adminName','isAgentManager','icannRegistrarName','action','actionReason','actionSource','actionDate','note');
		
		return $this->call('/reports/fluctuation-domains','-H "Content-Type: application/json"',$data,'POST');
	}
	function call($uri='',$parameter=null,$body=[],$type='GET'){
		$url = $this->vnnicUrl . $uri;
		if($this->test==true){
			$url = $this->vnnicUrlTest . $uri;
		}
		
		$authToken = base64_encode($this->vnnicClientID.':'.$this->vnnicClientSecret);
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$authToken,'Accept: application/json', 'Content-Type: application/json'));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		
		if($body){
			if($body[0][0])$body = $body[0];
			$body = json_encode($body);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
		}

		$thucthi = curl_exec($curl);
		curl_close($curl);
		
		$ketqua = json_decode($thucthi,true);
		if ($this->debug == true){
			$ketqua['body'] = $body;	
			$ketqua['url'] = $url;
		}
		return $ketqua;
	}
}
