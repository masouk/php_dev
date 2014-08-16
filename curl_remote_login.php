<?php
	
  /*
   *透過CURL進行遠端登入
   */


	//使用者登入帳號密碼
	$username = "username";
	$password = "password";


	$loginUrl = 'http://servername/request_uri';

	$ch = curl_init();
	$postData = array(
    'AdminLoginForm[username]' => $username,
    'AdminLoginForm[password]' => $password
	);

		curl_setopt_array($ch, array(
		    CURLOPT_URL => $loginUrl,
		    CURLOPT_RETURNTRANSFER => true,
		    CURLOPT_POST => true,
		    CURLOPT_POSTFIELDS => $postData,
		    CURLOPT_FOLLOWLOCATION => true,
		    CURLOPT_COOKIESESSION => true,
		    CURLOPT_COOKIEJAR => realpath('cookie.txt') //需絕對路徑
    	));

	 
	$output = curl_exec($ch);


	//上述登入完成後，可進行該權限操作，這邊是透過遠端讀取檔案
	$url = 'http://servername/permission_uri';

	$fp_output = fopen('./test.xls', 'w');
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_COOKIEFILE, realpath("cookie.txt"));
	curl_setopt($ch, CURLOPT_FILE, $fp_output);
	curl_exec($ch);
	
	curl_close($ch);
	exec('libreoffice ./test.xls', $out, $status);

?>
