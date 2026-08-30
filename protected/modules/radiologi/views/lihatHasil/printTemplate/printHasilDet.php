<?php
/**
* - digunakan sebagai format dasar untuk memilih jenis format isian expertise custom
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/


echo "<table class='noborder table'>";
foreach($hasDet as $det){
	echo "<tr><td width='15%'>".$det->refhasildet_nama." :</td>";
	echo "<td>".$det->hasperiksaraddet_expertise.'</td></tr>';
}
echo "</table>";
?>
