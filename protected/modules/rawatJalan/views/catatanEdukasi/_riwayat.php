<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Riwayat Catatan Edukasi</div>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>No. Catatan Edukasi</th>
                    <th>Tanggal</th>
                    <th>Metode</th>
                    <th>Durasi</th>
                    <th>Nama Edukator</th>
                    <th>Keterangan dan Evaluasi Respon</th>
                    <th>Hapus</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($riwayat as $idx=>$item): ?>
                <tr>
                    <td><?php echo $idx + 1; ?></td>
                    <td><?php echo $item->nomorcatatanedukasi; ?></td>
                    <td><?php echo MyFormatter::formatDateTimeForUser($item->tgl_edukasi); ?></td>
                    <td><?php echo $item->metodeedukasi; ?></td>
                    <td><?php echo $item->durasi; ?> menit</td>
                    <td><?php echo $item->edukator->namaLengkap; ?></td>
                    <td style="text-align: center;"><?php
                    echo CHtml::link('<i class="icon-form-detail"></i>', $this->createUrl('view', array('id'=>$item->catatanedukasi_id)), array(
                        'target'=>'frameDetail', 'onclick'=>"$('#dialogDetail').dialog('open');"
                    ));
                    ?></td>
                    <td>
                        <?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array(
                            'onclick'=>'hapusCatatan(this, '.$item->catatanedukasi_id.'); return false;',
                            'rel'=>'tooltip', 'title'=>'Hapus Catatan Edukasi',
                        )); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            
            
        </table>
        <div class="form-actions">
            <?php echo CHtml::htmlButton('<i class="entypo-print"></i> Print Form A', array(
                'class'=>'btn btn-info',
                'onclick'=>"printA('PRINT')",
            )); ?>
            &nbsp;
            <?php echo CHtml::htmlButton('<i class="entypo-print"></i> Print Form B', array(
                'class'=>'btn btn-info',
                'onclick'=>"printB('PRINT')",
            )); ?>
        </div>
        
    </div>
</div>

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogDetail',
    'options'=>array(
        //'title'=>'Obat & Alat Kesehatan',
        'title'=>'Detail Catatan Edukasi',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

echo '<iframe name="frameDetail" style="border: 0px; width:100%; height: 530px; "></iframe>';

$this->endWidget();
?>



