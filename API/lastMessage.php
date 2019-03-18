<?php
//$privateserver = "../chat/private/".$serverId.".txt";
$server = "9";
$privateserver = "../chat/private/".$server.".txt";
$exists = file_exists($privateserver);

$lines = file($privateserver);
$log= count($lines);

  echo json_encode($log);
?>