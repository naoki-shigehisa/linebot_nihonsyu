<?php
require_once(__DIR__."/vendor/autoload.php");

//アクセストークンを入力
$accessToken = ;
//チャンネルセレクトを入力
$channelSecret = ;

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient( $accessToken );
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret ]);

$json_string = file_get_contents('php://input');
$json_object = json_decode($json_string);

$replyToken = $json_object->{"events"}[0]->{"replyToken"};
$message_type = $json_object->{"events"}[0]->{"message"}->{"type"};
$message_text = $json_object->{"events"}[0]->{"message"}->{"text"};

$user_id = $json_object->{"events"}[0]->{"source"}->{"userId"};

$response = $bot->getProfile( $user_id );
if ($response->isSucceeded()) {
    $profile = $response->getJSONDecodedBody();
    $user_name = $profile['displayName'];
}

if($message_type != "text") exit;

//pythonファイル実行コマンド
$fullPath ='python3 ./call_from_php_gensim.py '.$message_text;
  exec($fullPath, $outpara);

$return_message_text =$outpara[0];

$response_format_text = [
    "type" => $message_type,
    "text" => $return_message_text
];

$post_data = [
    "replyToken" => $replyToken,
    "messages" => [$response_format_text]
];

$ch = curl_init("https://api.line.me/v2/bot/message/reply");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json; charser=UTF-8',
    'Authorization: Bearer ' . $accessToken
));
$result = curl_exec($ch);
curl_close($ch);

?>
