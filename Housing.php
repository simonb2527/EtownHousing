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
<h style = "font-size: 60px;" style = "color:blue;"> Housing Selection </h>

<form name = "LottoEntry" action = "" method = 'GET'>
    <submit name = "LottoEntry">
    <label> Sign in with Lottery Number:</label>
    <input type = text name = LottoEntry></input>
    <input type = "submit" name = "LotterySubmit"></input>
    </submit> 
    </form>
<?php 
$LotCheck;
if(isset($_GET["LottoEntry"])){
  $LotNum = $_GET["LottoEntry"];
  $_SESSION["LotNum"] = $LotNum;
  $sql = "SELECT * from Lottery where LottNum = $LotNum";
  $res = $con->query($sql);

  if($res == false) { 
    echo "Lottery Number invalid";
    ?>
    <meta http-equiv="Refresh" content="2; url=http://localhost/robo/src/housing.php">
    <?php
  } else   {
    echo "Lottery Number Valid";
    $LotCheck = 1;
  }
  
}
?>

<form name = "RoomSearch"  action = "" method = 'GET'>
<label for = "ResHall"> Search rooms from:</label>
<select name = "ResHall" id="ResHall">
  <option value =""> </option>
    <?php
//creates start of form, contents of form is created based on database values

   $sql = "SELECT * from ResHalls ";
   $result =  $con->query($sql);
    
   while($row = $result->fetch_array(MYSQLI_BOTH)){
    $hall = $row["Name"];
    //here the halls are found and new html options are created for each hall
    ?>
    <html>
    <option value = "<?php echo $hall ?>"> <?php echo $hall ?> </option>
    </html>
    <?php
   }
    ?>
</select>
<input type="submit" name = "submit" value = "Search"></input>
</form>
</html>

<?php
// new sql statement to get values of open rooms
//checks if sub value exists 

if(isset($_GET['ResHall'])){
$search = $_GET["ResHall"];
$prequery = "SELECT ResHallID from ResHalls where name = '$search'";
$search = $con->query($prequery);

while($row = $search->fetch_array(MYSQLI_BOTH)){
  $res = $row['ResHallID'];
}

$sql = "SELECT * from rooms where ResHallID = $res and LottoNum is Null";
$result = $con->query($sql);
//$row = $result->fetch_array(MYSQLI_BOTH);
//create table based on sql

?>
<html>
 <style>
table, th, td {
  border:1px solid black;
}
table{
  text-align: center;
}
</style>
 
  <table name= "table" style="width:100%">
  <tr>
    <th colspan = 3>Available Rooms </th>
  </tr>
    <?php
    $inc =0;
      while($row = $result->fetch_array(MYSQLI_BOTH)){
        $room = $row['roomNum'];
        $id = $row['roomID'];
        if($inc%3 ==0){
          // new row
          ?>
          <tr>
          </tr>
          <?php
        }
         ?>
         <td><?php echo "Room#:"; echo $room; echo"&nbsp&nbspID=$id"; ?></td>
         <?php
         $inc++;
      }
    ?>

  </table>
    <?php
    }
    
    ?>
      <form name = "RoomSelect" action = "" method = 'GET'>
      <submit name = "RoomSelect">
      <label> Enter RoomID:</label>
      <input type = text name = RoomSelect></input>
      <input type = submit name =RoomSubmit value = "Confirm"></input>
      </submit>
      </form>

    <?php
    $X = $_SESSION["LotNum"];
      if(isset($_GET["RoomSelect"])){
        $RID =$_GET["RoomSelect"];
        $sql = "UPDATE rooms SET LottoNum = $X where roomID = $RID ";
        $con->query($sql);
        echo "Success!";
      }
    ?>

  </html>