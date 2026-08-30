<?php
/**
* - digunakan sebagai format dasar untuk memilih jenis format isian expertise  urologi
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

$hasilexpertise = explode("{{pisah}}",$model->hasilexpertise);

echo "<table class='noborder table'>";
// echo "<tr><td width='15%'>Ren Dextra :</td>";
echo "<tr><td></td>";
echo "<td>".(isset($hasilexpertise[0])?trim($hasilexpertise[0]):'').'</td></tr>';
// echo "<tr><td>Ren Sinistra :</td>";
echo "<tr><td></td>";
echo "<td>".(isset($hasilexpertise[1])?trim($hasilexpertise[1]):'').'</td></tr>';
// echo "<tr><td>Buli :</td>";
echo "<tr><td></td>";
echo "<td>".(isset($hasilexpertise[2])?trim($hasilexpertise[2]):'').'</td></tr>';
// echo echo "<tr><td>Prostat :</td>";
echo "<tr><td></td>";
echo "<td>".(isset($hasilexpertise[3])?trim($hasilexpertise[3]):'').'</td></tr>';
echo "</table>";
?>