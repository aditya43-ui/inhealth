<?php //include "menu2.php"; ?>

<h2>Langkah 6 - Menjalankan Service GAMMU</h2>

<p>Klik tombol di bawah ini untuk menjalankan GAMMU Service!</p>

<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
    
<input type="hidden" name="step" value="6" readonly="readonly" />
<input type="submit" name="submit" value="Jalankan Service Gammu" class="btn btn-primary"></td></tr>
</form>

<?php
  if ($_POST['submit']) 
  {
   echo "<b>Status :</b><br>";
   echo "<pre>";
   passthru("gammu-smsd -c smsdrc1 -n phone1 -s");
   passthru("gammu-smsd -c smsdrc2 -n phone2 -s");
   passthru("gammu-smsd -c smsdrc3 -n phone3 -s");
   passthru("gammu-smsd -c smsdrc4 -n phone4 -s");   
   echo "</pre>";
  }
?> 
