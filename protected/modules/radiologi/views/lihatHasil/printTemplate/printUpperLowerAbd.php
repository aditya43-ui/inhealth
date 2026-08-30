<?php
/**
* - digunakan sebagai format dasar untuk memilih jenis format isian expertise  usg upper&lower
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

$hasilexpertise = explode("{{pisah}}",$model->hasilexpertise);

echo "<table class='noborder table'>";
echo "<tr><td width='15%'>Hepar :</td>";
echo "<td>".(isset($hasilexpertise[0])?$hasilexpertise[0]:'').'</td></tr>';
echo "<tr><td>Lien :</td>";
echo "<td>".(isset($hasilexpertise[1])?$hasilexpertise[1]:'').'</td></tr>';
echo "<tr><td>Pancreas :</td>";
echo "<td>".(isset($hasilexpertise[2])?$hasilexpertise[2]:'').'</td></tr>';
echo "<tr><td>GB :</td>";
echo "<td>".(isset($hasilexpertise[3])?$hasilexpertise[3]:'').'</td></tr>';
echo "<tr><td>Ren Dextra :</td>";
echo "<td>".(isset($hasilexpertise[4])?$hasilexpertise[4]:'').'</td></tr>';
echo "<tr><td>Ren Sinistra :</td>";
echo "<td>".(isset($hasilexpertise[5])?$hasilexpertise[5]:'').'</td></tr>';
echo "<tr><td>Buli :</td>";
echo "<td>".(isset($hasilexpertise[6])?$hasilexpertise[6]:'').'</td></tr>';
echo "<tr><td>Prostat :</td>";
echo "<td>".(isset($hasilexpertise[7])?$hasilexpertise[7]:'').'</td></tr>';
echo "</table>";
?>