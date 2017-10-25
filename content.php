<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="plotly-latest.min.js"></script>
    </head>
    <body>
               
        <?php
$researcherEmail = 'res@uni.se' ;

define("DB_HOST", "localhost");
define("DB_USER", "id3217783_admin");
define("DB_PASS", "id3217783Pass");
define("DB_NAME", "id3217783_pd_db");

try {    
//PDO connection to the database
$db = new PDO('mysql:host=localhost;dbname=id3169691_pd_db', 'id3169691_admin', 'id3169691_pd_dbPaSS');
$sql = 'SELECT userID FROM User WHERE email = :researcherEmail';
$select = $db->prepare($sql);
$select->bindParam(':researcherEmail', $researcherEmail, PDO::PARAM_INT);
$select->execute();

$row = $select->fetch(PDO::FETCH_ASSOC);

$userID = $row['userID'];


$dbc = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset-utf8",DB_USER,DB_PASS);
}catch(PDOException $e){ echo $e->getMessage();}

if($dbc <> true){
    die("<p>Error!</p>");
    
}
$print = ""; 
//Select items that fit criteria from database, this time without WHERE clause
$stmt = $dbc->query("SELECT Therapy.*, Therapy.*, Test.*, Test_Session.*, Note.*
FROM Therapy
  LEFT JOIN Test
        ON Test.Therapy_IDtherapy = Therapy.therapyID
    LEFT JOIN Test_Session
        ON Test_Session.Test_IDtest = Test.testID
    LEFT JOIN Note
        ON Note.User_IDmed = Test_Session.Test_IDtest");
$stmt->setFetchMode(PDO::FETCH_OBJ);

if($stmt->execute() <> 0)
{

    $print .= '<table border="1px">';
    $print .= '<th>Patient ID</th>';
    $print .= '<th>Physician ID</th>';
    $print .= '<th>Therapy ID</th></th>';
    $print .= '<th>Test ID</th></th>';
    $print .= '<th>Test session ID</th></th>';
    $print .= '<th>Time/Date</th></th>';
    $print .= '<th>Data</th></th>';
    $print .= '<th>Note</th></th>';
    $print .= '<th>Test type</th></th>';


    while($names = $stmt->fetch()) // loop and display the items
    {

        $print .= '<tr>';
        $print .= "<td>{$names->User_IDpatient}</td>";
        $print .= "<td>{$names->User_IDmed}</td>";
        $print .= "<td>{$names->therapyID}</td>";
        $print .= "<td>{$names->testID}</td>";
        $print .= "<td>{$names->test_SessionID}</td>";
        $print .= "<td>{$names->dateTime}</td>";
         
        $print .= "<td> <form method='POST'>
                <input id='edit' type='button' name='action' value='$names->DataURL' onclick='makeplot(this.value);' />
                    </post>
               </td>"; 
        $print .= "<td>{$names->note}</td>"; 
        $print .= "<td>{$names->type}</td>";
        $print .= '</tr>';
        
    }   
    $print .= "</table>";
    echo $print;
}


?>
     <form action="insert.php" method="post">
  <h1>Add note to data:</h1>
    <p>
    <select name="dataID">
      <option value="Data1">Data1</option>
      <option value="Data2">Data2</option>
      <option value="Data3">Data3</option>
      <option value="Data4">Data4</option>
      <option value="Data5">Data5</option>
      <option value="Data6">Data6</option>
    </select>
        
        <label for="note">note</label>
        <input type="text" name="dataNote" id="dataNote">
    </p>
    <p>
        <label for="researcherID">Researcher ID:</label>
        <input type="text" value="<?= $userID ?>" name="researcherID" id="researcherID" readonly>
    </p>
    <input type="submit" value="Submit">

     <div id="myDiv" style="width: 480px; height: 400px;"> </div>
     <script>

     function makeplot(val) {
         
    //assign the result the value of (dataX - data)
    var result = val.substring(4);
    //execute different functions based on if result is odd or even
    if(result % 2 === 0)
    
    {
       

        Plotly.d3.csv(val+".csv", function(data){ processData2(data) } );
    }
    else{
    Plotly.d3.csv(val+".csv", function(data){ processData(data) } );
    
    }

}; 



function processData(allRows) {

  console.log(allRows);
  var x = [], y = [];

  for (var i=0; i<allRows.length; i++) {
    row = allRows[i];
    x.push( row['X'] );
    y.push( row['Y'] );
  }
  console.log( 'X',x, 'Y',y);
  makePlotly( x, y);
}

function processData2(allRows) {

  console.log(allRows);
  var x = [], y = [];

  for (var i=0; i<allRows.length; i++) {
    row = allRows[i];
    x.push( row['X'] );
    y.push( row['Y'] );
  }
  console.log( 'X',x, 'Y',y);
  makePlotly2( x, y);
}

function makePlotly( x, y ){
  var plotDiv = document.getElementById("plot");
  var traces = [{
    x: x,
    y: y,
    mode: 'lines',
    line: {
    color: 'rgb(25, 12, 18)',
    width: 3
  },
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

  Plotly.newPlot('myDiv', traces,
    {title: 'Spiral drawing result'});
};

function makePlotly2( x, y ){
  var plotDiv = document.getElementById("plot");
  var traces = [{
    x: x,
    y: y,
    mode: 'markers',
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

  Plotly.newPlot('myDiv', traces,
    {title: 'Tapping excercise results'});
};
  makeplot();


     </script>
  
        
    </body>
</html>
