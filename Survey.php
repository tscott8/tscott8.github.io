<html>
    <head>
        <link rel="stylesheet" type="text/css" href="Survey.css"/>  
    </head>
<body onunload="back_block()">

<?php

#Get Votes
function getVotes(){
$arrIn = array('q1'=>$_POST["q1"], 'q2'=>$_POST["q2"],'q3'=>$_POST["q3"],'q4'=>$_POST["q4"]);
    return $arrIn;

}

#Setup file.
function setupDB(){
    $q1 = array ('yes'=>0, 'no'=>1);
    $q2 = array ('lightRockAlt'=>1, 'hipHopPop'=>0, 'countryBlues'=>0,'rap'=>0,'hardRockMetal'=>0);
    $q3 = array ('snowboarding'=>1, 'mtnBiking'=>0, 'movies'=>0,'sleep'=>0,'code'=>0);
    $q4 = array ('cruise'=>0, 'mexico'=>0, 'disneyUniversal'=>0,'camp'=>0,'skiTrip'=>1);
    $arrOut = array ('q1'=>$q1,'q2'=>$q2,'q3'=>$q3,'q4'=>$q4);
    file_put_contents("polldb.json",json_encode($arrOut));
    $arrIn = json_decode(file_get_contents('polldb.json'), true);
    if($arrOut === $arrIn) {# => true
     echo "success";
 }
 else {
     echo "fail";
 }
}

#Load Saved Poll
function loadDB(){
    $check = file_exists("polldb.json");
    if($check == false){
        echo "File does not exist, creating now...<br>";
        setupDB();
    }
    else {
     echo "file exists!<br>";
     echo "loading polldb...<br>";
 }
#Load Saved Poll
 $arrIn = json_decode(file_get_contents('polldb.json'), true);
 return $arrIn;
}

function handleData($DBIn,$votes) {
#break up data
    $arrQ1 = $DBIn['q1'];
    $arrQ2 = $DBIn['q2'];
    $arrQ3 = $DBIn['q3'];
    $arrQ4 = $DBIn['q4'];
    
#testing to make sure it worked
/*echo $q1a . "<br>";
echo $q2a . "<br>";
echo $q3a . "<br>";
echo $q4a . "<br>";*/
    
#append new data
   switch($votes['q1']){
        case "yes":
            $arrQ1['yes']++;
            break;       
        case "no":
            $arrQ1['no']++;
            break;
    }

    switch($votes['q2']){
        case "lightRockAlt":
            $arrQ2['lightRockAlt']++;
            break;        
        case "hipHopPop":
            $arrQ2['hipHopPop']++;
            break;
        case "countryBlues":
            $arrQ2['countryBlues']++;
            break;
        case "rap":
            $arrQ2['rap']++;
            break;
        case "hardRockMetal":
            $arrQ2['hardRockMetal']++;
            break;
    }   
    switch($votes['q3']){
        case "snowboarding":
            $arrQ3['snowboarding']++;
            break;
        case "mtnBiking":
            $arrQ3['mtnBiking']++;
            break;
        case "movies":
            $arrQ3['movies']++;
            break;
        case "sleep":
            $arrQ3['sleep']++;
            break;
        case "code":
            $arrQ3['code']++;
            break;
    }
    switch($votes['q4']){
        case "cruise":
            $arrQ4['cruise']++;
            break;
        case "mexico":
            $arrQ4['mexico']++;
            break;
        case "disneyUniversal":
            $arrQ4['disneyUniversal']++;
            break;
        case "camp":
            $arrQ4['camp']++;
            break;
        case "skiTrip":
            $arrQ4['skiTrip']++;
            break;
    }
    $arrOut = array ('q1'=>$arrQ1,'q2'=>$arrQ2,'q3'=>$arrQ3,'q4'=>$arrQ4);
    return $arrOut;
}

#Update Poll
function updateDB($DBOut){
    file_put_contents("polldb.json",json_encode($DBOut));
#verify update
    $arrIn2 = json_decode(file_get_contents('polldb.json'), true);
if($DBOut === $arrIn2){ # => true
    echo "successfully updated";
}
else {
    echo "fail";
}
}

