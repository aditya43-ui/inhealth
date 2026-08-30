<?php //include "menu2.php"; ?>

<h2>Langkah 1 - Setting GAMMURC</h2>

<?php
//echo  Yii::getPathOfAlias('application.modules.smsCenter.components.gamPost')."/gammurc";exit;
$handle = @fopen(Yii::getPathOfAlias('application.modules.smsCenter.components.gamPost')."/gammurc", "r");
$baris = array();
$i = 1;
$j = 1;
if ($handle) {
    while (!feof($handle)) {
        $buffer = fgets($handle);
        if (substr_count($buffer, 'port = ') > 0)
		{
		   if ($i == 1)
		   {
		      $split = explode("port = ", $buffer);
		      $port1 = str_replace(":", "", $split[1]);
		   }
		   
		   if ($i == 2)
		   {
		      $split = explode("port = ", $buffer);
		      $port2 = str_replace(":", "", $split[1]);
		   }
		   
		   if ($i == 3)
		   {
		      $split = explode("port = ", $buffer);
		      $port3 = str_replace(":", "", $split[1]);
		   }
		   
		   if ($i == 4)
		   {
		      $split = explode("port = ", $buffer);
		      $port4 = str_replace(":", "", $split[1]);
		   }
		   
		   $i++;
		}
		
		if (substr_count($buffer, 'connection = ') > 0)
		{
		   if ($j == 1)
		   {
 		      $split = explode("connection = ", $buffer);
		      $connection1 = $split[1];
		   }
		   
		   if ($j == 2)
		   {
 		      $split = explode("connection = ", $buffer);
		      $connection2 = $split[1];
		   }
		   
		   if ($j == 3)
		   {
 		      $split = explode("connection = ", $buffer);
		      $connection3 = $split[1];
		   }
		   
		   if ($j == 4)
		   {
 		      $split = explode("connection = ", $buffer);
		      $connection4 = $split[1];
		   }
		   
		   $j++;
		}
		
		$baris[] = $buffer; 
    }
    fclose($handle);

if ($_GET['op'] == "simpan")
{
  $port1 = $_POST['port1'];
  $connection1 = $_POST['connection1'];
  
  $port2 = $_POST['port2'];
  $connection2 = $_POST['connection2'];

  $port3 = $_POST['port3'];
  $connection3 = $_POST['connection3'];

  $port4 = $_POST['port4'];
  $connection4 = $_POST['connection4'];  
  
  $handle = @fopen(Yii::getPathOfAlias('application.modules.smsCenter.components.gamPost')."/gammurc", "w");

  $text = "[gammu]\nport = ".$port1."\nconnection = ".$connection1."\n[gammu1]\nport = ".$port2."\nconnection = ".$connection2."\n[gammu2]\nport = ".$port3."\nconnection = ".$connection3."\n[gammu3]\nport = ".$port4."\nconnection = ".$connection4;
  
  fwrite($handle, $text);
  fclose($handle); 
  echo "<p>Konfigurasi GAMMURC sudah disimpan</p>";  
}
    
} else {
    echo 'Tidak bisa membuka file gammurc';
}

?> 

<p>Masukkan nomor port dan jenis connection pada form di bawah ini!</p>

<p><b>Modem/HP 1</b></p>

<form method="post" action="<?php echo $this->createUrl('',array('op'=>'simpan')); ?>">
<table>
 <tr><td>PORT</td><td>:</td><td><input type="text" name="port1" value="<?php echo $port1;?>"></td></tr>
 <tr><td>CONNECTION</td><td>:</td><td><input type="text" name="connection1" value="<?php echo $connection1;?>"></td></tr>
</table>

<p><b>Modem/HP 2</b></p>

<table>
 <tr><td>PORT</td><td>:</td><td><input type="text" name="port2" value="<?php echo $port2;?>"></td></tr>
 <tr><td>CONNECTION</td><td>:</td><td><input type="text" name="connection2" value="<?php echo $connection2;?>"></td></tr>
</table>

<p><b>Modem/HP 3</b></p>

<table>
 <tr><td>PORT</td><td>:</td><td><input type="text" name="port3" value="<?php echo $port3;?>"></td></tr>
 <tr><td>CONNECTION</td><td>:</td><td><input type="text" name="connection3" value="<?php echo $connection3;?>"></td></tr>
</table>

<p><b>Modem/HP 4</b></p>

<table>
 <tr><td>PORT</td><td>:</td><td><input type="text" name="port4" value="<?php echo $port4;?>"></td></tr>
 <tr><td>CONNECTION</td><td>:</td><td><input type="text" name="connection4" value="<?php echo $connection4;?>"></td></tr>
</table>

<input type="hidden" name="step" value="1" readonly="readonly" />
<input type="submit" name="submit" value="Simpan" class="btn btn-primary">
</form>

<!--<a href="connection.xls">Lihat Jenis Connection</a>-->