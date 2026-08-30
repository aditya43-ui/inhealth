<?php
$i = !empty($i)?$i:0;
?>
<div class="control-group  kelompok-2">
    <div class="col-sm-1" style="width:1%;padding:0px;">
        <?= CHtml::activeHiddenField($model, '['.$i.']akses_vaskular_id',['class'=>'det_id  ket-dis']) ?>
        <?= CHtml::activeHiddenField($model, '['.$i.']nama_akses_vaskular',['value'=>$val_prev,'uncheckValue'=>null,'class'=>'ket-dis open-ket-dis-2 multiple ']) ?>
        <?= CHtml::activeCheckBox($model, '['.$i.']hd_kateter',['value'=>$val,'uncheckValue'=>null,'class'=>'ket-dis open-ket-dis-2 multiple parent']) ?>
    </div>        
    <div class="col-sm-1"><label for="<?= CHtml::activeId($model, '['.$i.']nama_akses_vaskular') ?>"><?= $val ?></label></div>
    <div class="col-sm-2">
        <?= CHtml::activeRadioButton($model, '['.$i.']is_kanan',['onclick'=>'salah_satu(this)','uncheckValue'=>null,'class'=>'ket-dis']).'<label for="'.CHtml::activeId($model, '['.$i.']is_kanan').'">Kanan</label>' ?>        
    </div>
    <div class="col-sm-2">
        <?= CHtml::activeRadioButton($model, '['.$i.']is_kiri',['onclick'=>'salah_satu(this)','uncheckValue'=>null,'class'=>'ket-dis']).'<label for="'.CHtml::activeId($model, '['.$i.']is_kiri').'">Kiri</label>' ?>
    </div>
    <div class="col-sm-4"><?= CHtml::activeTextField($model, '['.$i.']problem',['placeholder'=>'Problem','class'=>'form-control  ket-dis-2']) ?></div>
</div>
<div class="clear" style="padding:1px"></div>