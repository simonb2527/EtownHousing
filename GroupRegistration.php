<?php
session_start();
$host = "156.67.74.51";
$user= "u413142534_robots";
$pass= "R0b0tsRul3";
$dbname = "u413142534_jaysnest";

  $con = new mysqli($host, $user, $pass, $dbname);

   if ($con->connect_error) {
      die("Connection failed: " . $con->connect_error);
    }
?>

<html>
<h style = "font-size: 60px">Group Registration</h>
<head>
<script type="text/javascript">
  function Reveal(it, box) {
    var vis = (box.checked) ? "block" : "none";
    document.getElementById(it).style.display = vis;
  }

  function Hide(it, box) {
    var vis = (box.checked) ? "none" : "none";
    document.getElementById(it).style.display = vis;
  }
</script>
</head>

<?php
if(($_POST['name1'] == "" || $_POST['studentID1'] == "" || $_POST['name2'] == "" || $_POST['studentID2'] == "") &&
   ($_POST['ILUname1'] == "" || $_POST['ILUstudentID1'] == "" || $_POST['ILUname2'] == "" || $_POST['ILUstudentID2'] == "" ||
   $_POST['ILUname3'] == "" || $_POST['ILUstudentID3'] == "" || $_POST['ILUname4'] == "" || $_POST['ILUstudentID4'] == "")){
?>
  <body>
  <form  style = "font-size: 24px;">
    <label class = "radiobox"><input type="radio" name="mype" value="ve1" style="height:18px; width:16px;" onClick="Hide('div2', this); Reveal('didfv1', this)"/>Residence hall</label>
      <br>
    <label class = "radiobox"><input type="radio" name="mype" value="value2" style="height:18px; width:16px;" onClick="Hide('didfv1', this); Reveal('div2', this)"/>ILU</label>
   </form>

<form name = "RoomSearch"  action = "" method = 'POST'>
  <div class="row" id="didfv1" style="display: none">
   
   <label for="name1" class = "box">Name</label>
   <input type="text" name ="name1" class = "box">

   <label for="studentID1" class = "box">Student ID</label>
   <input type="text" name ="studentID1" class = "box">

   <br><br>
   
   <label for="name2" class = "box">Name</label>
   <input type="text" name ="name2" class = "box">

   <label for="studentID2" class = "box">Student ID</label>
   <input type="text" name ="studentID2" class = "box">

   <br><br>

   <input type="submit" value="submit" style = "font-size: 18px;">

  </div>

  <div class="row" id="div2" style="display: none">

   <label for="name1" class = "box">Name</label>
   <input type="text" name ="ILUname1" class = "box">

   <label for="studentID1" class = "box">Student ID</label>
   <input type="text" name ="ILUstudentID1" class = "box">

   <br><br>
   
   <label for="name2" class = "box">Name</label>
   <input type="text" name ="ILUname2" class = "box">

   <label for="studentID2" class = "box">Student ID</label>
   <input type="text" name ="ILUstudentID2" class = "box">

   <br><br>

   <label for="name3" class = "box">Name</label>
   <input type="text" name ="ILUname3" class = "box">

   <label for="studentID3" class = "box">Student ID</label>
   <input type="text" name ="ILUstudentID3" class = "box">

   <br><br>
   
   <label for="name4" class = "box">Name</label>
   <input type="text" name ="ILUname4" class = "box">

   <label for="studentID4" class = "box">Student ID</label>
   <input type="text" name ="ILUstudentID4" class = "box">

   <br><br>

   <input type="submit" name = "submit" style = "font-size: 18px;" value = "submit"></input>
   </form>

  </div>
  </body>
</html>
<?php
}
?>
<br>
</html>

<?php

