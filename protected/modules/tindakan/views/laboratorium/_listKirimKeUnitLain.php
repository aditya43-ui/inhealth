<table id="tblListPemeriksaanLab" class="table table-bordered table-striped table-condensed">
    <thead>
        <tr>
            <th>Tanggal Kirim Ke Laboratorium</th>
            <th>No. Permintaan</th>
            <th>Permintaan Pemeriksaan</th>
            <th>Jumlah</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
<?php
foreach ($modRiwayatKirimKeUnitLain as $i => $riwayat) {
    $modPermintaan = RJPermintaanPenunjangT::model()->with('daftartindakan','pemeriksaanlab')->findAllByAttributes(array('pasienkirimkeunitlain_id'=>$riwayat->pasienkirimkeunitlain_id));
    ?>
    <tr>
        <td><?php echo MyFormatter::formatDateTimeForUser($riwayat->tgl_kirimpasien); ?></td>
        <td><?php echo $riwayat->pasienkirimkeunitlain_id;?> <a href='' onclick="printPermintaan('<?php echo $riwayat->pasienkirimkeunitlain_id; ?>')"><i class="entypo-print"></i></a> </td>
        <td>
            <?php
            foreach($modPermintaan as $j => $permintaan){
                $tindakan = null;
                if (!empty($permintaan->tindakanpelayanan_id)) {
                    $tindakan = TindakanpelayananT::model()->findByPk($permintaan->tindakanpelayanan_id);
                }
                
                echo strip_tags($permintaan->pemeriksaanlab->pemeriksaanlab_nama);
                
                if (!empty($tindakan) && $tindakan->tipepaket_id != Params::TIPEPAKET_ID_NONPAKET) {
                    $paket = TipepaketM::model()->findByPk($tindakan->tipepaket_id);
                    echo " (".$paket->tipepaket_nama.")";
                }
                
                echo '<br>';
            } ?>
        </td>
<!--<td>
            <?php
//            $temp_datartind = '';
//            foreach($modPermintaan as $j => $permintaan){
//                $daftartindakan_id = $permintaan->pemeriksaanlab->daftartindakan_id;
//                if($temp_datartind != $daftartindakan_id) {
//                    $modTarif = TariftindakanM::model()->findByAttributes(array('kelaspelayanan_id'=>$riwayat->kelaspelayanan_id,
//                                                                                'daftartindakan_id'=>$daftartindakan_id,
//                                                                                'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
//                    echo (!empty($modTarif->harga_tariftindakan))? number_format($modTarif->harga_tariftindakan).'<br>':'Belum ada tarif <br>';
//                }
//                $temp_datartind = $daftartindakan_id;
//            } ?>
        </td>-->
        <td>
            <?php
            foreach($modPermintaan as $j => $permintaan){
                echo $permintaan->qtypermintaan.'<br>';
            } ?>
        </td>
        <td>
            <?php echo CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick'=>'batalKirim('.$riwayat->pasienkirimkeunitlain_id.','.$riwayat->pendaftaran_id.');return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan kirim pasien', 'data-placement'=>'left')); ?>
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