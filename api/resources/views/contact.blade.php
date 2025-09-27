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
        <p>{{$details['applicant']}} provided with {{$details['wpm']}} WPM and {{$details['accuracy']}} Accuracy diring the Typing Test</p>
    @endif
    @if ($details['wpm'] == 0)
        <p>{{$details['applicant']}} did not take Typing Test</p>
    @endif
    @if ($details['score'] != 0)
        <p>{{$details['applicant']}} provided {{$details['score']}} Score in IQ Test</p>
    @endif
    @if ($details['score'] == 0)
        <p>{{$details['applicant']}} di not take IQ Test</p>
    @endif
</body>
</html>