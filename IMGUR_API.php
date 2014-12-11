  /*
   * IMGUR API
   * HTTPS NEED TO ADD line CURLOPT_SSL_VERIFYPEER false
   */
  $client_id = "******";
	$image = file_get_contents("./undefined-1.jpg");
	echo "UPLOAD";
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
	/*
	curl_setopt($ch, CURLOPT_URL, 'http://tw.yahoo.com/');
	$reply = curl_exec($ch);
	curl_close($ch);
	echo $reply;
	return;*/
	
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $client_id));
	curl_setopt($ch, CURLOPT_POSTFIELDS, array('image' => base64_encode($image),'name'=>'taiwan','title'=>'taiwan'));

	$reply = curl_exec($ch);
	if(curl_errno($ch))
{
    echo 'Curl error: ' . curl_error($ch);
}

	curl_close($ch);
	echo $reply;
	$reply = json_decode($reply);
	

	printf('<img height="180" src="%s" >', $reply->data->link);
