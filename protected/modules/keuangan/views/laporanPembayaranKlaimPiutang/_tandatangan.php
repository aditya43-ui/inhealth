<table style="width: 100%; border: none;">
    <tr>
        <td ></td>
		<td style="text-align: center;" width="180px"><?php echo Yii::app()->user->getState('kabupaten_nama').", ".MyFormatter::formatDateTimeForUser(date('d-m-Y'));?></td>
    </tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
    <tr>
        <td></td>
        <td style="text-align:center;">
            <?php echo Yii::app()->user->getState('nama_pegawai'); ?>
        </td>
    </tr>
</table>

