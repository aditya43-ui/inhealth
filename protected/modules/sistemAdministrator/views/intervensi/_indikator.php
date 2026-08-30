<?php
$modBatas = SAIntervensidetM::model()->findAll('intervensi_id=' . $intervensi_id . '');
if (COUNT($modBatas) > 0) {
	echo "<ul>";
	foreach ($modBatas as $i => $batas) {
		echo "<li>" . $batas->intervensidet_indikator .' - '. (($batas->intervensidet_aktif == 1) ? "Aktif" : "Tidak Aktif"). '</li>';
	}
	echo "</ul>";
} else {
	echo Yii::t('zii', 'Not set');
}
?>

</tbody>
</table>