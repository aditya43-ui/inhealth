<?php

$i = $i ?? "iii";
$model = $model ?? new PersetujuanumumisiM;

?>

<div class="persetujuan_gambar_item">
    <?php echo CHtml::activeHiddenField($model, 'persetujuan_gambar['.$i.'][nama_gambar]', array('class'=>'nama_gambar')); ?>
    <?php echo CHtml::activeHiddenField($model, 'persetujuan_gambar['.$i.'][val64_gambar]', array('class'=>'val64_gambar')); ?>
    <img class="img_gambar" src="<?php echo $model->persetujuan_gambar[$i]['val64_gambar'] ?? ""; ?>">
    <?php echo CHtml::button('x', array('class'=>'btn btn-danger btn_hapus', 'onclick'=>"$(this).parents('.persetujuan_gambar_item').remove();")); ?>
</div>

