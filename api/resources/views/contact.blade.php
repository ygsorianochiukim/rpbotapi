<!DOCTYPE html>
<html>
<head>
    <title>Contact Message</title>
</head>
<body>
    <p>{{ $details['message'] }}</p>

    <p>Evaluation Result: </p>
    <div style="padding:10px;">
        <p style="margin:0px;">Care {{ $details['care'] }}</p>
        <p style="margin:0px;">Discipline {{ $details['discipline'] }}</p>
        <p style="margin:0px;">Mastery {{ $details['mastery'] }}</p>
    </div>
</body>
</html>