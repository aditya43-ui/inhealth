<?php
$modBatas = SAFaktorhubdetM::model()->findAll('faktorhub_id=' . $faktorhub_id . '');
if (COUNT($modBatas) > 0) {
	echo "<ul>";
	foreach ($modBatas as $i => $batas) {
		echo "<li>" . $batas->faktorhubdet_indikator .' - '. (($batas->faktorhubdet_aktif == 1) ? "Aktif" : "Tidak Aktif"). '</li>';
	}
	echo "</ul>";
} else {
	echo Yii::t('zii', 'Not set');
}
?>

</tbody>
</table>