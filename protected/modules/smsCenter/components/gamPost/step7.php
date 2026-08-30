<?php //include "menu2.php"; include "function.php"; ?>

<h2>Langkah 7 - Test Mengirim SMS</h2>


<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
<table>
<tr valign="top"><td><b>Masukkan No. HP Tujuan</b></td><td>:</td><td><input type="text" name="nohp"></td></tr>

<tr valign="top"><td><b>Masukkan isi SMS</b><br>(maksimum panjang SMS adalah 160 karakter)</td><td>:</td><td><textarea name="sms" rows="5" cols="40"></textarea></td></tr>

</table>
    
<input type="hidden" name="step" value="7" readonly="readonly" />
<input type="submit" name="submit" value="Kirim" class="btn btn-primary">
</form>

<?php


  if ($_POST['submit']) 
  {
  /*
   $nohp = $_POST['nohp'];
   $sms = $_POST['sms'];

   
   echo "<b>Status :</b><br>";
   echo "<pre>";
   passthru('gammu-smsd-inject -c  TEXT '.$nohp.' -text "'.$sms.'"');
   echo "</pre>";
*/

$nohp = $_POST['nohp'];
$sms = $_POST['sms'];

$handle = @fopen("smsdrc1", "r");
if ($handle) {
    while (!feof($handle)) {
        $buffer = fgets($handle);

		if (substr_count($buffer, 'user = ') > 0)
		{
		   $split = explode("user = ", $buffer);
		   $user = str_replace("\r\n", "", $split[1]);
		}
		
		if (substr_count($buffer, 'pc = ') > 0)
		{
		   $split = explode("pc = ", $buffer);
		   $host = str_replace("\r\n", "", $split[1]);
		}

		if (substr_count($buffer, 'password = ') > 0)
		{
		   $split = explode("password = ", $buffer);
		   $pass = str_replace("\r\n", "", $split[1]);
		}

		if (substr_count($buffer, 'database = ') > 0)
		{
		   $split = explode("database = ", $buffer);
		   $db = str_replace("\n", "", $split[1]);
		}
		
    }
    fclose($handle);
}

$conn_string = "host=$host port=5432 dbname=$db user=$user password=$pass";
$dbconn = pg_connect($conn_string);
$noTujuan = $_POST['nohp'];
$message = $_POST['msg'];
 
$query = "INSERT INTO outbox (DestinationNumber, TextDecoded, CreatorID) VALUES ('$nohp','$sms', 'Gammu')";
$hasil = pg_exec($query);






   }
 
 
 
 
?> 
