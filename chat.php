<?php
header('Content-Type: application/json');

// আপনার নতুন API Key এখানে বসান
$apiKey = "AIzaSyCDoyKPw-JyLoiNfDp57TBSKJy9ehnZutw"; 

$input = json_decode(file_get_contents('php://input'), true);
$userMessage = $input['message'] ?? '';

if (empty($userMessage)) {
    echo json_encode(["error" => "No message provided"]);
    exit;
}

$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $apiKey;

$data = [
    "contents" => [[
        "parts" => [["text" => "তুমি একজন দোকানের সহকারী। দোকানের তথ্য: মোবাইল ২০,০০০ টাকা, চার্জার ৫০০ টাকা, হেডফোন ১,০০০ টাকা। কাস্টমার জিজ্ঞেস করেছে: " . $userMessage]]
    ]]
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

// InfinityFree-র জন্য সবথেকে জরুরি সেটিংস
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(["error" => curl_error($ch)]);
} else {
    echo $response;
}

curl_close($ch);
?>
