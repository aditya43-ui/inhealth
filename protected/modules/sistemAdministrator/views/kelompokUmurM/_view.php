<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('kelompokumur_id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->kelompokumur_id), array('view', 'id' => $data->kelompokumur_id)); ?>
    <br>

    <b><?php echo CHtml::encode($data->getAttributeLabel('kelompokumur_nama')); ?>:</b>
    <?php echo CHtml::encode($data->kelompokumur_nama); ?>
    <br>

    <b><?php echo CHtml::encode($data->getAttributeLabel('kelompokumur_namalainnya')); ?>:</b>
    <?php echo CHtml::encode($data->kelompokumur_namalainnya); ?>
    <br>

    <b><?php echo CHtml::encode($data->getAttributeLabel('kelompokumur_minimal')); ?>:</b>
    <?php echo CHtml::encode($data->kelompokumur_minimal); ?>
    <br>

    <b><?php echo CHtml::encode($data->getAttributeLabel('kelompokumur_maksimal')); ?>:</b>
    <?php echo CHtml::encode($data->kelompokumur_maksimal); ?>
    <br>

    <b><?php echo CHtml::encode($data->getAttributeLabel('kelompokumur_aktif')); ?>:</b>
    <?php echo CHtml::encode((($data->kelompokumur_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No'))) ?>
    <br>

</div>