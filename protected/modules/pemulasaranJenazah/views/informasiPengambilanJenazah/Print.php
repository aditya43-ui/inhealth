<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:50%;
        color:black;
        padding-right:10px;
        font-size:8pt;
    }
    body{
        font-size:8pt;
    }
    td .uang{
        text-align:right;
    }
    .border{
        border:1px solid;
    }
');
if (!isset($_GET['frame'])) {
    echo $this->renderPartial('_headerPrint');
}
?>
<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" valig="middle" colspan="6">
            <b><?php echo $judulLaporan ?></b>
        </td>
    </tr>
    <tr>
        <td>Tanggal Meninggal</td>
        <td>:</td>
        <td><?php echo $format->formatDateTimeForUser($model->tglmeninggal); ?></td>

        <td>Tanggal Pengambilan Jenazah</td>
        <td>:</td>
        <td><?php echo $format->formatDateTimeForUser($model->tglpengambilan); ?></td>
    </tr>
    <tr>
        <td>No. Pendaftaran</td>
        <td>:</td>
        <td><?php echo $model->no_pendaftaran; ?></td>

        <td>Nama Pengambil</td>
        <td>:</td>
        <td><?php echo $model->nama_pengambiljenazah; ?></td>
    </tr>
    <tr>
        <td>No. Rekam Medik</td>
        <td>:</td>
        <td><?php echo $model->no_rekam_medik; ?></td>

        <td>Alamat Pengambil</td>
        <td>:</td>
        <td><?php echo $model->alamat_pengjenazah; ?></td>
    </tr>
    <tr>
        <td>Nama Jenazah</td>
        <td>:</td>
        <td><?php echo $model->nama_pasien; ?></td>

        <td>No. Telepon Pengambil</td>
        <td>:</td>
        <td><?php echo $model->notelepon_pengjenazah; ?></td>
    </tr>
</table><br>
<table class="table table-bordered table-condensed middle-center">
    <thead>
        <tr>
            <th>No.</th>
            <th>Jenis Jenazah</th>
            <th>Nama Jenazah</th>
            <th>Keadaan Jenazah</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($modDetails as $i => $jenazah) {
        ?>
            <tr>
                <td><?php echo ($i + 1); ?></td>
                <td><?php echo (isset($jenazah->jenisbarang_pasien) ? $jenazah->jenisbarang_pasien : "-"); ?></td>
                <td><?php echo (isset($jenazah->namabarang_pasien) ? $jenazah->namabarang_pasien : $model->nama_pasien); ?></td>
                <td><?php echo (isset($jenazah->keadaanbarang_pasien) ? $jenazah->keadaanbarang_pasien : "-"); ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php
if (isset($_GET['frame'])) {
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')"));
    echo CHtml::link(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('EXCEL')"));
?>
    <script type='text/javascript'>
        /**
         * print
         */
        function print(caraPrint) {
            id = '<?php echo isset($model->ambiljenazah_id) ? $model->ambiljenazah_id : ''; ?>';
            window.open('<?php echo $this->createUrl('print'); ?>&id=' + id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=640,height=480');
        }
    </script>
<?php
} else { ?>
    <table width="100%" style="margin-top:20px;">
        <tr>
            <td width="100%" align="left" align="top">
                <table style="width: 100%; border: none;">
                    <tr>
                        <td width="35%" align="center">
                            <div><br></div>
                            <div>Yang Mengambil,</div>
                            <div style="margin-top:60px;">( <?php echo $model->nama_pengambiljenazah; ?> )</div>
                        </td>
                        <td width="35%" align="center">
                        </td>
                        <td width="35%" align="center">
                            <div><?php echo Yii::app()->user->getState("kabupaten_nama") . ", " . MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
                            <div>Petugas</div>
                            <div style="margin-top:60px;"><?php echo Yii::app()->user->getState('nama_pegawai'); ?></div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
<?php }
