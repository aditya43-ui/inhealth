<?php
$modBatas = SAAlternatifdxM::model()->findAll('diagnosakep_id=' . $diagnosakep_id . '');
if (count((array)$modBatas) > 0) {
	echo "<ul>";
	foreach ($modBatas as $i => $batas) {
		echo "<li>" . $batas->alternatifdx_nama .' - '. (($batas->alternatifdx_aktif == 1) ? "Aktif" : "Tidak Aktif"). '</li>';
	}
	echo "</ul>";
} else {
	echo Yii::t('zii', 'Not set');
}
?>

</tbody>
</table>