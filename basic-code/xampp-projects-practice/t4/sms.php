
<?php
session_start();

$message = "";
$messageType = "";

// ===============================
// SEND OTP
// ===============================
if (isset($_POST['send_otp'])) {

    $number = trim($_POST['numbers']);

    // Basic Indian mobile number validation
    if (!preg_match('/^[6-9][0-9]{9}$/', $number)) {
        $message = "Please enter a valid 10-digit mobile number.";
        $messageType = "error";
    } else {

        // Generate 6 digit OTP
        $otp = random_int(100000, 999999);

        // Store OTP in session
        $_SESSION['otp'] = (string)$otp;
        $_SESSION['otp_number'] = $number;

        // OTP expiry: 5 minutes
        $_SESSION['otp_expiry'] = time() + 300;

        // SMS API
        $url = "https://blacksms.in/sms";

        $data = [
            "sender_id" => "640",
            "route" => "1",
            "variables_values" => $otp,
            "numbers" => $number
        ];

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            // Put your NEW API key here
            "Authorization:2a9f4f7779f3628fa036c0be5fff8fc7",
            "Content-Type: application/json"
        ]);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);

        if ($response === false) {
            $message = "SMS API error: " . curl_error($ch);
            $messageType = "error";
        } else {
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($httpCode >= 200 && $httpCode < 300) {
                $message = "OTP sent successfully to " . $number;
                $messageType = "success";
            } else {
                $message = "SMS API returned an error. HTTP Code: " . $httpCode;
                $messageType = "error";
            }
        }

        curl_close($ch);
    }
}


// ===============================
// VERIFY OTP
// ===============================
if (isset($_POST['verify_otp'])) {

    $enteredOtp = trim($_POST['otp']);

    if (!isset($_SESSION['otp'])) {

        $message = "Please request a new OTP.";
        $messageType = "error";

    } elseif (time() > $_SESSION['otp_expiry']) {

        // OTP expired
        unset(
            $_SESSION['otp'],
            $_SESSION['otp_number'],
            $_SESSION['otp_expiry']
        );

        $message = "OTP has expired. Please request a new OTP.";
        $messageType = "error";

    } elseif (hash_equals($_SESSION['otp'], $enteredOtp)) {

        // OTP correct
        unset(
            $_SESSION['otp'],
            $_SESSION['otp_number'],
            $_SESSION['otp_expiry']
        );

        $_SESSION['verified'] = true;

        $message = "OTP verified successfully!";
        $messageType = "success";

    } else {

        $message = "Invalid OTP. Please try again.";
        $messageType = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>OTP Verification</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 30px;
        }

        .container {
            max-width: 400px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }

        h1 {
            text-align: center;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            border: none;
            background: #007bff;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background: #0056b3;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 15px;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>OTP Verification</h1>

    <?php if ($message != ""): ?>

        <div class="<?php echo $messageType; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>

    <?php endif; ?>


    <!-- =========================
         SEND OTP FORM
         ========================= -->

    <form method="POST">

        <label for="numbers">
            Mobile Number
        </label>

        <input
            type="text"
            id="numbers"
            name="numbers"
            placeholder="Enter 10 digit mobile number"
            maxlength="10"
            value="<?php
                echo isset($_SESSION['otp_number'])
                    ? htmlspecialchars($_SESSION['otp_number'])
                    : '';
            ?>"
            required
        >

        <button type="submit" name="send_otp">
            Send OTP
        </button>

    </form>


    <!-- =========================
         VERIFY OTP FORM
         ========================= -->

    <?php if (isset($_SESSION['otp'])): ?>

        <hr>

        <form method="POST">

            <label for="otp">
                Enter OTP
            </label>

            <input
                type="text"
                id="otp"
                name="otp"
                placeholder="Enter 6 digit OTP"
                maxlength="6"
                required
            >

            <button type="submit" name="verify_otp">
                Verify OTP
            </button>

        </form>

    <?php endif; ?>

</div>

</body>
</html>

