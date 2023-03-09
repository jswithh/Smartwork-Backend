<!DOCTYPE html>
<html>

<head>
    <title>Welcome to My Website</title>
</head>

<body>
    <p>Dear {{ $email }},</p>
    <p>Welcome to My Website! Your account has been created successfully.</p>
    <p>Please use the following credentials to log in to your account:</p>
    <p>Email: {{ $email }}</p>
    <p>Password: {{ $password }}</p>
    <p>Thank you for registering with us!</p>

</body>

</html>
