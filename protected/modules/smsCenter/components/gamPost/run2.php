<?php
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
 
$query = "SELECT * FROM inbox order by id desc";
$hasil = pg_exec($query);



echo "<table border='1'>";
echo "<tr><th>ReceivingDateTime</th><th>SenderNumber</th><th>TextDecoded</th><th>Phone ID</th></tr>";


while ($data = pg_fetch_array($hasil))
{
   echo "<tr><td>".$data[1]."</td><td>".$data[3]."</td><td>".$data[8]."</td><td>".$data[10]."</td></tr>";
}

echo "</table>";

?>