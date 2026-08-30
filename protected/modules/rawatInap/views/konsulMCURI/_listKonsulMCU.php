<table class="items table table-striped table-bordered table-condensed" id="tblListKonsul">
    <thead>
        <tr>
            <th>Tanggal Konsul</th>
            <th>No. Permintaan</th>
            <th>No. Pendaftaran</th>
            <th>Poliklinik Asal</th>
            <th>Poliklinik Tujuan</th>
            <th>Batal</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($modRiwayatKonsul as $i => $konsul) { ?>
            <tr>
                <td><?php echo $konsul->tglkonsulpoli ?></td>
                <td><?php echo $konsul->konsulpoli_id ?> <?php echo CHtml::link("<i class='entypo-print'></i>", '#', array('onclick' => 'printPermintaan(' . $konsul->konsulpoli_id . ');return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk mencetak detail konsul MCU')); ?></td>
                <td><?php echo $konsul->pendaftaran->no_pendaftaran ?></td>
                <td><?php echo $konsul->poliasal->ruangan_nama ?></td>
                <td><?php echo $konsul->politujuan->ruangan_nama ?></td>
                <td>
                    <?php // echo CHtml::link("<i class='icon-eye-open'></i>", '#', array('onclick'=>'viewDetailKonsul('.$konsul->konsulpoli_id.');return false;','rel'=>'tooltip','title'=>'Klik untuk melihat detail konsul')); 
                    ?>
                    <?php echo CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick' => 'batalKonsul(' . $konsul->konsulpoli_id . ',' . $konsul->pendaftaran_id . ');return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk membatalkan konsul')); ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
    'type' => 'info',
    'buttons' => array(
        array('label' => 'Print', 'icon' => 'entypo-print', 'url' => '#', 'htmlOptions' => array('onclick' => 'printRiwayat(\'PRINT\')')),
        array('label' => '', 'items' => array(
            array('label' => 'PDF', 'icon' => 'icon-book', 'url' => '', 'itemOptions' => array('onclick' => 'printRiwayat(\'PDF\')')),
            array('label' => 'Excel', 'icon' => 'icon-pdf', 'url' => '', 'itemOptions' => array('onclick' => 'printRiwayat(\'EXCEL\')')),

        )),
    ),
    'htmlOptions' => array('style' => 'float: right; clear: both; margin-bottom: 17px;')
)); ?>