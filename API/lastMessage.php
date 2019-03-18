<?php
//$privateserver = "../chat/private/".$serverId.".txt";
$privateserver = "../chat/private/9.txt";
/*if(file_exists($privateserver)){
    $lines = file($privateserver);
    $log['state'] = count($lines);
  }
  else{
    $lines = "Failure"
    $log="Failure"
  }
  //mysql_close($db);
  */
  echo json_encode($privateserver);
?>