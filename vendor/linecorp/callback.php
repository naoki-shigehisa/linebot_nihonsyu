<?php
require_once __DIR__ . '/vendor/autoload.php';

$accessToken = 'i0zHw9tReTRmen/YFaoHHkjDR7NpdWITvVW/r4HqClkX+WsIjxKN1ClrFfSzl87EPlcqplUIYHSJtnc7FBDQN0PBELlMW3mZTBkWaZqFIccsJRW2B2NC0t0XFffKmWN3a8kB6zbXmENdQEZ/lyseigdB04t89/1O/w1cDnyilFU=';
$channelSecret = '0433df711bcb98b6bf6afbc4baad1350';

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient( $accessToken );
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret ]);

//���b�Z�[�W�擾
$json_string = file_get_contents('php://input');
$json_object = json_decode($json_string);

$replyToken = $json_object->{"events"}[0]->{"replyToken"};
$message_type = $json_object->{"events"}[0]->{"message"}->{"type"};
$message_text = $json_object->{"events"}[0]->{"message"}->{"text"};

//���[�U�[���擾
$user_id = $json_object->{"events"}[0]->{"source"}->{"userId"};

$response = $bot->getProfile( $user_id );
if ($response->isSucceeded()) {
    $profile = $response->getJSONDecodedBody();
    $user_name = $profile['displayName'];
    //echo $profile['pictureUrl'];
    //echo $profile['statusMessage'];
}

//���b�Z�[�W�^�C�v�� text ����Ȃ��Ƃ��͂Ƃ肠�����I������
if($message_type != "text") exit;

//�ԐM���b�Z�[�W
if($message_text == "���͂悤") {
	$return_message_text = $user_name . "���� ���͂悤�������܂��B�o�Ύ���" . date('Y/m/d H:i:s') . "���L�^���܂����B";
} elseif($message_text == "������") {
	$return_message_text = $user_name . "���� �����ꂳ�܂ł����B�ދΎ���" . date('Y/m/d H:i:s') . "���L�^���܂����B";
} else {
	$return_message_text = $user_name . "���� " . $message_text . "�͓o�^����Ă��܂���";
}

//�ԐM���s
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
    'Content-Type: application/json; charser=Shift JIS',
    'Authorization: Bearer ' . $accessToken
));
$result = curl_exec($ch);
curl_close($ch);

?>
