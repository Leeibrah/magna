<?php
$myFile = "launch_emails.rtf";
$fh = fopen($myFile,'a') or die("can't open file");
$stringData = $_GET['email']."\n";
fwrite($fh, $stringData);
fclose($fh);
?>

<html>
<head>
    <title>VituMob: kila kitu kila siku</title>
    <meta charset='utf-8'>
    <link rel='stylesheet' href="static/vitumob.css">
</head>
<body>
<div id='header'>
    <img id='logo' src='images/logo.png'>
</div>

<div id='main'>

    <p style='font-size: larger; color: #027fc2'>Thank you. You will be notified when we launch.</p>

</div>

<div id='bottom-bar'>
    <span>&copy;2013 VituMob</span>
</div>

</body>

</html>