if($_POST['name1'] != "" && $_POST['studentID1'] != "" && $_POST['name2'] != "" && $_POST['studentID2'] != ""){

  $name1 = $_POST['name1'];
  $studentID1 = $_POST['studentID1'];
  $name2 = $_POST['name2'];
  $studentID2 = $_POST['studentID2'];

  echo "<br>Name: ".$name1." StudentID: ".$studentID1."<br>";
  echo "Name: ".$name2." StudentID: ".$studentID2."<br><br>";

  $sID1 = intval($studentID1);
  $sID2 = intval($studentID2);

  $sqlgpa = "SELECT gpa from student where ID = $sID1";
  $gpa = $con->query($sqlgpa);

  while($row = $gpa->fetch_array(MYSQLI_BOTH)){
    $gpa1 = $row['gpa'];
  }

  $sqlgpa = "SELECT gpa from student where ID = $sID2";
  $gpa = $con->query($sqlgpa);

  while($row = $gpa->fetch_array(MYSQLI_BOTH)){
    $gpa2 = $row['gpa'];
  }

  $avggpa = ($gpa1 + $gpa2) / 2;

  //echo "<br>Average GPA: ".number_format((float)$avggpa, 3, '.', '');

  if($avggpa != 0){

  if($avggpa > 3.5){//if avggpa > 3.5, 1 < lotNum < 200 
    $lotNum = mt_rand(1, 200);
  }
  elseif($avggpa > 3.0){//elseif avg > 3.0, 200 < lotNum < 400
    $lotNum = mt_rand(200, 400);
  }
  elseif($avggpa > 2.5){//elseif avg > 2.5, 400 < lotNum < 600
    $lotNum = mt_rand(400, 600);
  }
  elseif($avggpa > 2.0){//else if avg > 2.0, 600 < lotNum < 800
    $lotNum = mt_rand(600, 800);
  }
  else{//esle, 800 < lotNUm < 1000
    $lotNum = mt_rand(800, 1000);
  }

  echo "<br><div style = \"font-size: 20px; color:red;\">Lottery Number: ".$lotNum."<div>";

  $sqllot1 = "SELECT * from Lottery where StudentID = $studentID1";
  $lot1 = $con->query($sqllot1);

  $sqllot2 = "SELECT * from Lottery where studentID = $studentID2";
  $lot2 = $con->query($sqllot2);

  $sqlLotteryInsert = $con->prepare("INSERT INTO Lottery (StudentID, LottNum) VALUES (?, $lotNum);");
  $sqlLotteryUpdate = $con->prepare("UPDATE Lottery SET LottNum = $lotNum WHERE StudentID = ?;");
  if($lot1->num_rows > 0){
    $sqlLotteryUpdate->bind_param("s", $studentID1);
    $sqlLotteryUpdate->execute();
  }
  else{
    $sqlLotteryInsert->bind_param("s", $studentID1);
    $sqlLotteryInsert->execute();
  }

  if($lot2->num_rows > 0){
    $sqlLotteryUpdate->bind_param("s", $studentID2);
    $sqlLotteryUpdate->execute();
  }
  else{
    $sqlLotteryInsert->bind_param("s", $studentID2);
    $sqlLotteryInsert->execute();
  }

  $sqlLotteryUpdate->close();
  $sqlLotteryInsert->close();

  $sqlStudent = $con->prepare("UPDATE student SET LotteryNum = $lotNum WHERE ID = ?;");
  $sqlStudent->bind_param("s", $studentID1);
  $sqlStudent->execute();
  $sqlStudent->bind_param("s", $studentID2);
  $sqlStudent->execute();
  $sqlStudent->close();
  
  $conn->close();
}
else {
  echo "<br>Invalid StudentID";
}

}

