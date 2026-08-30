<table id="tblListPemeriksaanRad" class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>Tanggal Kirim Ke Radiologi</th>
            <th>No. Permintaan</th>
            <th>Permintaan Pemeriksaan</th>
            <th>Jumlah</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
<?php
foreach ($modRiwayatKirimKeUnitLain as $i => $riwayat) {
    $modPermintaan = PIPermintaanPenunjangT::model()->with('daftartindakan','pemeriksaanrad')->findAllByAttributes(array('pasienkirimkeunitlain_id'=>$riwayat->pasienkirimkeunitlain_id));
    ?>
    <tr>
        <td><?php echo $riwayat->tgl_kirimpasien; ?></td>
        <td><?php echo $riwayat->pasienkirimkeunitlain_id;?> <a href='' onclick="printPermintaan('<?php echo $riwayat->pasienkirimkeunitlain_id; ?>')"><i class="entypo-print"></i></a> </td>
        <td>
            <?php
            foreach($modPermintaan as $j => $permintaan){
                echo $permintaan->pemeriksaanrad->pemeriksaanrad_nama.'<br>';
            } ?>
        </td>
<!--<td>
            //<?php
//            foreach($modPermintaan as $j => $permintaan){
//                $modTarif = TariftindakanM::model()->findByAttributes(array('kelaspelayanan_id'=>$riwayat->kelaspelayanan_id,
//                                                                            'daftartindakan_id'=>$permintaan->pemeriksaanrad->daftartindakan_id,
//                                                                            'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
//                echo (!empty($modTarif->harga_tariftindakan))? number_format($modTarif->harga_tariftindakan).'<br>':'0 <br>';
//            } ?>
        </td>-->
        <td>
            <?php
            foreach($modPermintaan as $j => $permintaan){
                echo $permintaan->qtypermintaan.'<br>';
            } ?>
        </td>
        <td>
            <?php echo CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick'=>'batalRujukan('.$riwayat->pendaftaran_id.','.$riwayat->pasienkirimkeunitlain_id.',this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan kirim pasien')); ?>
			<?php // echo CHtml::link("<i class='icon-pencil'></i>", '#', array('onclick'=>'ubahPemeriksaan('.$riwayat->pendaftaran_id.','.$riwayat->pasienkirimkeunitlain_id.',this);return false;','rel'=>'tooltip','title'=>'Klik untuk ubah pemeriksaan pasien')); ?>
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
    </tbody>
</table>