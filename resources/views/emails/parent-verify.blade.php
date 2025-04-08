<!DOCTYPE html>
<html lang="en">
<head>
    <title>Email Verification</title>
</head>
<body>
    <h2>Hi {{ $parent->name }},</h2>
    <p>Thank you for registering. Please click the button below to verify your email:</p>
    <p>
        <a href="{{ $verificationLink }}" style="background-color: green; color: white; padding: 10px 15px; text-decoration: none;">
            Verify Email
        </a>
    </p>
    <p>This link will expire in 60 minutes.</p>
    <p>Best regards,<br>
        <strong> Formative Academic and Skill Development School</strong></p>
</body>
</html>
