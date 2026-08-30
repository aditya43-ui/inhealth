<?php 
echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));
?>
<fieldset>
    <table class="items table table-striped table-condensed">
        <tr>
            <td>Tanggal Pembersihan</td>
            <td>:</td>
            <td><?php echo isset($model->tgl_pembersihan) ? MyFormatter::formatDateTimeForUser($model->tgl_pembersihan) : ""; ?></td>
        </tr>
        <tr>
            <td>Mulai Pembersihan</td>
            <td>:</td>
            <td><?php echo isset($model->mulaipembersiha) ? MyFormatter::formatDateTimeForUser($model->mulaipembersiha) : ""; ?></td>
        </tr>
        <tr>
            <td>Selesai Pembersihan</td>
            <td>:</td>
            <td><?php echo (isset($model->selesaipembersihan) ? MyFormatter::formatDateTimeForUser($model->selesaipembersihan) : ""); ?></td>
        </tr>
        <tr>
            <td>Status Pembersihan</td>
            <td>:</td>
            <td><?php echo isset($model->statuspembersihan) ? $model->statuspembersihan : ""; ?></td>
        </tr>
    </table><br>
</fieldset>