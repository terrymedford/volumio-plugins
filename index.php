<?php

//Step1
 $db = mysqli_connect('192.168.1.86','paul','el24074pc','footy')
 or die('Error connecting to MySQL server.');
?>

<html>
 <head>
 <link rel="stylesheet" href="./style.css" />
 <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
 </head>
 <body OnLoad="document.getElementById('barcode').focus();">
 <body>
  <div id="top"></div>
 <div id="main">
  <div id ="header">
    Eclectic Stereo <small id="header_version">V2</small>
  
  <div id="scannerInput">
      <input id='barcode' name="barcode" placeholder="Barcode" />
  </div></div>
  
  <div id="Db_Entry">
    <form action="" method="post" action="index.php">
    <div id ="b_code">
      <label for="bcode">Barcode</label><br>
      <input id='bcode' name="bcode" /></div>
     
    <div id ="band_name">
     <label for="band">Band</label><br>
     <input id='band' type="text" name="band" /></div>
     
    <div id ="album_name">
     <label for="album">Album</label><br>
     <input id='album' type="text" name="album" />
    </div>
    <div id="send_Db">
     <input id ="Db_Button" name="submit" type="submit" value="Add To Db"/><br><br>
    </div>
   </form>
  
</div>
</div> 
<?php 
    $db = mysqli_connect('192.168.1.86','paul','el24074pc','footy')
    or die('Error connecting to MySQL server.');

    if(isset($_POST['submit'])){
             $band= $_POST['band'];
             $album = $_POST['album'];
             $bcode = $_POST['bcode'];
             $SQL = "INSERT INTO tbl_music (b_code, band, album) VALUES ('$bcode', '$band', '$album')";
             $result = mysqli_query($db, $SQL);
              header("location: index.php");}
?>


<script>
var timer;
var timeout = 1000;


$('#barcode').keydown(function(){
clearTimeout(timer);
if ($('#barcode').val) {
timer = setTimeout(function(){
//do stuff here e.g ajax call etc....
 var v = $('#barcode').val();
 console.log(v)
 var javascriptVariable = v;
 window.location.href = "index.php?name=" + javascriptVariable;


}, timeout);
}
})
</script>
 

<?php

//echo htmlspecialchars($_GET["name"]);
if(isset($_GET['name']) && $_GET['name']!="") {
$Barc = $_GET["name"];

//Step2
$query = "SELECT band,album FROM tbl_music WHERE b_code ='$Barc'";
mysqli_query($db, $query) or die('Error querying database.');

//Step3
$result = mysqli_query($db, $query);

while ($row = mysqli_fetch_array($result)) {
  $band = $row['band'];
 $album = $row['album'];
}

//Step 4
mysqli_close($db);

}


?>
<script>

var band_php = <?php echo json_encode($band); ?>;
var album_php = <?php echo json_encode($album); ?>;
console.log(band_php)
var bc = <?php echo json_encode($Barc); ?>;

if (band_php == null){
    var barc = document.getElementById('bcode');
    barc.value = bc;
  
   

}else{
   
    var barc = document.getElementById('bcode');
    barc.value = bc;
    var band_input = document.getElementById('band');
    band_input.value = band_php;
    var album_input = document.getElementById('album');
    album_input.value = album_php;
   
    var socket = io.connect("http://192.168.1.111:3000");
    var playme = `mnt/NAS/musicshare/${band_php}/${album_php}`;
    socket.emit("replaceAndPlay", {uri: playme, });
   



    


}

</script>


</body>
</html>

