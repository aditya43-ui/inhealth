<?php

$pg_login = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
$pg_loginpps = PpdsM::model()->findByPk(Yii::app()->user->getState('ppds_id'));

$modul_id = Yii::app()->user->getState('modul_id');
// $readonly = $pg_login->kelompokpegawai_id == 2 && $modul_id != 7;
if(!empty($pg_login->kelompokpegawai_id)){
    $readonly = $pg_login->kelompokpegawai_id == 2 && $modul_id != 7;
}
if (!empty($pg_loginpps->kelompokpegawai_id)){
    $readonly = $pg_loginpps->kelompokpegawai_id == 2 && $modul_id != 7;

}
$hide = $readonly ? " hide" : "";
$hidden2 = $readonly ? " hidden" : "";
$display = "display:" . ($readonly ? " none;" : "block;");

    $modul_login = Yii::app()->user->getState('modul_id');
    $modul_hide = Params::MODUL_ID_HIDE;

    $hide_edit = in_array($modul_login, $modul_hide) ? "hidden" : "";


?>

<table id="tblListPemeriksaanLab" class="table table-bordered table-striped table-condensed">
    <thead>
        <tr>
            <th>Tanggal Kirim Ke Laboratorium</th>
            <th>No. Pendaftaran</th>
            <th>No. Permintaan</th>
            <th>Permintaan Pemeriksaan</th>
            <th>Jumlah</th>
            <th>Status Verifikasi Penunjang</th>
            <th <?= $hide_edit ?>>Ubah</th>
            <th>Hapus</th>
        </tr>
    </thead>
    <tbody>
<?php
foreach ($modRiwayatKirimKeUnitLain as $i => $riwayat) {
    $modPermintaan = RJPermintaanPenunjangT::model()->with('daftartindakan','pemeriksaanlab')->findAllByAttributes(array('pasienkirimkeunitlain_id'=>$riwayat->pasienkirimkeunitlain_id));

    $ruangan_login = Yii::app()->user->getState('ruangan_id');
    $pegawai_login = Yii::app()->user->getState('loginpemakai_id');

    $ruangan_create = $riwayat->create_ruangan;
    $pegawai_create = $riwayat->create_loginpemakai_id;

    $modul_pel = Params::MODUL_ID_HIDE;

    $bisa_hapus = (($ruangan_login == $ruangan_create) && ($pegawai_login == $pegawai_create) && in_array($modul_login, $modul_pel)) ? 1 : 0;

    $fa_disabled = !$bisa_hapus ? "fa-disabled" : "";

    // echo '<pre>'; var_dump($modPermintaan); die;
    ?>
    <tr>
        <td><?php echo MyFormatter::formatDateTimeForUser($riwayat->tgl_kirimpasien); ?></td>
        <td><?php echo !empty($riwayat->pendaftaran_id) ? $riwayat->pendaftaran->no_pendaftaran : "<button class=\"btn btn-success\" disabled=\"disabled\" style=\"opacity:1.0\">Elektif</button>"; ?></td>
        <td><?php echo $riwayat->pasienkirimkeunitlain_id;?> <a href='' onclick="printPermintaan('<?php echo $riwayat->pasienkirimkeunitlain_id; ?>')"><i class="entypo-print"></i></a> </td>
        <td>
            <?php
            foreach($modPermintaan as $j => $permintaan){
                $tindakan = null;
                if (!empty($permintaan->tindakanpelayanan_id)) {
                    $tindakan = TindakanpelayananT::model()->findByPk($permintaan->tindakanpelayanan_id);
                }
                
                echo !empty($permintaan->pemeriksaanlab) ? strip_tags($permintaan->pemeriksaanlab->pemeriksaanlab_nama) : $permintaan->pemeriksaanlab_id;
                
                if (!empty($tindakan) && $tindakan->tipepaket_id != Params::TIPEPAKET_ID_NONPAKET) {
                    $paket = TipepaketM::model()->findByPk($tindakan->tipepaket_id);
                    echo " (".$paket->tipepaket_nama.")";
                }
                
                if(!empty($permintaan->pemeriksaanlab_id)) {
                    echo '<br>';
                }
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
                if(!empty($permintaan->pemeriksaanlab_id)) {
                    echo $permintaan->qtypermintaan.'<br>';
                }
            } ?>
        </td>

        <td>
            <?php
                $pasienKirim = PasienkirimkeunitlainT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $riwayat->pasienmasukpenunjang_id));
                $pasienBatal_1 = PasienbatalperiksaR::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $riwayat->pasienkirimkeunitlain_id));
                $pasienBatal_2 = PasienbatalperiksaR::model()->findByAttributes(array('pasienmasukpenunjang_id' => $riwayat->pasienmasukpenunjang_id));
                
                if(!empty($pasienKirim->pasienmasukpenunjang_id) && ($pasienBatal_1 || $pasienBatal_2)) {
                    $status = '<button style="pointer-events: none;" id="red" class="btn btn-red nohover btn-status"> BATAL </button>';
                } else if(!empty($pasienKirim->pasienmasukpenunjang_id) && empty($pasienBatal_1) && empty($pasienBatal_2)) {
                    $status = '<button style="pointer-events: none;" id="green" class="btn btn-green nohover btn-status"> SUDAH </button>';
                } else if(empty($pasienKirim->pasienmasukpenunjang_id)) {
                    $status = '<button style="pointer-events: none;" id="red" class="btn btn-red nohover btn-status"> BELUM </button>';
                }
                
                echo $status;
            ?>
            </td>
        <td <?= $hide_edit ?>>
            <?php $fa_disabled = '' ?>
            <?php echo CHtml::link("<i class='icon-form-ubah $fa_disabled'></i>", Yii::app()->controller->createUrl("update", array("pendaftaran_id" => $riwayat->pendaftaran_id, "pasienkirimkeunitlain_id" => $riwayat->pasienkirimkeunitlain_id, )), array('return false;','rel'=>'tooltip','title'=>'Klik untuk mengubah pemeriksaan laboratorium')); ?>
        </td>
        <td <?=$hidden2?>>
            <?php echo CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick'=>'batalKirim('.$riwayat->pasienkirimkeunitlain_id.','.$riwayat->pendaftaran_id.', ' . $bisa_hapus . ');return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan kirim pasien', 'data-placement'=>'left')); ?>
        </td>
    </tr>
    <?php
}
?>
        <tr id="trListKosong"><td colspan="9"><?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
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