<?php
session_start();
$userID = $_SESSION['userID'];

include 'src/autoload.php';

$config = [
    'callback' => 'https://jakubnilsson.000webhostapp.com/google_login.php',
    'providers' => [
        'Google' => [
            'enabled' => true,
            'keys' => [
                'key'    => '60613670394-cmh40bkrdaqu2jakfb8j0olldpa5vdkp.apps.googleusercontent.com',
                'secret' => 'Dlm3Nf0msxcz5LwesDDQwTqe',
                "scope"   => "https://www.googleapis.com/auth/plus.login ". // optional
                       "https://www.googleapis.com/auth/plus.me ". // optional
                       "https://www.googleapis.com/auth/plus.profile.emails.read", // optional
            ]
        ]
    ]
];

try{
    $hybridauth = new Hybridauth\Hybridauth($config);
    $adapter = $hybridauth->authenticate('Google');
    $isConnected = $adapter->isConnected();
    $userProfile = $adapter->getUserProfile();
    $adapter->disconnect();
    $researcherEmail = 'res@uni.se' ;
    $_SESSION['userID'] = $userID;
    define("USER_ID", $userID);
    echo "<p>Hello, ".$userProfile->firstName."! You are seeing this page the way you would if your email was ".$researcherEmail. "</p>";
}
catch(\Exception $e){
   // echo 'Oops, something went wrong! ' . $e->getMessage();
}
$db = new PDO('mysql:host=localhost;dbname=id3169691_pd_db', 'id3169691_admin', 'id3169691_pd_dbPaSS');
$sql = 'SELECT userID FROM User WHERE email = :researcherEmail';
$select = $db->prepare($sql);
$select->bindParam(':researcherEmail', $researcherEmail, PDO::PARAM_INT);
$select->execute();

$row = $select->fetch(PDO::FETCH_ASSOC);

$userID = $row['userID'];
