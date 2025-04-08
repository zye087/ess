<!DOCTYPE html>
<html lang="en">
<head>
    <title>Account Activation</title>
</head>
<body>
    <h2>Hi {{ $parent->name }},</h2>
    <p>We’re excited to let you know that your account is now <strong>active</strong>! 🎉</p>
    <p>You can now log in and start using the portal.</p>
    <p>
        <a href="{{ $portalLink }}" style="background-color: green; color: white; padding: 10px 15px; text-decoration: none;">
            Go to Portal
        </a>
    </p>
    <p>If you have any questions, feel free to reach out.</p>
    <p>Best regards,<br>
    <strong> Formative Academic and Skill Development School</strong></p>
</body>
</html>
