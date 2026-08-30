<?php
/**
* - digunakan sebagai format dasar untuk memilih jenis format isian expertise thorax
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

$hasilexpertise = explode("{{pisah}}",$model->hasilexpertise);

echo "<table class='noborder table'>";
echo "<tr><td width='15%'>Cor :</td>";
echo "<td>".(isset($hasilexpertise[0])?$hasilexpertise[0]:'').'</td></tr>';
echo "<tr><td>Pulomo :</td>";
echo "<td>".(isset($hasilexpertise[1])?$hasilexpertise[1]:'').'</td></tr>';
echo "</table>";
?>
