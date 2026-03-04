<?php

// ✅ อนุญาต CORS (ให้ localhost เรียกได้)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, X-Access-Token");
header("Access-Control-Allow-Methods: POST, OPTIONS");

// รองรับ preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$ch1 = curl_init();

curl_setopt_array($ch1, [
    CURLOPT_URL => "https://bmaapi.msdbangkok.go.th/wsQ/api/Token?hptcode=".$_GET['hptcode'],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => '"9105icFZWIym0CYoSUs5r0pBpHF8AFLbutcv93LhcZMr2/iou1jDgCZnpQncl71K"',
    // CURLOPT_POSTFIELDS => $input,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        // "X-Access-Token: $accessToken"
        "X-Access-Token: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiIxMTUzNyIsImF1ZCI6IjU1NTU1In0.tFMbjZhhQTEUL85TTVdtbltDvaU-CgBBrEby3p9DmWA"
    ],
]);

$response1 = curl_exec($ch1);
$result1 = json_decode($response1, true)["Result"];


// รับ body จาก frontend
$input = file_get_contents("php://input");

// รับ token จาก header
$headers = getallheaders();
$accessToken = isset($headers['X-Access-Token']) ? $headers['X-Access-Token'] : '';
// $accessToken = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE3NzIxNTcyODksImlzcyI6Ii0zMDAwIiwiYXVkIjoiNTU1NTUifQ.cVO_zPC_SK0tHZE5nRHjrlt0bxNSuCoBHcXgR9P7OCU"

$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => "https://bmaapi.msdbangkok.go.th/wsQ/api/mqo?hptcode=".$_GET['hptcode'],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => '"Sf0C1IO0kFjJ0cpNMmf/SJg2k7yeHJwX2VhuRyuR4S0="',
    // CURLOPT_POSTFIELDS => $input,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        // "X-Access-Token: $accessToken"
        "X-Access-Token: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE3NzIxNTcyODksImlzcyI6Ii0zMDAwIiwiYXVkIjoiNTU1NTUifQ.cVO_zPC_SK0tHZE5nRHjrlt0bxNSuCoBHcXgR9P7OCU"
    ],
]);
// json_decode($ch1['Result'])
$response = curl_exec($ch);



// $items = $data['results'][0]['items'] ?? [];
// print_r($response);exit;

if (curl_errno($ch)) {
    http_response_code(500);
    echo curl_error($ch);
    exit();
}

curl_close($ch);

// ส่ง response กลับไปที่ browser
echo $response;