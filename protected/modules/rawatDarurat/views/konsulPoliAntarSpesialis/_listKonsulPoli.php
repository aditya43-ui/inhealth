<?php

$pg_login = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
$modul_id = Yii::app()->user->getState('modul_id');
$modul_login = Yii::app()->user->getState('modul_id');
$readonly = $pg_login->kelompokpegawai_id == 2 && $modul_id != 7;
$hide = $readonly ? " hide" : "";
$hidden = ($readonly || isset($_GET['lihat'])) ? " hidden" : "";
$display = "display:" . ($readonly ? " none;" : "block;");
$visibility = "visibility:" . ($readonly ? " visible; " : "hidden; ");

?>

<table class="items table table-bordered table-striped datatable" id="tblListKonsul">
    <thead>
        <tr>
            <th>Tanggal Konsul</th>
            <th>No. Permintaan</th>
            <th>No. Pendaftaran</th>
            <th>Dokter Asal Konsul</th>
            <th>Dokter Tujuan Konsul</th>
            <th style="text-align: center">Detail</th>
            <th style="text-align: center">Lihat Hasil</th>
            <th style="text-align: center" <?=$hidden?>>Hapus</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($modRiwayatKonsul as $i => $konsul) { 
        
        $ruangan_login = Yii::app()->user->getState('ruangan_id');
                    $pegawai_login = Yii::app()->user->getState('loginpemakai_id');
                
                    $ruangan_create = $konsul->create_ruangan;
                    $pegawai_create = $konsul->create_loginpemakai_id;
                
                    $modul_pel = [6, 7, 72];
                
                    $bisa_hapus = (($ruangan_login == $ruangan_create) && ($pegawai_login == $pegawai_create) && in_array($modul_login, $modul_pel)) ? 1 : 0;
        
        
        ?>
        <tr>
            <td><?php echo $konsul->tglkonsulpoli ?></td>
            <td><?php echo $konsul->konsulpoli_id ?> <?php echo CHtml::link("<i class='entypo-print'></i>", '#', array('onclick'=>'printPermintaan('.$konsul->konsulpoli_id.');return false;','rel'=>'tooltip','title'=>'Klik untuk mencetak detail konsul Poliklinik')); ?></td>
            <td><?php echo $konsul->pendaftaran->no_pendaftaran ?></td>
            <td><?php 
            $login = LoginpemakaiK::model()->findByPk($konsul->create_loginpemakai_id);
            echo $login->pegawai->namaLengkap ?? "-";
            ?></td>
            <td><?php echo $konsul->pegawai->namaLengkap ?? "-"; ?></td>
            <td style="text-align: center">
                <?php echo CHtml::link("<i class='" . MyIcon::getIcons('lihat') . "'></i>", '#', array('onclick' => 'viewDetailKonsul(' . $konsul->konsulpoli_id . ');return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk melihat detail konsul')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::link("<i class='" . MyIcon::getIcons('lihat') . "'></i>", '#', array('onclick' => 'viewDetailKonsulHasil(' . $konsul->konsulpoli_id . ');return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk melihat hasil jawaban konsul')); ?>
            </td>
            <td style="text-align: center" <?=$hidden?>>							
                <?php
                if (!empty($konsul->uraian_konsuljjawaban)){
                    echo '';
                } else {
                echo CHtml::link("<i class='" . MyIcon::getIcons('hapus') . "'></i>", '#', array('onclick' => 'batalKonsul(' . $konsul->konsulpoli_id . ',' . $konsul->pendaftaran_id . ', ' . $bisa_hapus . ');return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk membatalkan konsul'));
                }
                ?>
                    
        </td>
        </tr>
    <?php } ?>
        <tr>
            <td colspan="8">
                <?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
                    'type'=>'info', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
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