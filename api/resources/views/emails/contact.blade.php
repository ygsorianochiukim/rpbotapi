<!DOCTYPE html>
<html>
<head>
    <title>Contact Message</title>
</head>
<body>
    <h3>New Message from {{ $details['name'] }}</h3>
    <p>Email: {{ $details['email'] }}</p>
    <p>Message: {{ $details['message'] }}</p>
</body>
</html>