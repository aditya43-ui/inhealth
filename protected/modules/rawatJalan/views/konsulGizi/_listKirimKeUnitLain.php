<!--<legend class="rim">Tabel Riwayat Permintaan Konsultasi Gizi</legend>-->
<table id="tblListPemeriksaanRad" class="table table-bordered table-striped table-condensed">
    <thead>
        <tr>
            <th>Tanggal Permintaan Konsul</th>
            <th>No. Permintaan</th>
            <th>Permintaan Konsul Gizi</th>
            <th>Tarif</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
<?php
foreach ($modRiwayatKirimKeUnitLain as $i => $riwayat) {
    $modPermintaan = RJPermintaanPenunjangT::model()->with('daftartindakan')->findAllByAttributes(array('pasienkirimkeunitlain_id'=>$riwayat->pasienkirimkeunitlain_id));
    ?>
    <tr>
        <td>
            <?php
            foreach($modPermintaan as $j => $permintaan){
                echo $permintaan->tglpermintaankepenunjang.'<br>';
            } ?>
        </td>
        <td><?php echo $riwayat->pasienkirimkeunitlain_id;?> <a href='' onclick="printPermintaan('<?php echo $riwayat->pasienkirimkeunitlain_id; ?>')"><i class="entypo-print"></i></a> </td>
        <td>
            <?php
            foreach($modPermintaan as $j => $permintaan){
                echo $permintaan->daftartindakan->daftartindakan_nama.'<br>';
            } ?>
        </td>
        <td>
            <?php
            foreach($modPermintaan as $j => $permintaan){
                $modTarif = TariftindakanM::model()->findByAttributes(array('kelaspelayanan_id'=>$riwayat->kelaspelayanan_id,
                                                                            'daftartindakan_id'=>$permintaan->daftartindakan_id,
                                                                            'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
                echo (!empty($modTarif->harga_tariftindakan))? MyFormatter::formatNumberForPrint($modTarif->harga_tariftindakan).'<br>':'0 <br>';
            } ?>
        </td>
        <td>
            <?php 
                 $onclick = 'window.parent.myAlert("Tidak bisa dihapus karena hak akses tidak sesuai")';

                 $bisa_hapus = CustomFunction::hakAksesHapus(Yii::app()->user->getState('loginpemakai_id'), $riwayat->create_ruangan, $riwayat->create_loginpemakai_id);
 
                 if($bisa_hapus) {
                     $onclick = 'batalKirim('.$riwayat->pasienkirimkeunitlain_id.','.$riwayat->pendaftaran_id.');return false;';
                 }

                echo CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick'=>$onclick,'rel'=>'tooltip','title'=>'Klik untuk membatalkan kirim pasien')); ?>
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