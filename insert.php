<?php
session_start();
$userID = $_SESSION['userID'];

try{
    $pdo = new PDO("mysql:host=localhost;dbname=id3169691_pd_db", "id3169691_admin", "id3169691_pd_dbPaSS");
  
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}

try{

    $sql = "INSERT INTO data_notes (dataID, dataNote, researcherID) VALUES (:dataID, :dataNote, :researcherID)";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindParam(':dataID', $_REQUEST['dataID']);
    $stmt->bindParam(':dataNote', $_REQUEST['dataNote']);
    $stmt->bindParam(':researcherID', $_REQUEST['researcherID']);
    
    $stmt->execute();
    echo "Records inserted successfully!";
} catch(PDOException $e){
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}
 
unset($pdo);
include 'content.php';
?>

