<?php
/*
Mã nguồn này thuộc sở hữu của Hao Quang Viet Software
MuaSSL.com Certificate Authority
Tác giả: Nguyễn Quốc Việt
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
	public function tracuu($domain){
		return $this->call('/registrars/domains'.($domain?'/'.$domain:''));
	}
	public function guiBaobao($data=[]){
		$thamso = array('domainName','registeredDate','expiredDate','ownerName','ownerType','address','wardName','districtName','cityName','countryCode','phone','email','fax','adminName','isAgentManager','icannRegistrarName','note');
		
		return $this->call('/reports/maintain-domains','-H "Content-Type: application/json"',$postData,'POST');
	}
	public function guibaobaoBiendong($data=[]){
		$thamso = array('domainName','registeredDate','expiredDate','ownerName','ownerType','address','wardName','districtName','cityName','countryCode','phone','email','fax','adminName','isAgentManager','icannRegistrarName','action','actionReason','actionSource','actionDate','note');
		
		return $this->call('/reports/fluctuation-domains','-H "Content-Type: application/json"',$postData,'POST');
	}
	function call($uri='',$parameter=null,$body=null,$type='GET'){
		$url = $this->vnnicUrl . $uri;
		if($this->test==true){
			$url = $this->vnnicUrlTest . $uri;
		}
		
		$authToken = base64_encode($this->vnnicClientID.':'.$this->vnnicClientSecret);
		$header = array("Authorization: Basic $authToken");
		if($body)$body = '-d "'.$body.'"';
		
		$url = 'curl -X '.$type.' '.$parameter.' -H "Authorization: Basic '.$authToken.'" '.$body.' "'.$url.'"';
		$thucthi = shell_exec($url);
		//if(empty($thucthi))return ['cmd'=>$url];
		$ketqua = json_decode($thucthi,true);
		if ($this->debug == true){
			$ketqua['url'] = $url;
		}
		return $ketqua;
	}
}
