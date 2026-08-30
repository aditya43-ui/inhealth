<?php
$modBatas = SABataskarakteristikdetM::model()->findAll('bataskarakteristik_id=' . $bataskarakteristik_id . '');
if (COUNT($modBatas) > 0) {
	echo "<ul>";
	foreach ($modBatas as $i => $batas) {
		echo "<li>" . $batas->bataskarakteristikdet_indikator .' - '. (($batas->bataskarakteristikdet_aktif == 1) ? "Aktif" : "Tidak Aktif"). '</li>';
	}
	echo "</ul>";
} else {
	echo Yii::t('zii', 'Not set');
}
?>

</tbody>
</table>