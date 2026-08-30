<?php
$modPenjelasan = new CatatanedikasipenjT;
$modKeterangan = new CatatanedukasiketEvaluasiT;

?>

<table class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th colspan="2"><?php echo $kode; ?></th>
        </tr>
        <tr>
            <th width="50%">Penjelasan</th>
            <th>Keterangan dan Evaluasi Respon</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
            <?php foreach ($penjelasan as $item): ?>
                <div class="checkbox">
                    <?php echo CHtml::activeCheckBox($modPenjelasan, '['.$item->edukasipenjelasan_id.']isceklis'); ?>
                    <label><?php echo $item->nama_penjelasan; ?></label>
                </div>
                <?php if (trim(strtolower($item->nama_penjelasan)) == "lainnya") {
                    echo CHtml::activeTextArea($modPenjelasan, '['.$item->edukasipenjelasan_id.']lainnya', array(
                        'class'=>'span3'
                    ));
                } ?>
            <?php endforeach; ?>
            </td>
            <td>
            <?php foreach ($keterangan as $item): ?>
                <div class="checkbox">
                    <?php echo CHtml::activeCheckBox($modKeterangan, '['.$item->edukasi_keteranganevaluasi_id.']isceklis'); ?>
                    <label><?php echo $item->keterangan_evaluasi; ?></label>
                </div>
                <?php if (trim(strtolower($item->keterangan_evaluasi)) == "lainnya") {
                    echo CHtml::activeTextArea($modKeterangan, '['.$item->edukasi_keteranganevaluasi_id.']lainnya', array(
                        'class'=>'span3'
                    ));
                } ?>
            <?php endforeach; ?>
            </td>
        </tr>
    </tbody>
</table>