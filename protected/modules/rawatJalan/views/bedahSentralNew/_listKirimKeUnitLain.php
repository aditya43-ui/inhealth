<?php

$pg_login = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
$pg_loginpps = PpdsM::model()->findByPk(Yii::app()->user->getState('ppds_id'));

$modul_id = Yii::app()->user->getState('modul_id');
// $readonly = $pg_login->kelompokpegawai_id == 2 && $modul_id != 7;
if(!empty($pg_login->kelompokpegawai_id)){
    $readonly = $pg_login->kelompokpegawai_id == 2 && $modul_id != 7;
}
if (!empty($pg_loginpps->kelompokpegawai_id)){
    $readonly = $pg_loginpps->kelompokpegawai_id == 1 && $modul_id != 7;

}
$hide = $readonly ? " hide" : "";
$hidden = $readonly ? " hidden" : "";
$display = "display:" . ($readonly ? " none;" : "block;");
$visibility = "visibility:" . ($readonly ? " visible; " : "hidden; ");
if(isset($_GET['lihat'])) {
    $hidden = 'hidden';
}
?>

<table id="tblListRencanaOperasi" class="table table-bordered table-striped table-condensed">
    <thead>
        <tr>
            <th>Tgl Permintaan</th>
            <th>Tgl Rencana Operasi</th>
            <th>No Pendaftaran</th>
            <th>Permintaan Operasi</th>
            <!--th>Tarif</th-->
            <th>Jumlah</th>
            <th>Ruangan</th>
            <th>Status Verifikasi OK</th>
            <th <?=$hidden?>>Batal</th>
            <th>Cetak</th>
        </tr>
    </thead>
    <?php

foreach ($modRiwayatKirimKeUnitLain as $i => $riwayat) {
    $modPermintaan = RJPermintaanPenunjangT::model()->with('daftartindakan','operasi')->findAllByAttributes(array('pasienkirimkeunitlain_id'=>$riwayat->pasienkirimkeunitlain_id));    
    ?>
    <tr>
        <td><?php echo MyFormatter::formatDateTimeForUser($riwayat->tgl_kirimpasien); ?></td>
        <td><?= !empty($riwayat->tglrencanapemeriksaan)? MyFormatter::formatDateTimeForUser($riwayat->tglrencanapemeriksaan) :''; ?>
        </td>
        <td><?php echo !empty($riwayat->pendaftaran_id) ? $riwayat->pendaftaran->no_pendaftaran : "<button class=\"btn btn-success\" disabled=\"disabled\" style=\"opacity:1.0\">Elektif</button>"; ?></td>
        </td>
        <td>
            <?php
            foreach($modPermintaan as $j => $permintaan){
                echo $permintaan->operasi->operasi_nama.'<br>';
            } ?>
        </td>
        <!--td>
            <?php /*
            foreach($modPermintaan as $j => $permintaan){
                $modTarif = TariftindakanM::model()->findByAttributes(array('kelaspelayanan_id'=>$riwayat->kelaspelayanan_id,
                                                                            'daftartindakan_id'=>$permintaan->operasi->daftartindakan_id,
                                                                            'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
                echo (!empty($modTarif->harga_tariftindakan))? number_format($modTarif->harga_tariftindakan).'<br>':'0 <br>';
             } */ ?>
        </td-->
        <td>
            <?php
            foreach($modPermintaan as $j => $permintaan){
                echo $permintaan->qtypermintaan.'<br>';
            } ?>
        </td>
        <td>
            <?php
            echo $riwayat->ruangan->ruangan_nama;
            ?>
        </td>
        <td>
            <?php
                        $pasienKirim = PasienkirimkeunitlainT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $riwayat->pasienmasukpenunjang_id));
                        $pasienBatal_1 = PasienbatalperiksaR::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $riwayat->pasienkirimkeunitlain_id));
                        $pasienBatal_2 = PasienbatalperiksaR::model()->findByAttributes(array('pasienmasukpenunjang_id' => $riwayat->pasienmasukpenunjang_id));
                        
                        if(!empty($pasienKirim->pasienmasukpenunjang_id) && ($pasienBatal_1 || $pasienBatal_2)) {
                            $status = '<button style="pointer-events: none;" id="red" class="btn btn-red nohover btn-status"> BATAL </button>';
                        } else if(!empty($pasienKirim->pasienmasukpenunjang_id) && empty($pasienBatal_1) && empty($pasienBatal_2)) {
                            $status = '<button id= style="pointer-events: none;""green" class="btn btn-green nohover btn-status"> SUDAH </button>';
                        } else if(empty($pasienKirim->pasienmasukpenunjang_id)) {
                            $status = '<button style="pointer-events: none;" id="red" class="btn btn-red nohover btn-status"> BELUM </button>';
                        }

                        echo $status;
                    ?>
        </td>
        <td <?=$hidden?>>
            <?php 
                $onclick = 'window.parent.myAlert("Tidak bisa dihapus karena hak akses tidak sesuai")';

                $bisa_hapus = CustomFunction::hakAksesHapus(Yii::app()->user->getState('loginpemakai_id'), $riwayat->create_ruangan, $riwayat->create_loginpemakai_id);

                if($bisa_hapus) {
                    $onclick = 'batalKirim('.$riwayat->pasienkirimkeunitlain_id.','.$riwayat->pendaftaran_id.', this);return false;';
                }

                echo CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick'=>$onclick,'rel'=>'tooltip','title'=>'Klik untuk membatalkan kirim pasien', 'data-placement'=>'left')); ?>
        </td>
        <td style="text-align: center;">
            <a onclick="printRujukan('PRINT',<?php echo $riwayat->pasienkirimkeunitlain_id; ?>);return false;"
                rel="tooltip" href="javascript:void(0);"><i class="icon-form-print"></i></a>
        </td>
    </tr>

    <?php
}
?>
    <tr id="trListKosong">
        <td hidden colspan="9"><?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
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
    )); ?></td>
    </tr>
</table>