<?php
$access_token = 'ae6P1wQm9pDtBXz1TQNnAqWJSUHvIiUl0GWPJNvLK8MQxYuPIaqaP+Kea9H6QcnyVCyw2iJILvy00zXyV/B9nIB+NAeP9P9da7HZxbk0atcm2tYeuXngrKaMBMWwMy3msa5PEluN2bGu0JI7enTELwdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);

// Make a POST Request to Messaging API to reply to sender
$url = 'https://api.line.me/v2/bot/message/reply';

// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) 
	{
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			$user = $event['source']['userId'];
			// Get replyToken
			$replyToken = $event['replyToken'];
			$msg = "";	
			$fnc = explode("#", $text);
			if($user == 'Ua0afffd8ddfae4569dff6ab0abb17ee4')
			{
			
			
			

						if($fnc[0] == 'bot:type')
						{
							$msg = $fnc[1];
							push($msg , $replyToken);
		
						}else if ($fnc[0] == 'bot:time'){
							$today = date("D M j G:i:s T Y");	
					     	$msg = String($today);	
					     	push($msg , $replyToken);
						}
				
			
			}else{
					if($fnc[0] == 'bot:cal')
						{
							$msg = $fnc[1];
							calculate_string($msg);
							push($msg , $replyToken);
		
						}

			}
		}
	}

}

function calculate_string( $mathString )    {
	$mathString = trim($mathString);   
	$mathString = ereg_replace ('[^0-9+-*/() ]', '', $mathString);    

	$compute = create_function("", "return (" . $mathString . ");" );
	return 0 + $compute();
}



function push($msg , $replyToken) {
		// Build message to reply back
 		 $messages = [
				'type' => 'text',
				'text' => $msg
			];

			
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);
 }

echo "OK";