if($_POST['ILUname1'] != "" && $_POST['ILUstudentID1'] != "" && $_POST['ILUname2'] != "" && $_POST['ILUstudentID2'] != "" &&
   $_POST['ILUname3'] != "" && $_POST['ILUstudentID3'] != "" && $_POST['ILUname4'] != "" && $_POST['ILUstudentID4'] != ""){

  $ILUname1 = $_POST['ILUname1'];
  $ILUstudentID1 = $_POST['ILUstudentID1'];
  $ILUname2 = $_POST['ILUname2'];
  $ILUstudentID2 = $_POST['ILUstudentID2'];
  $ILUname3 = $_POST['ILUname3'];
  $ILUstudentID3 = $_POST['ILUstudentID3'];
  $ILUname4 = $_POST['ILUname4'];
  $ILUstudentID4 = $_POST['ILUstudentID4'];
 
  echo "Name: ".$ILUname1." StudentID: ".$ILUstudentID1."<br>";
  echo "Name: ".$ILUname2." StudentID: ".$ILUstudentID2."<br>";
  echo "Name: ".$ILUname3." StudentID: ".$ILUstudentID3."<br>";
  echo "Name: ".$ILUname4." StudentID: ".$ILUstudentID4."<br><br>";

  $sID1 = intval($ILUstudentID1);
  $sID2 = intval($ILUstudentID2);
  $sID3 = intval($ILUstudentID3);
  $sID4 = intval($ILUstudentID4);
 
  $sqlgpa = "SELECT gpa from student where ID = $sID1";
  $gpa = $con->query($sqlgpa);
 
 
  while($row = $gpa->fetch_array(MYSQLI_BOTH)){
    $gpa1 = $row['gpa'];
  }
 
  $sqlgpa = "SELECT gpa from student where ID = $sID2";
  $gpa = $con->query($sqlgpa);
 
 
  while($row = $gpa->fetch_array(MYSQLI_BOTH)){
    $gpa2 = $row['gpa'];
  }

  $sqlgpa = "SELECT gpa from student where ID = $sID3";
  $gpa = $con->query($sqlgpa);
 
 
  while($row = $gpa->fetch_array(MYSQLI_BOTH)){
    $gpa3 = $row['gpa'];
  }

  $sqlgpa = "SELECT gpa from student where ID = $sID4";
  $gpa = $con->query($sqlgpa);
 
  while($row = $gpa->fetch_array(MYSQLI_BOTH)){
    $gpa4 = $row['gpa'];
  }
 
  $avggpa = ($gpa1 + $gpa2 + $gpa3 + $gpa4) / 4;

  //echo "<br>Average GPA: ".number_format((float)$avggpa, 3, '.', '');

  if($avggpa != 0){

  if($avggpa > 3.5){//if avggpa > 3.5, 1 < lotNum < 200 
    $lotNum = mt_rand(1, 200);
  }
  elseif($avggpa > 3.0){//elseif avg > 3.0, 200 < lotNum < 400
    $lotNum = mt_rand(200, 400);
  }
  elseif($avggpa > 2.5){//elseif avg > 2.5, 400 < lotNum < 600
    $lotNum = mt_rand(400, 600);
  }
  elseif($avggpa > 2.0){//else if avg > 2.0, 600 < lotNum < 800
    $lotNum = mt_rand(600, 800);
  }
  else{//esle, 800 < lotNUm < 1000
    $lotNum = mt_rand(800, 1000);
  }
 
  echo "<br><div style = \"font-size: 20px; color:red;\">Lottery Number: ".$lotNum."<div>";

  $sqllot1 = "SELECT * from Lottery where StudentID = $ILUstudentID1";
  $lot1 = $con->query($sqllot1);

  $sqllot2 = "SELECT * from Lottery where studentID = $ILUstudentID2";
  $lot2 = $con->query($sqllot2);

  $sqllot3 = "SELECT * from Lottery where StudentID = $ILUstudentID3";
  $lot3 = $con->query($sqllot3);

  $sqllot4 = "SELECT * from Lottery where studentID = $ILUstudentID4";
  $lot4 = $con->query($sqllot4);

  $sqlLotteryInsert = $con->prepare("INSERT INTO Lottery (StudentID, LottNum) VALUES (?, $lotNum);");
  $sqlLotteryUpdate = $con->prepare("UPDATE Lottery SET LottNum = $lotNum WHERE StudentID = ?;");
  if($lot1->num_rows > 0){
    $sqlLotteryUpdate->bind_param("s", $ILUstudentID1);
    $sqlLotteryUpdate->execute();
  }
  else{
    $sqlLotteryInsert->bind_param("s", $ILUstudentID1);
    $sqlLotteryInsert->execute();
  }

  if($lot2->num_rows > 0){
    $sqlLotteryUpdate->bind_param("s", $ILUstudentID2);
    $sqlLotteryUpdate->execute();
  }
  else{
    $sqlLotteryInsert->bind_param("s", $ILUstudentID2);
    $sqlLotteryInsert->execute();
  }

  if($lot3->num_rows > 0){
    $sqlLotteryUpdate->bind_param("s", $ILUstudentID3);
    $sqlLotteryUpdate->execute();
  }
  else{
    $sqlLotteryInsert->bind_param("s", $ILUstudentID3);
    $sqlLotteryInsert->execute();
  }

  if($lot4->num_rows > 0){
    $sqlLotteryUpdate->bind_param("s", $ILUstudentID4);
    $sqlLotteryUpdate->execute();
  }
  else{
    $sqlLotteryInsert->bind_param("s", $ILUstudentID4);
    $sqlLotteryInsert->execute();
  }

  $sqlLotteryUpdate->close();
  $sqlLotteryInsert->close();

  $sqlStudent = $con->prepare("UPDATE student SET LotteryNum = $lotNum WHERE ID = ?;");
  $sqlStudent->bind_param("s", $ILUstudentID1);
  $sqlStudent->execute();
  $sqlStudent->bind_param("s", $ILUstudentID2);
  $sqlStudent->execute();
  $sqlStudent->bind_param("s", $ILUstudentID3);
  $sqlStudent->execute();
  $sqlStudent->bind_param("s", $ILUstudentID4);
  $sqlStudent->execute();

  $sqlStudent->close();

  $conn->close();
  }
  else {
    echo "<br>Invalid StudentID";
  }
 
}

?>

<style>
  
  .radiobox:hover{
    text-decoration: underline;
    color:blue;
  }

  .box{
    font-size: 18px;
  }
</style>