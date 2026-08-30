<table class="items table table-bordered table-striped datatable" id="tblListKonsul">
    <thead>
        <tr>
            <th>Tanggal Konsul</th>
            <th>No. Permintaan</th>
            <th>No. Pendaftaran</th>
            <th>Ruangan Asal</th>
            <th>Ruangan Tujuan</th>
            <th style="text-align: center">Detail</th>
            <th style="text-align: center">Lihat Hasil</th>
            <th style="text-align: center">Hapus</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($modRiwayatKonsul as $i => $konsul) { ?>
        <tr>
            <td><?php echo $konsul->tglkonsulpoli ?></td>
            <td><?php echo $konsul->konsulpoli_id ?> <?php echo CHtml::link("<i class='entypo-print'></i>", '#', array('onclick'=>'printPermintaan('.$konsul->konsulpoli_id.');return false;','rel'=>'tooltip','title'=>'Klik untuk mencetak detail konsul Poliklinik')); ?></td>
            <td><?php echo $konsul->pendaftaran->no_pendaftaran ?></td>
            <td><?php echo $konsul->poliasal->ruangan_nama ?></td>
            <td><?php echo $konsul->politujuan->ruangan_nama ?></td>
            <td style="text-align: center">
                <?php echo CHtml::link("<i class='" . MyIcon::getIcons('lihat') . "'></i>", '#', array('onclick' => 'viewDetailKonsul(' . $konsul->konsulpoli_id . ');return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk melihat detail konsul')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::link("<i class='" . MyIcon::getIcons('lihat') . "'></i>", '#', array('onclick' => 'viewDetailKonsulHasil(' . $konsul->konsulpoli_id . ');return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk melihat hasil jawaban konsul')); ?>
            </td>
            <td style="text-align: center">							
                <?php echo CHtml::link("<i class='" . MyIcon::getIcons('hapus') . "'></i>", '#', array('onclick' => 'batalKonsul(' . $konsul->konsulpoli_id . ',' . $konsul->pendaftaran_id . ');return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk membatalkan konsul')); ?>
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