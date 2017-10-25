<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script src="plotly-latest.min.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    </head>
    <body>
    
        <?php
        
        
        try{
    $pdo = new PDO("mysql:host=localhost;dbname=id3169691_pd_db", "id3169691_admin", "id3169691_pd_dbPaSS");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}
 
// Table to hold data from XML file reached via provided API
try{
    // create prepared statement
    $sql = "DROP TABLE IF EXISTS temp_metadata;
        CREATE TABLE temp_metadata (
      `test_sessionID` int NOT NULL,
      `therapyID` int(10),
      `User_IDmed` varchar(10),
      `User_IDpatient` text,
      `medicineID` varchar(10),
      `therapy_listID` varchar(10),
      `testID` varchar(10),
      `test_datetime` varchar(10),
      `DataURL` varchar(10)
    )";
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute();
   
} catch(PDOException $e){
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}

    $db = new mysqli('localhost', 'id3169691_admin', 'id3169691_pd_dbPaSS', 'id3169691_pd_db');
     
     //work in progress, intended to use provided API to distribute requested data into table and output a .csv file
$completeurl = "http://vhost11.lnu.se:20090/final/getFilterData.php?parameter=User_IDpatient&value=3";
$xml = simplexml_load_string(file_get_contents($completeurl));

        
        $username = "id3169691_admin";
$password = "id3169691_pd_dbPaSS";
$hostname = "localhost"; 
        $dbname = "id3169691_pd_db";
$con=mysqli_connect("localhost",$username,$password);
if(!$con)
{
echo "could not connect" ;
}
else
{
//echo "connected";
}
        $fp = fopen('./csvfile.csv', 'w');


fputcsv($fp, array('metadata1','metadata2','metadata','metadata','metadata','time','metadata','metadata','metadata','metadata','metadata','metadata','metadata','metadata'));



try {
    $link = mysqli_connect("localhost",$username,$password,$dbname);

if (!$link) {
    die('Could not connect: ' . mysqli_error());
}
$rows = mysqli_query($link, "SELECT Therapy.*, Therapy.*, Test.*, Test_Session.*, Note.*
FROM Therapy
  LEFT JOIN Test
        ON Test.Therapy_IDtherapy = Therapy.therapyID
    LEFT JOIN Test_Session
        ON Test_Session.Test_IDtest = Test.testID
    LEFT JOIN Note
        ON Note.User_IDmed = Test_Session.Test_IDtest
    WHERE Therapy.User_IDpatient = $userID;
");

while ($row = mysqli_fetch_assoc($rows)) {
fputcsv($fp, $row);
}


fclose($fp); 
} catch (Exception $ex) {

}


?>


</form>
        
      
        

      <div id="myDiv2" style="width: 480px; height: 400px;"> </div>
      
     <script>
      

     function makeplot() {
    
  Plotly.d3.csv("csvfile.csv", function(data){ processData(data) } );
};

function processData(allRows) {

  console.log(allRows);
  var x = [], y = [];

  for (var i=0; i<allRows.length; i++) {
    row = allRows[i];
    x.push( row['time'] );
    y.push( row['time'] );
  }
  console.log( 'X',x, 'Y',y);
  makePlotly( x, y);
}

function makePlotly( x, y ){
  var plotDiv = document.getElementById("plot");
  var traces = [{
    x: x,
    y: y,
    mode: 'line',
  type: 'scatter'
	}]
	;
        
var layout = {
  xaxis: {
   // range: [ 0, 205 ]
  },
  yaxis: {
  //  range: [0, 70]
  },
  title:''
};

  Plotly.newPlot('myDiv2', traces,
    {title: 'Therapy session times:'});
};
  makeplot();
  
     </script>

     
       
        
    </body>
</html>
