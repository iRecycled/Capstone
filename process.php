<?php
    $function = $_POST['function'];
	//comment
    $log = array();
    switch($function) {

    	 case('getState'):
          $privateserver = htmlentities(strip_tags($_POST['file']));
          $privateserver = "chat/private/".$privateserver.".txt";
        	 if(file_exists($privateserver)){
               $lines = file($privateserver);
        	 }
          $log['state'] = count($lines);
        	 break;

    	 case('update'):
        	$state = $_POST['state'];
          $privateserver = htmlentities(strip_tags($_POST['file']));
          $privateserver = "chat/private/".$privateserver.".txt";
          $myfile = fopen("chat/GrabbedChatServer.txt", "w") or die("Unable to open file!");
          fwrite($myfile, $privateserver);
          fclose($myfile);
        	if(file_exists($privateserver)){
        	   $lines = file($privateserver);
        	 }
        	 $count =  count($lines);
        	 if($state == $count){
        		 $log['state'] = $state;
        		 $log['text'] = false;

        		 }
        		 else{
        			 $text= array();
        			 $log['state'] = $state + count($lines) - $state;
        			 foreach ($lines as $line_num => $line)
                       {
        				   if($line_num >= $state){
                         $text[] =  $line = str_replace("\n", "", $line);
        				   }

                        }
        			 $log['text'] = $text;
        		 }

             break;

    	 case('send'):
		   $nickname = htmlentities(strip_tags($_POST['nickname']));
       $time = $_POST['time'];
	     $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
	     $message = htmlentities(strip_tags($_POST['message']));
       $privateserver = htmlentities(strip_tags($_POST['file']));
       $privateserver = "chat/private/".$privateserver.".txt";
	     if (($message) != "\n") {
	       if (preg_match($reg_exUrl, $message, $url)) {
	          $message = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a>', $message);
	       }
	          fwrite(fopen($privateserver, 'a'), $nickname."<".$time."<".$message = str_replace("\n", " ", $message) . "\n");
	     }
         break;
    }

    echo json_encode($log);
?>
