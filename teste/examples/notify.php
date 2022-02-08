<?php
require_once('../PhpSIP.class.php');

/* Sends NOTIFY to reset Linksys phone */

try
{
  $api = new PhpSIP();
  $api->setUsername('303'); // authentication username
  $api->setPassword('zaq1xsw2'); // authentication password
  // $api->setProxy('some_ip_here'); 
  $api->addHeader('Event: resync');
  $api->setMethod('NOTIFY');
  $api->setFrom('sip:303@sip.192.168.1.100.com');
  $api->setUri('sip:303@sip.192.168.1.100.com');
  $res = $api->send();

  echo "response: $res\n";
  
} catch (Exception $e) {
  
  echo $e;
}

?>