#calculate Percents
function calcPercents($arrOut){
$pY = round((($arrOut['q1']['yes'])/array_Sum($arrOut['q1']))*100,1);
$pN = round((($arrOut['q1']['no'])/array_Sum($arrOut['q1']))*100,1);
$q1p = array('pY'=>$pY,'pN'=>$pN);
    
$p1 = round((($arrOut['q2']['lightRockAlt'])/array_Sum($arrOut['q2']))*100,1);
$p2 = round((($arrOut['q2']['hipHopPop'])/array_Sum($arrOut['q2']))*100,1);
$p3 = round((($arrOut['q2']['countryBlues'])/array_Sum($arrOut['q2']))*100,1);
$p4 = round((($arrOut['q2']['rap'])/array_Sum($arrOut['q2']))*100,1);
$p5 = round((($arrOut['q2']['hardRockMetal'])/array_Sum($arrOut['q2']))*100,1);
$q2p = array('p1'=>$p1,'p2'=>$p2,'p3'=>$p3,'p4'=>$p4,'p5'=>$p5);
    
$p1b = round((($arrOut['q3']['snowboarding'])/array_Sum($arrOut['q3']))*100,1);
$p2b = round((($arrOut['q3']['mtnBiking'])/array_Sum($arrOut['q3']))*100,1);
$p3b = round((($arrOut['q3']['movies'])/array_Sum($arrOut['q3']))*100,1);
$p4b = round((($arrOut['q3']['sleep'])/array_Sum($arrOut['q3']))*100,1);
$p5b = round((($arrOut['q3']['code'])/array_Sum($arrOut['q3']))*100,1);
$q3p = array('p1'=>$p1b,'p2'=>$p2b,'p3'=>$p3b,'p4'=>$p4b,'p5'=>$p5b);
   
$p1c = round((($arrOut['q4']['cruise'])/array_Sum($arrOut['q4']))*100,1);
$p2c = round((($arrOut['q4']['mexico'])/array_Sum($arrOut['q4']))*100,1);
$p3c = round((($arrOut['q4']['disneyUniversal'])/array_Sum($arrOut['q4']))*100,1);
$p4c = round((($arrOut['q4']['camp'])/array_Sum($arrOut['q4']))*100,1);
$p5c = round((($arrOut['q4']['skiTrip'])/array_Sum($arrOut['q4']))*100,1);
$q4p = array('p1'=>$p1c,'p2'=>$p2c,'p3'=>$p3c,'p4'=>$p4c,'p5'=>$p5c);
     
$arrPercents = array('q1p'=>$q1p,'q2p'=>$q2p,'q3p'=>$q3p,'q4p'=>$q4p);
    return $arrPercents;
}

#Update WebPage
function display($percents){
    echo "<form class=\"webPoll\">
        <table class=\"center\"><tr><td><fieldset>";
    echo "<h4>1. Do you like Ilearn 3.0?</h4><ul><li>"
        .$percents['q1p']['pY']."% of people said yes</li><li>"
        .$percents['q1p']['pN']."% of people said no</li></ul>";
    echo "</fieldset></td></tr>";
   
    echo "<tr><td><fieldset>";
    echo "<h4>2. Musical tastes</h4><ul><li>"
        .$percents['q2p']['p1']."% Light Rock/Alternative</li><li>"
        .$percents['q2p']['p2']."% Hip Hop/Pop</li><li>"
        .$percents['q2p']['p3']."% Country/Blues</li><li>"
        .$percents['q2p']['p4']."% Rap</li><li>"
        .$percents['q2p']['p5']."% Hard Rock/Metal</li></ul>";
    echo "</fieldset></td></tr>";
    
    echo "<tr><td><fieldset>";
    echo "<h4>3. Hobby tastes</h4><ul><li>"
        .$percents['q3p']['p1']."% Snowboarding</li><li>"
        .$percents['q3p']['p2']."% Mountain Biking</li><li>"
        .$percents['q3p']['p3']."% Watching Movies</li><li>"
        .$percents['q3p']['p4']."% Sleeping</li><li>"
        .$percents['q3p']['p5']."% Programming</li></ul>";
     echo "</fieldset></td></tr>";
    
    echo "<tr><td><fieldset>";
    echo "<h4>4. Vacational tastes</h4><ul><li>"
        .$percents['q4p']['p1']."% Cruise</li><li>"
        .$percents['q4p']['p2']."% Mexico</li><li>"
        .$percents['q4p']['p3']."% Disneyland/Universal Studios</li><li>"
        .$percents['q4p']['p4']."% Camping</li><li>"
        .$percents['q4p']['p5']."% Cabin Ski Trip</li></ul>";
     echo "</fieldset></td></tr></table></form>";
}
if(isset($_POST["q1"])==true){
$votes = getVotes();
$DBIn = loadDB();
$DBOut = handleData($DBIn,$votes);
updateDB($DBOut);
}
else {
$DBOut = loadDB();
}
$percents = calcPercents($DBOut);
display($percents);
   
?>
</body>
</html>