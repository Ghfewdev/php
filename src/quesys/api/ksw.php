<?php

// =========================
// CORS
// =========================
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    http_response_code(403);
    exit;
}
else {
    $input = json_decode(file_get_contents("php://input"), true);
    $user = $input["user"] ?? null;
    $pass = $input["pass"] ?? null;
    if (!($user === "ksw" && $pass === "41522")) {
    echo json_encode([
        "status" => "error",
        "message" => "Missing data"
    ]);
    exit;
}

echo json_encode([
    "status" => "success",
    "data" => [
        "user" => $user,
        "pass" => $pass
    ]
]);
}

// if ($_SERVER["REQUEST_METHOD"] === "POST") {
//     $input = json_decode(file_get_contents("php://input"), true);

//     $user = $input["user"] ?? null;
//     $pass = $input["pass"] ?? null;

//     echo json_encode([
//         "status" => "success",
//         "received" => $input
//     ]);
// } else {
//     echo json_encode([
//         "status" => "error",
//         "message" => "Method not allowed"
//     ]);
// }

// =========================
// CONFIG
// =========================

// map hptcode => tokenhos
$hptcodelist = [
    "41522" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiI0MTUyMiIsImF1ZCI6IjU1NTU1In0.BDt8wRHxbYa0h1fyr7nXnHYyZefvcZ8eQcSJek1F2fU",
    ];

// map hptcode => user login
$userList = [
    "41522" => ["user" => "kswmqo", "password" => "123456"], // รพป
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
$hptcode = base64_decode('MTE1MzY=');

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
