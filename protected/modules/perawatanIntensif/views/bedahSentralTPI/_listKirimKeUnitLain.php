<table id="tblListRencanaOperasi" class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>Tanggal Kirim Ke Bedah Sentral</th>
            <th>Permintaan Operasi</th>
            <th>Tarif</th>
            <th>Jumlah</th>
            <th>Ruangan</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
<?php
foreach ($modRiwayatKirimKeUnitLain as $i => $riwayat) {
    $modPermintaan = PIPermintaanPenunjangT::model()->with('daftartindakan','operasi')->findAllByAttributes(array('pasienkirimkeunitlain_id'=>$riwayat->pasienkirimkeunitlain_id));
    ?>
    <tr>
        <td><?php echo $riwayat->tgl_kirimpasien; ?></td>
        <td>
            <?php
            foreach($modPermintaan as $j => $permintaan){
                echo $permintaan->operasi->operasi_nama.'<br>';
            } ?>
        </td>
        <td>
            <?php
            foreach($modPermintaan as $j => $permintaan){
                $modTarif = TariftindakanM::model()->findByAttributes(array('kelaspelayanan_id'=>$riwayat->kelaspelayanan_id,
                                                                            'daftartindakan_id'=>$permintaan->operasi->daftartindakan_id,
                                                                            'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
                echo (!empty($modTarif->harga_tariftindakan))? number_format($modTarif->harga_tariftindakan).'<br>':'0 <br>';
            } ?>
        </td>
        <td>
            <?php
            foreach($modPermintaan as $j => $permintaan){
                echo $permintaan->qtypermintaan.'<br>';
            } ?>
        </td>
        <td>
            <?php echo $riwayat->ruangan->ruangan_nama; ?>
        </td>
        <td>
            <?php echo CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick'=>'batalRujukan('.$riwayat->pendaftaran_id.','.$riwayat->pasienkirimkeunitlain_id.',this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan kirim pasien')); ?>
        </td>
    </tr>
    <?php
}
?>
    <tr id="trListKosong"><td colspan="5"><?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
        'type'=>'info', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'buttons'=>array(
            array('label'=>'Print', 'icon'=>'entypo-print', 'url'=>'#', 'htmlOptions'=>array('onclick'=>'printRiwayat(\'PRINT\')')),
            array('label'=>'', 'items'=>array(
                array('label'=>'PDF', 'icon'=>'icon-book', 'url'=>'', 'itemOptions'=>array('onclick'=>'printRiwayat(\'PDF\')')),
                array('label'=>'Excel','icon'=>'icon-pdf', 'url'=>'', 'itemOptions'=>array('onclick'=>'printRiwayat(\'EXCEL\')')),
               
            )),       
        ),
        'htmlOptions'=>array('style'=>'float:right')
//        'htmlOptions'=>array('class'=>'btn')
    )); ?></td></tr>
</table>
