<?php
$i = !empty($i)?$i:0;

if (!empty($load[$val])){        
    $model->attributes = $load[$val]['attr']->attributes;
    $model->akses_vaskular_id = $load[$val]['attr']->akses_vaskular_id;
}
?>
<div class="control-group kelompok">
    <div class="col-sm-1" style="width:1%;padding:0px;">
        <?= CHtml::activeHiddenField($model, '['.$i.']akses_vaskular_id',['class'=>'det_id ket-dis']) ?>
        <?= CHtml::activeCheckBox($model, '['.$i.']nama_akses_vaskular',['value'=>$val,'uncheckValue'=>null,'class'=>'open-ket-dis parent']) ?>
    </div>        
    <div class="col-sm-2"><label for="<?= CHtml::activeId($model, '['.$i.']nama_akses_vaskular') ?>"><?= $val ?></label></div>
    <div class="col-sm-3"><?= CHtml::activeTextField($model, '['.$i.']problem',['placeholder'=>'Problem','class'=>'form-control ket-dis']) ?></div>
</div>
<div class="clear" style="padding:1px"></div>