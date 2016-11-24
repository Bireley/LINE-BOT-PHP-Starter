<?php
$access_token = 'uPfOO1IB6WduSB+NY91Vajcads+QKdaA85nn6Rz6q4GXomZcTIEB2tQVJwXK1RNqfVhwTyPYWetE2L2xib/WYoVymxmNtJs5HdYC34fz6jQebIsqyPTLloiKEvCMjpnJdsxUEYrvvYL6OoJJW/cT1gdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	file_put_contents("php://stderr", "hello, this is a test : "  . $content  . "  \n");
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = "B : " . $event['message']['text'];
			// Get replyToken
			
			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $text
			];

			
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages]
			];
		
		}
		else 
		{
		
			$text = "You have send message type : " . $event['message']['type'] . " to me.";
			// Get replyToken
			
			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $text
			];

			
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages]
			];
		
				
		}
	
		// Make a POST Request to Messaging API to reply to sender
		$url = 'https://api.line.me/v2/bot/message/reply';
		// $replyToken = $event['replyToken'];
		$post = json_encode($data);
		$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
		
		file_put_contents("php://stderr", "Post Data : "  . $post  . "  \n");
		
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$result = curl_exec($ch);
		
		file_put_contents("php://stderr", "Result : "  . $result  . "  \n");
		
		curl_close($ch);

		echo $result . "\r\n";
			
	}
}
echo "OK";
