<?php

$connect = mysqli_connect('localhost', 'root', 'gkgustn32', 'DIY') or die('MYSQL Server 연결에 실패했습니다');

$input = json_decode(file_get_contents("php://input"));

$name=$input->space_name;
$unisex = $input->Unisex;
$disabled=$input->disabled;
$longitude=$input->longitude;
$latitude=$input->latitude;
$img=$input->image;

$query = "insert into DIY_toilet values ('', '$name','$disabled','$unisex','$longitude','$latitude');";
mysqli_query($connect, $query);


$query = "select toiletID from DIY_toilet where longitude = '$longitude' and latitude = '$latitude';";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_array($result);


$client_id="f84056b2097514c";

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $client_id));
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $img);
$out = curl_exec($curl);
curl_close ($curl);
$pms = json_decode($out,true);
$url=$pms['data']['link'];
if($url!=""){
	$query = "insert into DIY_toilet_url values ('$row[0]', '$url');";
	mysqli_query($connect, $query);
	mysqli_close($connect);

}else{
	echo "<h2>There's a Problem</h2>";
	echo $pms['data']['error'];  
} 

?>
