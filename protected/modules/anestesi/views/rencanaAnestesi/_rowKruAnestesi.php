<div class="control-group pelaksanaanestesi">
    <?php echo CHtml::label(($length == 0) ? ucwords(strtolower($model->kruanestesi)) : '', '', array('class' => 'control-label gantilabel',)) ?>
    <div class="controls">
        <?php echo CHtml::activeHiddenField($model, "[" . $i . "]pelaksanaanestesi_id", array()); ?>
        <?php echo CHtml::activeHiddenField($model, "[" . $i . "]kruanestesi", array()); ?>
        <?php echo CHtml::activeHiddenField($model, "[" . $i . "]pegawai_id", array('class' => 'kruanestesi_id')); ?>
        <?php echo CHtml::activeHiddenField($model, "[" . $i . "]ppds_id", array('class' => 'kruanestesi_id')); ?>
        <?php echo CHtml::activeTextField($model, "[" . $i . "]pegawai_nama", array('readonly' => true, 'class' => 'span3 krubedah_nama')); ?>
        <?php echo CHtml::activeHiddenField($model, '[' . $i . ']status', array('class' => 'status', 'readonly' => true)); ?>
    </div>
    <div class="controls" style="margin-left: 4px">
        <?php
        if (empty($model->pelaksanaanestesi_id)) {
            echo CHtml::link("<i class='" . MyIcon::getIcons('hapus-baris') . "'></i>", 'javascript:;', array('onclick' => 'removeData(this,\'' . ucwords(strtolower($model->kruanestesi)) . '\')', 'class' => 'btn btn-danger', 'style' => 'padding : 8px'));
        } else {
            echo CHtml::link("<i class='" . MyIcon::getIcons('hapus-baris') . "'></i>", 'javascript:;', array('onclick' => 'removeDataFromDb(this,\'' . ucwords(strtolower($model->kruanestesi)) . '\')', 'class' => 'btn btn-danger', 'kruanestesi_id' => $model->pelaksanaanestesi_id, 'style' => 'padding : 8px'));
        }
        ?>
    </div>
</div>	



