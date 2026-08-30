<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
if(!empty($modPersalinan)){
?>
<fieldset>
    <legend>Riwayat Persalinan <?php echo CHtml::checkBox('cekRiwayatPersalinan',false, array('onkeypress'=>"return $(this).focusNextInputField(event)")) ?></legend>
    <div id="divRiwayatPersalinan" class="control-group hide">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal Pendaftaran</th>
                    <th>Ruangan</th>
                    <th>No. Pendaftaran</th>
                    <th>Jenis Persalinan</th>
                    <th>Dokter</th>
                    <th>Lama Persalinan</th>
                    <th>Masa Gestasi / Paritas Ke</th>
                    <th>Bidan / Paramedis</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach($modPersalinan as $row){ ?>
                    <tr>
                        <td><?php echo $row->pendaftaran->tgl_pendaftaran; ?></td>
                        <td><?php echo $row->pendaftaran->ruangan->ruangan_nama; ?></td>
                        <td><?php echo $row->pendaftaran->no_pendaftaran; ?></td>
                        <td><?php echo $row->jeniskegiatanpersalinan; ?></td>
                        <td><?php echo $row->pegawai->nama_pegawai; ?></td>
                        <td><?php echo $row->lamapersalinan_jam; ?></td>
                        <td><?php echo $row->masagestasi_minggu; ?> Minggu<br><?php echo $format->formatNumberForUrutanText($row->paritaske); ?></td>
                        <td><?php echo $row->bidan->nama_pegawai; ?><br><?php echo $row->paramedis->nama_pegawai; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        </div>
</fieldset>
<?php
} else {
    Yii::app()->user->setFlash('error',"Tidak ada data riwayat persalinan pasien");
    $this->widget('bootstrap.widgets.BootAlert');
}

$js = <<< JS
$('#cekRiwayatPersalinan').change(function(){
        $('#divRiwayatPersalinan').slideToggle(500);
});

JS;
Yii::app()->clientScript->registerScript('JSriwayatPersalinan',$js,CClientScript::POS_READY);
?>
