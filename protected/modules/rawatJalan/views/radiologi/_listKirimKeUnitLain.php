<?php

$modul_login = Yii::app()->user->getState('modul_id');
$modul_hide = [6, 7, 72];

$hide_edit = in_array($modul_login, $modul_hide) ? "hidden" : "";

?>

<table class="table table-bordered table-striped table-condensed" id="tblListPemeriksaanRad">
    <thead>
        <tr>
            <th>Tanggal Kirim Ke Radiologi</th>
            <th>No. Permintaan</th>
            <th>Permintaan Pemeriksaan</th>
            <th>Jumlah</th>
            <th <?=$hide_edit?>>Ubah</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($modRiwayatKirimKeUnitLain as $i => $riwayat) {
        $modPermintaan = RJPermintaanPenunjangT::model()->with('daftartindakan','pemeriksaanrad')->findAllByAttributes(array('pasienkirimkeunitlain_id'=>$riwayat->pasienkirimkeunitlain_id));
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
                    
                    echo $permintaan->pemeriksaanrad->pemeriksaanrad_nama;
                    
                    if (!empty($tindakan) && $tindakan->tipepaket_id != Params::TIPEPAKET_ID_NONPAKET) {
                        $paket = TipepaketM::model()->findByPk($tindakan->tipepaket_id);
                        echo " (".$paket->tipepaket_nama.")";
                    }
                    
                    echo '<br>';
                } ?>
            </td>
            <td>
                <?php
                foreach($modPermintaan as $j => $permintaan){
                    echo $permintaan->qtypermintaan.'<br>';
                } ?>
            </td>
            <td  <?=$hide_edit?>>
                <?php $fa_disabled = '' ?>
                <?php echo CHtml::link("<i class='icon-form-ubah $fa_disabled'></i>", Yii::app()->controller->createUrl("update", array("pendaftaran_id" => $riwayat->pendaftaran_id, "pasienkirimkeunitlain_id" => $riwayat->pasienkirimkeunitlain_id, )), array('return false;','rel'=>'tooltip','title'=>'Klik untuk mengubah pemeriksaan radiologi')); ?>
            </td>
            <td>
                <?php echo CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick'=>'batalKirim('.$riwayat->pasienkirimkeunitlain_id.','.$riwayat->pendaftaran_id.');return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan kirim pasien', 'data-placement'=>'left')); ?>
            </td>
        </tr>
        <?php } ?>

        <tr>
            <td colspan="8">
            <?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
                        'type'=>'info',
                        'buttons'=>array(
                            array('label'=>'Print', 'icon'=>MyIcon::getIcons('cetak'), 'url'=>'#', 'htmlOptions'=>array('onclick'=>'printRiwayat(\'PRINT\')')),
                            array('label'=>'', 'items'=>array(
                                array('label'=>'PDF', 'icon'=>MyIcon::getIcons('pdf'), 'url'=>'', 'itemOptions'=>array('onclick'=>'printRiwayat(\'PDF\')')),
                                array('label'=>'Excel','icon'=>MyIcon::getIcons('excel'), 'url'=>'', 'itemOptions'=>array('onclick'=>'printRiwayat(\'EXCEL\')')),
                               
                            )),       
                        ),
                        'htmlOptions'=>array('style'=>'float:right')
                    )); ?>
            
            </td>
        </tr>
    </tbody>
</table>