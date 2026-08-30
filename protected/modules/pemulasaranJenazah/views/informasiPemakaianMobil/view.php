<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php echo $this->renderPartial('_view', array('model' => $model)); ?>

<div class="clear"></div>
<div class="form-actions">
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printDetail();return false"));
    ?>
</div>

<script type="text/javascript">
    function printDetail() {
        var pemakaianambulans_id = '<?php echo isset($model->pemakaianambulans_id) ? $model->pemakaianambulans_id : null; ?>';
        window.open('<?php echo $this->createUrl('printDetail'); ?>&pemakaianambulans_id=' + pemakaianambulans_id, 'printwin', 'left=100,top=100,width=860,height=640');

    }
</script>