<?php
session_start();

include 'src/autoload.php';

$config = [
    'callback' => 'https://jakubnilsson.000webhostapp.com/linkedin_login.php',

    'providers' => [
        'LinkedIn' => [
            'enabled' => true,
            'keys' => [
                'key'    => '863cdohj8lbijq',
                'secret' => 'deTOVj5qz5N3gmED'
            ]
        ]
    ]
];

try{
    $hybridauth = new Hybridauth\Hybridauth($config);
    $adapter = $hybridauth->authenticate('LinkedIn');
    $isConnected = $adapter->isConnected();
    $userProfile = $adapter->getUserProfile();
    $adapter->disconnect();
    $patientEmail = 'x@gmail.com';
    echo "<p>Hello, ".$userProfile->firstName."! You are seeing this page the way you would if your email was ".$patientEmail. "</p>";

}


catch(\Exception $e){
    echo 'Oops, something went wrong! ' . $e->getMessage();
}
$servername = "localhost";
$username = "id3169691_admin";
$password = "id3169691_pd_dbPaSS";
$dbname = "id3169691_pd_db";

// Get userID from email
$db = new PDO('mysql:host=localhost;dbname=id3169691_pd_db', 'id3169691_admin', 'id3169691_pd_dbPaSS');
$sql = 'SELECT userID FROM User WHERE email = :patientEmail';
$select = $db->prepare($sql);
$select->bindParam(':patientEmail', $patientEmail, PDO::PARAM_INT);
$select->execute();

$row = $select->fetch(PDO::FETCH_ASSOC);

$userID = $row['userID'];

include 'patient_content.php';


//displays a list of exercise videos
echo '<iframe width="420" height="315"
src="https://www.youtube.com/embed/ZaVDs5DPnsA">
</iframe>';
echo '<iframe width="420" height="315"
src="https://www.youtube.com//embed/Ez2GeaMa4c8">
</iframe>';
echo '<iframe width="420" height="315"
src="https://www.youtube.com/embed/B1TIdGG4mE0">
</iframe>';
echo '<iframe width="420" height="315"
src="https://www.youtube.com/embed/KNWqyKluZgg">
</iframe>';
echo '<iframe width="420" height="315"
src="https://www.youtube.com/embed/7CFLm1SL5EU">
</iframe>';
echo '<iframe width="420" height="315"
src="https://www.youtube.com/embed/sYMctzPks0k">
</iframe>';