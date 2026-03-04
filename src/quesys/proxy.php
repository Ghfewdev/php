<?php

// =========================
// CORS
// =========================
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, X-Access-Token");
header("Access-Control-Allow-Methods: POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// =========================
// CONFIG
// =========================

// map hptcode => tokenhos
$hptcodelist = [
    "11537" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiIxMTUzNyIsImF1ZCI6IjU1NTU1In0.tFMbjZhhQTEUL85TTVdtbltDvaU-CgBBrEby3p9DmWA",
    "14641" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiIxNDY0MSIsImF1ZCI6IjU1NTU1In0.5ocKO5uF_pHN5Vab1lNlVPeiaVpGiDUgyDr-dtcvnCg",
    "11539" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiIxMTUzOSIsImF1ZCI6IjU1NTU1In0.2E6CS7e3rW6GdGqT4SEBqhsu_OiJs9FN2sKEhYJRweg",
    "11541" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiIxMTU0MSIsImF1ZCI6IjU1NTU1In0.6YStQ5qab0pvDXvQnAX7VxqyEbcYBbA6BljPv8s2Lmk",
    // "25060" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiIyNTA2MCIsImF1ZCI6IjU1NTU1In0.do86wb0eGOR1Y_KXtP0xIRPXcoVF1S62zWxcpAZ8h8o",
    // "41582" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiI0MTU4MiIsImF1ZCI6IjU1NTU1In0.hd6EasO3bORSqHlBS-yI-8VoJQ64_Louwy4CBKRhEtY",
    // "41522" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiI0MTUyMiIsImF1ZCI6IjU1NTU1In0.BDt8wRHxbYa0h1fyr7nXnHYyZefvcZ8eQcSJek1F2fU",
    // "11538" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiIxMTUzOCIsImF1ZCI6IjU1NTU1In0.afRi5uoFBxdX41FOEQ2wCxNEgMwVKMOOfO8C8UIuleE",
    // "11540" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiIxMTU0MCIsImF1ZCI6IjU1NTU1In0.6H35f2E1sOjd_mKipVr2Jxn267VK3ghVgJqZVwDiCtk",
    // "11536" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiIxMTUzNiIsImF1ZCI6IjU1NTU1In0.rU5SYOCE0_wWTNJ7Lpir7tNWRUe9zQOp03UrNB_G4SY",
    // "15049" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiIxNTA0OSIsImF1ZCI6IjU1NTU1In0.Rkli3hKTnFYwYjjX-m-64reArpktpaKHaBe0ab_ohAg"

    ];

// map hptcode => user login
$userList = [
    "11537" => ["user" => "CNTMQO", "password" => "123456"], //รพก
    "14641" => ["user" => "rppmqo", "password" => "123456"], //รพร    
    "11539" => ["user" => "TKSMQO", "password" => "123456"], // รพต
    "11541" => ["user" => "CKPMQO", "password" => "123456"], // รพจ
    // "25060" => ["user" => "bktmqo", "password" => "123456"], // รพข
    // "41582" => ["user" => "BNHMQO", "password" => "123456"], // รพบ
    // "41522" => ["user" => "KSWMQO", "password" => "123456"], // รพป
    // "11538" => ["user" => "LKBMQO", "password" => "123456"], // รพภ
    // "11540" => ["user" => "LPTMQO", "password" => "123456"], // รพท ???
    // "11536" => ["user" => "WKRMQO", "password" => "123456"], // รพว
    // "15049" => ["user" => "SRTMQO", "password" => "123456"], // รพส
];

// AES key (ต้อง 16 byte)
$privateKey = "@Abstract2023Abs";


// =========================
// FUNCTION: AES ENCRYPT (เหมือน Python)
// =========================
function data_encrypt($cleartext, $private_key) {
    $iv = str_repeat("\0", 16);
    $encrypted = openssl_encrypt(
        $cleartext,
        "AES-128-CBC",
        $private_key,
        OPENSSL_RAW_DATA,
        $iv
    );

    return base64_encode($encrypted);
}


// =========================
// VALIDATE hptcode
// =========================
$hptcode = $_GET['hptcode'] ?? '';

if (!isset($hptcodelist[$hptcode])) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid hptcode"]);
    exit();
}

$tokenhos = $hptcodelist[$hptcode];
$user = $userList[$hptcode];


// =========================
// STEP 1: ขอ Token
// =========================
$loginJson = json_encode($user, JSON_UNESCAPED_UNICODE);
$encryptedLogin = data_encrypt($loginJson, $privateKey);

$ch1 = curl_init();

curl_setopt_array($ch1, [
    CURLOPT_URL => "https://bmaapi.msdbangkok.go.th/wsQ/api/Token?hptcode=".$hptcode,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($encryptedLogin),
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "X-Access-Token: $tokenhos"
    ],
]);

$response1 = curl_exec($ch1);

if (curl_errno($ch1)) {
    http_response_code(500);
    echo curl_error($ch1);
    exit();
}

$result1 = json_decode($response1, true)['Result'] ?? null;
curl_close($ch1);

if (!$result1) {
    http_response_code(500);
    echo json_encode(["error" => "Token API failed"]);
    exit();
}


// =========================
// STEP 2: รับ body จาก frontend
// =========================
// $input = file_get_contents("php://input");

// ถ้า frontend ส่ง JSON ปกติ
// if ($input) {
//     $encryptedBody = data_encrypt($input, $privateKey);
// } else {
//     http_response_code(400);
//     echo json_encode(["error" => "No body data"]);
//     exit();
// }


// =========================
// STEP 3: เรียก API mqo
// =========================
$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => "https://bmaapi.msdbangkok.go.th/wsQ/api/mqo?hptcode=".$hptcode,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => '"Sf0C1IO0kFjJ0cpNMmf/SJg2k7yeHJwX2VhuRyuR4S0="',
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "X-Access-Token: $result1"
    ],
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    http_response_code(500);
    echo curl_error($ch);
    exit();
}

curl_close($ch);

// =========================
// RETURN TO FRONTEND
// =========================
echo $response;
