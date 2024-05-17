<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset OTP Verification</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 700px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background-color: #6264a7;
            color: white;
            padding: 20px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .email-body {
            padding: 20px;
            color: #252424;
            background-color: #f4f4f4;
        }

        .otp-code {
            font-size: 24px;
            font-weight: bold;
            margin: 20px 0;
            padding: 10px;
            background-color: #e1dfdd;
            display: inline-block;
            border-radius: 4px;
        }

        .email-footer {
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #888888;
            background-color: #f4f4f4;
        }

        .email-footer a {
            color: #6264a7;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            BEO Predict Password Assistance
        </div>
        <div class="email-body">
            <p>Hello</p>
            <p>We received a request to reset the password for your BEO Predict account. To confirm this request and set a new password, please enter the following One-Time Password (OTP):</p>
            <div class="otp-code">{{$otp}}</div>
            <p>This OTP is valid for <strong>30 minutes</strong> and can only be used once. If you did not request a password reset, please disregard this email or contact us for support.</p>
            <p>If you have any questions or need further assistance, please contact our support team at <a href="mailto:[arteam@beo.in]">[arteam@beo.in]</a>.</p>
            <p>Thank you for using BEO Predict.</p>
        </div>
        <div class="email-footer">
            Warm regards,<br>
            <a href="
https://www.beopredict.com">
                BEO AR Team</a>
        </div>
    </div>
</body>

</html>