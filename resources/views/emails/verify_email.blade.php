<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>OTP Verification Email</title>
<style>
body {
font-family: Arial, sans-serif;
background-color: #f4f4f4;
margin: 0;
padding: 0;
}
.email-container {
max-width: 600px;
margin: 20px auto;
background-color: #ffffff;
padding: 20px;
border-radius: 5px;
box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
.email-header {
background-color: #94b1FF;
color: white;
padding: 10px;
text-align: center;
border-top-left-radius: 5px;
border-top-right-radius: 5px;
}
.email-body {
padding: 20px;
text-align: center;
}
.otp-code {
font-size: 24px;
font-weight: bold;
margin: 20px 0;
}
.email-footer {
text-align: center;
padding: 10px;
font-size: 12px;
color: #888888;
}
</style>
</head>
<body>
<div class="email-container">
<div class="email-header">
Predict Email Verification
</div>
<div class="email-body">
<p>Hello,</p>
<p>Thank you for registering with the Predict application. To complete your email verification process, please use the following One-Time Password (OTP):</p>
<div class="otp-code"><strong>{{ $otp }}</strong></div>
<p>Please note that this OTP is valid for <strong>30 minutes</strong> and is for one-time use only. If you did not initiate this request, please ignore this email or contact our support team immediately.</p>
<p>For any assistance, feel free to reach out to us at <a href="mailto:arteam@beo.in">arteam@beo.in</a>.</p>
<p>Thank you for choosing Predict.</p>
</div>
<div class="email-footer">
Warm regards,<br>
BEO AR Team
</div>
</div>
</body>
</html>