<?php
// ============================================
// TEST FILE - Check Appwrite Connection
// ============================================

// Get environment variables
$endpoint = getenv('APPWRITE_ENDPOINT') ?: 'https://fra.cloud.appwrite.io/v1';
$projectId = getenv('APPWRITE_PROJECT_ID');
$apiKey = getenv('APPWRITE_API_KEY');
$databaseId = getenv('APPWRITE_DATABASE_ID');
$collectionId = getenv('APPWRITE_COLLECTION_ID');

echo "<h1>🔍 Appwrite Connection Test</h1>";

echo "<h2>Environment Variables:</h2>";
echo "Endpoint: " . ($endpoint ?: '❌ NOT SET') . "<br>";
echo "Project ID: " . ($projectId ?: '❌ NOT SET') . "<br>";
echo "API Key: " . ($apiKey ? substr($apiKey, 0, 10) . '...' : '❌ NOT SET') . "<br>";
echo "Database ID: " . ($databaseId ?: '❌ NOT SET') . "<br>";
echo "Collection ID: " . ($collectionId ?: '❌ NOT SET') . "<br>";

if (!$projectId || !$apiKey || !$databaseId || !$collectionId) {
    echo "<p style='color:red;'>❌ Missing environment variables! Check Render settings.</p>";
    exit;
}

// Try to fetch documents
$url = "$endpoint/databases/$databaseId/collections/$collectionId/documents";

echo "<h2>📤 Sending request to:</h2>";
echo "<code>$url</code><br><br>";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'X-Appwrite-Project: ' . $projectId,
    'X-Appwrite-Key: ' . $apiKey
]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "<h2>📥 Response:</h2>";
echo "HTTP Code: $httpCode<br>";

if ($response) {
    echo "<pre style='background:#f0f0f0;padding:15px;border-radius:5px;overflow:auto;max-height:300px;'>";
    echo htmlspecialchars($response);
    echo "</pre>";
} else {
    echo "<p style='color:red;'>❌ No response. Error: $error</p>";
}
?>
