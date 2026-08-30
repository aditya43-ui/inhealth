<?php
$modImp = SAIndikatorimplkepdetM::model()->findAll('implementasikep_id=' . $implementasikep_id . '');
if (COUNT($modImp) > 0) {
	echo "<ul>";
	foreach ($modImp as $i => $imp) {
		echo "<li>" . $imp->indikatorimplkepdet_indikator .' - '. (($imp->indikatorimplkepdet_aktif == 1) ? "Aktif" : "Tidak Aktif"). '</li>';
	}
	echo "</ul>";
} else {
	echo Yii::t('zii', 'Not set');
}
?>

</tbody>
</table>