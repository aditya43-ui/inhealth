<?php
$modBatas = SAKriteriahasildetM::model()->findAll('kriteriahasil_id=' . $kriteriahasil_id . '');
if (COUNT($modBatas) > 0) {
	echo "<ul>";
	foreach ($modBatas as $i => $batas) {
		echo "<li>" . $batas->kriteriahasildet_indikator .' - '. (($batas->kriteriahasildet_aktif == 1) ? "Aktif" : "Tidak Aktif"). '</li>';
	}
	echo "</ul>";
} else {
	echo Yii::t('zii', 'Not set');
}
?>

</tbody>
</table>