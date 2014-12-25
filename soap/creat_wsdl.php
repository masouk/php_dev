<?php

include("server.php");
include("SoapDiscovery.class.php");
//第一個参數是會是wsdl的檔名，第二個参數是service的名字
$disco = new SoapDiscovery('Service', 'soap'); //第一个参数是类名（生成的wsdl文件就是以它来命名的），即Service类，第二个参数是服务的名字（这个可以随便写）。
$disco->getWSDL();

?>