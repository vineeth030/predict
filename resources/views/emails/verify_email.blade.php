
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 500px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 0;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #e0e0e0;
            overflow: hidden;
        }
        .email-header {
            background-color: #E2211C;
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .brand-title {
            font-size: 28px;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin: 0;
        }
        .email-body {
            padding: 40px 30px;
            text-align: center;
            color: #333333;
            line-height: 1.6;
        }
        .greeting {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .otp-box {
            background-color: #fdf2f2;
            border: 2px dashed #E2211C;
            border-radius: 6px;
            padding: 15px;
            margin: 30px auto;
            max-width: 200px;
        }
        .otp-code {
            font-size: 32px;
            font-weight: bold;
            color: #E2211C;
            letter-spacing: 4px;
        }
        .expiry-text {
            font-size: 13px;
            color: #666666;
            margin-top: 25px;
        }
        .support-link {
            color: #E2211C;
            text-decoration: none;
            font-weight: bold;
        }
        .email-footer {
            text-align: center;
            padding: 25px 20px;
            font-size: 12px;
            color: #888888;
            border-top: 1px solid #eeeeee;
            background-color: #fafafa;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1 class="brand-title">Predict</h1>
        </div>
        <div class="email-body">
            <p class="greeting">Hello,</p>
            <p>Thank you for registering with the Predict application. To complete your email verification process, please use the following One-Time Password (OTP):</p>
            
            <div class="otp-box">
                <div class="otp-code">{{ $otp }}</div>
            </div>
            
            <p class="expiry-text">Please note that this OTP is valid for <strong>30 minutes</strong> and is for one-time use only. If you did not initiate this request, please ignore this email or contact our support team immediately.</p>
            <p>For any assistance, feel free to reach out to us at <a href="mailto:arteam@beo.in" class="support-link">arteam@beo.in</a>.</p>
        </div>
        <div class="email-footer">
            Warm regards,<br>
            <strong>BEO AR Team</strong>
        </div>
    </div>
</body>
</html>
