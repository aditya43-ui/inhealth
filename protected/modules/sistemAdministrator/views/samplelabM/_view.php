<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('samplelab_id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->samplelab_id), array('view', 'id' => $data->samplelab_id)); ?>
    <br>

    <b><?php echo CHtml::encode($data->getAttributeLabel('samplelab_nama')); ?>:</b>
    <?php echo CHtml::encode($data->samplelab_nama); ?>
    <br>

    <b><?php echo CHtml::encode($data->getAttributeLabel('samplelab_namalainnya')); ?>:</b>
    <?php echo CHtml::encode($data->samplelab_namalainnya); ?>
    <br>

    <b><?php echo CHtml::encode($data->getAttributeLabel('samplelab_aktif')); ?>:</b>
    <?php echo CHtml::encode(($data->samplelab_aktif) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')); ?>
    <br>

</div>