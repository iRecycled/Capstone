<?php
    // TODO edit chatengine functions to work this file
    $function = $_POST['function'];

    $log = array();
    switch($function) {
        // counts the lines in the file
    	 case('getState'):
            $instantMessage = htmlentities(strip_tags($_POST['file']));
            $instantMessage = "chat/private/".$instantMessage.".txt";
        	if(file_exists($instantMessage)){
               $lines = file($instantMessage);
        	}
            $log['state'] = count($lines);
        	break;
        // Updates the file with the new text
    	 case('update'):
        	$state = $_POST['state'];
            $instantMessage = htmlentities(strip_tags($_POST['file']));
            $instantMessage = "private/chat/".$instantMessage.".txt";
            $myfile = fopen("chat/GrabbedChatServer.txt", "w") or die("Unable to open file!");
            fwrite($myfile, $instantMessage);
            fclose($myfile);
        	if(file_exists($instantMessage)){
        	   $lines = file($instantMessage);
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
        // adds the new message to the file
    	 case('send'):
		    $nickname = htmlentities(strip_tags($_POST['nickname']));
            $time = $_POST['time'];
	        $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
	        $message = htmlentities(strip_tags($_POST['message']));
            $instantMessage = htmlentities(strip_tags($_POST['file']));
            $instantMessage = "chat/private/".$instantMessage.".txt";
	        if (($message) != "\n") {
	            if (preg_match($reg_exUrl, $message, $url)) {
	                $message = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a>', $message);
	            }
	        fwrite(fopen($instantMessage, 'a'), $nickname."<".$time."<".$message = str_replace("\n", " ", $message) . "\n");
	        }
            break;
    }
    echo json_encode($log);
?>