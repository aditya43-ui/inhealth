<?php

if (!$model->isNewRecord) {
    $aniaya = RiwayataniayaT::model()->findAllByAttributes(array(
        'askepkesehatanjiwa_id'=>$model->askepkesehatanjiwa_id,
        'jenisaniaaya'=>$jenisaniaya,
    ));
} else {
    $aniaya = array();
}

?>

<div class="control-group panel_aniaya" data-jenis="<?php echo $jenisaniaya; ?>">
    <label class="control-label">&nbsp;</label>
    <div class="controls" style="width: 500px;">
        <div class="checkbox">
            <?php echo $form->checkBox($model, $jenisaniaya_attr, array('data-jenis'=>$jenisaniaya, 'uncheckValue'=>null, 'class'=>'ceklis_aniaya')); ?>
            <label><?php echo $jenisaniaya_label ?></label>
        </div>
        <table class="table table-bordered table-condensed tab_aniaya">
            <thead>
                <tr>
                    <th>Sebagai</th>
                    <th>Usia</th>
                    <th width="70">
                        <?php echo CHtml::htmlButton('+', array('class'=>'btn btn-success', 'onclick'=>'tambahRowRiwayatAniaya(this);')); ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($aniaya as $idx => $item) {
                    echo $this->renderPartial($this->path_view . "form.predisposisi.psikososial._rowAniaya", array(
                        'mod' => $item, 'i' => "C_".$idx, 'jenisaniaya' => $jenisaniaya
                    ), true);
                } ?>
            </tbody>
        </table>
    </div>
</div>