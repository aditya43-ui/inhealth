<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pcobatalkesdetail-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'Nama Obat', array('class' => 'control-label')); ?>
            <div class="controls inline">
                <?php echo $form->dropDownList($model, 'obatalkes_id', CHtml::listData(ObatalkesM::model()->findAllByAttributes(array('obatalkes_aktif' => true), array('order' => 'obatalkes_nama')), 'obatalkes_id', 'obatalkes_nama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'Indikasi', array('class' => 'control-label')); ?>
            <div class="controls inline">
                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'indikasi', 'toolbar' => 'mini', 'height' => '100px', 'name' => 'PCObatalkesdetailM_indikasi')) ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'komposisi', array('class' => 'control-label')); ?>
            <div class="controls inline">
                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'komposisi', 'toolbar' => 'mini', 'height' => '100px', 'name' => 'PCObatalkesdetailM_komposisi')) ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'interaksiobat', array('class' => 'control-label')); ?>
            <div class="controls inline">
                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'interaksiobat', 'toolbar' => 'mini', 'height' => '100px', 'name' => 'PCObatalkesdetailM_interaksiobat')) ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'peringatan', array('class' => 'control-label')); ?>
            <div class="controls inline">
                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'peringatan', 'toolbar' => 'mini', 'height' => '100px', 'name' => 'PCObatalkesdetailM_peringatan')) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6"><br><br>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'kontraindikasi', array('class' => 'control-label')); ?>
            <div class="controls inline">
                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'kontraindikasi', 'toolbar' => 'mini', 'height' => '100px', 'name' => 'PCObatalkesdetailM_kontraindikasi')) ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'efeksamping', array('class' => 'control-label')); ?>
            <div class="controls inline">
                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'efeksamping', 'toolbar' => 'mini', 'height' => '100px', 'name' => 'PCObatalkesdetailM_efeksamping')) ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'carapenyimpanan', array('class' => 'control-label')); ?>
            <div class="controls inline">
                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'carapenyimpanan', 'toolbar' => 'mini', 'height' => '100px', 'name' => 'PCObatalkesdetailM_carapenyimpanan')) ?>
            </div>
        </div>

    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Obat', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php //$this->widget('UserTips',array('type'=>'create'));
    ?>
    <?php
    $content = $this->renderPartial('prescribingControl.views.tips.tipsadd', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>