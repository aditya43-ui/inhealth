<?php
$modBatas = SAFaktorrisikodetM::model()->findAll('faktorrisiko_id=' . $faktorrisiko_id . '');
if (COUNT($modBatas) > 0) {
	echo "<ul>";
	foreach ($modBatas as $i => $batas) {
		echo "<li>" . $batas->faktorrisikodet_indikator .' - '. (($batas->faktorrisikodet_aktif == 1) ? "Aktif" : "Tidak Aktif"). '</li>';
	}
	echo "</ul>";
} else {
	echo Yii::t('zii', 'Not set');
}
?>

</tbody>
</table>