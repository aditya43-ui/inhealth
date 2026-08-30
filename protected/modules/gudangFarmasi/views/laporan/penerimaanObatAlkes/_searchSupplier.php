<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'search-laporan',
        'type' => 'horizontal',
        'focus' => '#' . CHtml::activeId($model, 'noterima'),
    ));
    ?>
    <div class="row">
        <div class="col-sm-6">
            <?php echo CHtml::hiddenField('type', ''); ?>
            <?php echo CHtml::hiddenField('filter_tab', 'rekap'); ?>
            <div class="control-group">
                <?php echo $form->hiddenField($model, 'jns_periode', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'bln_awal', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'bln_akhir', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'thn_awal', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'thn_akhir', array('class' => 'span2')); ?>
                <?php echo CHtml::label("Periode Laporan", 'tgl_rekam', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <?php $modSup = new GFSupplierM(); ?>
            <div class="control-group">
                <?php echo CHtml::label('Supplier', 'supplier_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'supplier_id', CHtml::listData($modSup->getSupplierItems(), 'supplier_id', 'supplier_nama'), array(
                        'class' => 'form-control', 'multiple' => 'multiple'
                    ));
                    ?>
                </div>
            </div>

            <?php // echo $form->textFieldRow($model, 'noterima', array('placeholder' => 'No. Penerimaan', 'class' => 'numberOnly')); 
            ?>
        </div>
    </div>
    <div class="form-actions" style="margin: 0 !important;">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
        ); ?>
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset', 'onclick' => 'resetForm();')
        ); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<script>
    function resetForm() {
        setTimeout(function() {
            $('#search-laporan').submit();
        }, 500);
    }
</script>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>