<table style="width: 100%;">
    <tr>
        <td width="20%">No. Rekam Medis</td>
        <td width="10%">:</td>
        <td><?php echo $modPendaftaran->pasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td width="20%">Nama</td>
        <td width="10%">:</td>
        <td><?php echo $modPendaftaran->pasien->nama_pasien; ?></td>
    </tr>
    <tr>
        <td>Tanggal Lahir</td>
        <td>:</td>
        <td><?php echo MyFormatter::formatDateTimeId($modPendaftaran->pasien->tanggal_lahir); ?></td>
    </tr>
</table>
<div class="form-actions">
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Print ', array('{icon}' => '<i class="entypo-print"></i>')),
        'javascript:void(0);',
        array('class' => 'btn btn-info', 'onclick' => "printLabelGelang();return false")
    );
    ?>
</div>

<script type="text/javascript">
    function printLabelGelang() {
        window.open('<?php echo $this->createUrl('printLabelGelang', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)); ?>', 'printwin', 'left=100,top=100,width=793,height=1122');
    }
</script>