<?php 

$device_type = '裝置類型'
$mobile_token = '手機裝置推播token';

if($device_type == 'android'){
      $gcm = new Gcm();
      $apiKey = 'apply api key'; //向google申請的api key
      $devices = array($mobile_token); //手機裝置token
      $message = 'Your define message'

      $gcm->gcm($apiKey);
      $gcm->setDevices($devices);
      $response = $gcm->send($message, array('title' => 'Test title'));
      print_r($response);

}else{
      //$apnsHost = 'gateway.push.apple.com';
      $apnsHost = 'gateway.sandbox.push.apple.com';
      $apnsCert = 'apns_dev.pem'; //apple 申請之憑證
      $apnsPort = 2195;

      $deviceToken = $mobile_token;

      $streamContext = stream_context_create();
      stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
      $apns = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 60, STREAM_CLIENT_CONNECT, $streamContext);

      if( !$apns ){
          echo 'Failed to connect'.PHP_EOL;
          exit;
      }

      $payload['aps'] = array('alert' => 'Oh hai!', 'badge' => 99, 'sound' => 'default');
      $output = json_encode($payload);
      $token = pack('H*', str_replace(' ', '', $deviceToken));
      $apnsMessage = chr(0) . chr(0) . chr(32) . $token . chr(0) . chr(strlen($output)) . $output;

      echo $output.PHP_EOL;
      print_r($apns);
      fwrite($apns, $apnsMessage);
      fclose($apns);
}


class Gcm {

    var $url = 'https://android.googleapis.com/gcm/send';
    var $serverApiKey = "";
    var $devices = array();

    /*
        Constructor
        @param $apiKeyIn the server API key
    */
    function Gcm($apiKeyIn){
        $this->serverApiKey = $apiKeyIn;
    }

    /*
        Set the devices to send to
        @param $deviceIds array of device tokens to send to
    */
    function setDevices($deviceIds){

        if(is_array($deviceIds)){
            $this->devices = $deviceIds;
        } else {
            $this->devices = array($deviceIds);
        }

    }

    /*
        Send the message to the device
        @param $message The message to send
        @param $data Array of data to accompany the message
    */
    function send($message, $data = false){

        if(!is_array($this->devices) || count($this->devices) == 0){
            $this->error("No devices set");
        }

        if(strlen($this->serverApiKey) < 8){
            $this->error("Server API Key not set");
        }

        $fields = array(
            'registration_ids'  => $this->devices,
            'data'              => array( "message" => $message ),
        );

        if(is_array($data)){
            foreach ($data as $key => $value) {
                $fields['data'][$key] = $value;
            }
        }

        $headers = array(
            'Authorization: key=' . $this->serverApiKey,
            'Content-Type: application/json'
        );

        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt( $ch, CURLOPT_URL, $this->url );

        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

        curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );

        // Avoids problem with https certificate
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);

        // Execute post
        $result = curl_exec($ch);

        // Close connection
        curl_close($ch);

        return $result;
    }

    function error($msg){
        echo "Android send notification failed with error:";
        echo "\t" . $msg;
        exit(1);
    }
}
?>
