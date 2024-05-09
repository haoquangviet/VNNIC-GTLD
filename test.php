<?php
header('Content-type: application/json');
error_reporting();//
require_once('vnnic.php');

$vnnic = new VNNIC('Nhap ID','Nhap Secret');
//cau hinh debug
$vnnic->debug=0;
//cau hinh test server
$vnnic->test=1;
//du lieu tra ve
$ketqua['info'] = 'VNNIC report';
//lay quoc gia
$ketqua['quocgia'] = $vnnic->quocgia();
//lay tinh thanh
$ketqua['tinhthanh'] = $vnnic->tinhthanh();
//lay quan huyen
$ketqua['quanhuyen'] = $vnnic->quanhuyen(79);
//lay nha dang ky icann
$ketqua = $vnnic->icann();
//lay danh sach ten mien
$ketqua['tracucu'] = $vnnic->tracuu();
//tra cua ten mien cu the
$ketqua['tracucu'] = $vnnic->tracuu('haoquangviet.com');
//gui bao cao
$guibaocao[] = array(
	'domainName'=>'haoquangviet.com',
	'registeredDate'=>'2024-01-01',
	'expiredDate'=>'2025-01-01',
	'ownerName'=>'Hao Quang Viet Software',
	'ownerType'=>'T',
	'address'=>'208 Nguyen Trai',
	'wardName'=>'Phường Phạm Ngũ Lão',
	'districtName'=>'Quận 1',
	'cityName'=>'Thành phố Hồ Chí Minh',
	'countryCode'=>'VN',
	'phone'=>'+84.2877796009',
	'email'=>'hqv@haoquangviet.com',
	'fax'=>'',
	'adminName'=>'Tran Van Quyet',
	'isAgentManager'=>0,
	'icannRegistrarName'=>'eNom',
	'note'=>'test'
	);
$dsbaocao06[] = $guibaocao;

$ketqua['baocao06'] = $vnnic->guiBaobao($dsbaocao06);
//gui bao cao bien dong
$biendong[] = array(
	'domainName'=>'demo.com',
	'registeredDate'=>'2024-01-01',
	'expiredDate'=>'2025-01-01',
	'ownerName'=>'Hao Quang Viet Software',
	'ownerType'=>'T',
	'address'=>'208 Nguyen Trai',
	'wardName'=>'Phường Phạm Ngũ Lão',
	'districtName'=>'Quận 1',
	'cityName'=>'Thành phố Hồ Chí Minh',
	'countryCode'=>'VN',
	'phone'=>'+84.2877796009',
	'email'=>'hqv@haoquangviet.com',
	'fax'=>'',
	'adminName'=>'Tran Van Quyet',
	'isAgentManager'=>0,
	'icannRegistrarName'=>'eNom',
	'action'=>'ADD',
	'actionReason'=>'C',
	'actionSource'=>'eNom',
	'actionDate'=>'2024-01-01',
	'note'=>'test bien dong'
	);
$dsbiendong[] = $biendong;

$ketqua['baocaobiendong07'] = $vnnic->guibaobaoBiendong($dsbiendong);

echo json_encode($ketqua);
