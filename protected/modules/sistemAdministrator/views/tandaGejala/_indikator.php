<?php
$modBatas = SATandagejalaM::model()->findAll('diagnosakep_id=' . $diagnosakep_id . '');
if (COUNT($modBatas) > 0) {
	echo "<ul>";
	foreach ($modBatas as $i => $batas) {
		echo "<li>" . $batas->tandagejala_indikator .' - '. (($batas->tandagejala_aktif == 1) ? "Aktif" : "Tidak Aktif"). '</li>';
	}
	echo "</ul>";
} else {
	echo Yii::t('zii', 'Not set');
}
?>

</tbody>
</table>