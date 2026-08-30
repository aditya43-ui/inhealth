<?php //include "menu2.php"; ?>

<h2>Langkah 3 - Install Database</h2>

<?php
  if ($_POST['submit']) 
  {
    $dbname = $_POST['db'];
	$dbuser = $_POST['username'];
	$dbpass = $_POST['password'];
	$dbhost = $_POST['localhost'];
	
	pg_connect($dbhost, $dbuser, $dbpass);
	$query = "DROP DATABASE IF EXISTS ".$dbname;
	$result = pg_exec($query);
	$query = "CREATE DATABASE ".$dbname;
	$result = pg_exec($query);
	
	if (!$result) {
    die('<b>Error: </b>' . mysql_error());
    }

    //$handle = @fopen("mysql-table.sql", "r");
    $handle = @fopen("pgsql.sql", "r");
	$content = fread($handle, filesize("pgsql.sql"));
	$split = explode(";", $content);
	
//	mysql_select_db($dbname);
	
	for ($i=0; $i<=count($split)-1; $i++)
	{
	  pg_exec($split[$i]);
    }

	fclose($handle);
	echo "<p>Database <b>\"".$dbname."\"</b> sudah berhasil dibuat</p>";
  }
?> 

<p>Masukkan konfigurasi koneksi PostGres!</p>

<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
<table>
 <tr>
     <td>LOCALHOST</td>
     <td>:</td>
     <td><input type="text" name="localhost"></td></tr>
 <tr><td>USERNAME</td><td>:</td><td><input type="text" name="username"></td></tr>
 <tr><td>PASSWORD</td><td>:</td><td><input type="password" name="password"></td></tr>
 <tr><td>NAMA DATABASE YG AKAN DIBUAT UNTUK GAMMU</td><td>:</td><td><input type="text" name="db"></td></tr>
 <tr><td></td><td></td><td><input type="submit" name="submit" value="INSTALL" class="btn btn-primary"></td></tr>
</table>

    <input type="hidden" name="step" value="3" readonly="readonly" />
</form>