<!-- resources/views/emails/otp_verification.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>OTP Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
        }

        h2 {
            color: #555;
        }

        h3 {
            color: #007bff;
        }

        p {
            color: #777;
        }

        .otp-code {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            font-size: 24px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>OTP Verification</h2>
        <p>Thank you for registering. Please use the following OTP code to verify your email address:</p>
        <div class="otp-code">{{ $otp }}</div>
        <p>If you did not initiate this registration, please ignore this email.</p>
    </div>
</body>
</html>
