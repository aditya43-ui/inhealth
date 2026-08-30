<table style="margin-top:20px;margin-left:auto;margin-right:auto;width:100%">
    <tr>
        <td width="80%">&nbsp;</td>
        <td><?php echo Yii::app()->user->getState('kabupaten_nama').", ".  MyFormatter::formatDateTimeForUser(date('d-m-Y'));?></td>
    </tr>
    <tr>
        <td>
            &nbsp;
        </td>
    </tr>
    <tr style="height: 100px; vertical-align: bottom;">
        <td></td>
        <td>
            <?php echo Yii::app()->user->getState('nama_pegawai'); ?>
        </td>
    </tr>
</table>

