<div style="margin: 0px;">

<table width="100%">
    <tr>
        <td width=100"">Dokter</td><td width="10">:</td>
        <td><?php 
        $peg = PegawaiM::model()->findByPk($model->pegawai_id);
        echo $peg->namaLengkap ?? "-";
        ?></td>
    </tr>
    <tr>
        <td>Tgl. Periksa</td><td>:</td>
        <td><?php echo MyFormatter::formatDateTimeForUser($model->tgl_catatantindakan); ?></td>
    </tr>
</table>
<hr/>

<?php echo $model->catatantindakan_detail; ?>

</div>
