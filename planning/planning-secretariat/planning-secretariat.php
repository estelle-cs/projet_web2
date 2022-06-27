<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MesDocs</title>
    <link rel="stylesheet" href="../Calendar.style.css">
    <link href="./planning-secretariat.css" rel="stylesheet">
</head>

<body>
    <select id="list-doc">
        <option>Test</option>
    </select>
    <div id="showcase-wrapper">
        <div id="myCalendarWrapper"></div>
        <div id="rdvDay">
            <div id="09" onclick="test(event)">09:00-09:45</div>
            <div id="10" onclick="test(event)">10:00-10:45</div>
            <div id="11" onclick="test(event)">11:00-11:45</div>
            <div id="12" onclick="test(event)">12:00-12:45</div>
            <div id="14" onclick="test(event)">14:00-14:45</div>
            <div id="15" onclick="test(event)">15:00-15:45</div>
            <div id="16" onclick="test(event)">16:00-16:45</div>
            <div id="17" onclick="test(event)">17:00-17:45</div>
            <div id="18" onclick="test(event)">18:00-18:45</div>
        </div>
    </div>
</body>

<script src="../Calendar.js"></script>
<script src="planning-secretariat-script.js"></script>

</html>
