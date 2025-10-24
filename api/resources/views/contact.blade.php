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

    @if ($details['wpm'] != 0)
        <p style="margin:0px;">{{$details['applicant']}} provided with {{$details['wpm']}} WPM and {{$details['accuracy']}} Accuracy diring the Typing Test</p>
    @endif
    @if ($details['wpm'] == 0)
        <p style="margin:0px;">{{$details['applicant']}} did not take Typing Test</p>
    @endif
    @if ($details['score'] != 0)
        <p>{{$details['applicant']}} provided {{$details['score']}} Score in IQ Test</p>
    @endif
    @if ($details['score'] == 0)
        <p>{{$details['applicant']}} di not take IQ Test</p>
    @endif
    <a href="https://park.renaissance.ph/Interview/applicantPreview/{{$details['applicantID']}}" style="padding:10px 20px; background:rgb(54, 255, 255); text-decoration: none; border-radius: 50px; color:black; border-bottom:2px solid black;">Preview Application Summary</a>

    <p style="margin-top:30px;">Thank You.</p>
</body>
</html>