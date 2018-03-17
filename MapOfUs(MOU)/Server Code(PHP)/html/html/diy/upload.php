<?php

$connect = mysqli_connect('localhost', 'root', 'Jeong0908!', 'usemap') or die('MYSQL Server 연결에 실패했습니다');

$img=$_FILES['img'];
if(isset($_POST['submit'])){ 
		if($img['name']==''){  
				echo "<h2>An Image Please.</h2>";
		}else{
				$filename = $img['tmp_name'];
				$client_id="f84056b2097514c";
				$handle = fopen($filename, "r");
				$data = fread($handle, filesize($filename));
				$pvars   = array('image' => base64_encode($data));
				$timeout = 30;
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
				curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
				curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $client_id));
				curl_setopt($curl, CURLOPT_POST, 1);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
				$out = curl_exec($curl);
				curl_close ($curl);
				$pms = json_decode($out,true);
				$url=$pms['data']['link'];
				if($url!=""){
						echo "<h2>Uploaded Without Any Problem</h2>";
						echo "이미지 경로 : $url <br />";
						echo "<img src='$url'/>";

						$query = "insert into public_url values ('0', '$url');";
						mysqli_query($connect, $query);
						mysqli_close($connect);

				}else{
						echo "<h2>There's a Problem</h2>";
						echo $pms['data']['error'];  
				} 
		}
}
?>


