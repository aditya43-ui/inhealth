<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjformulaobatkronis-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#kasuspenyakit',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
)); ?>
<?php
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', '<b>Berhasil </b> Data berhasil disimpan');
}
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <div class="col-sm-6">
     <?php  echo $form->textFieldRow($model,'jumlahobat',array('class'=>'span3 numbers-only','size'=>50,'maxlength'=>50)); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'is_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'is_aktif', array('checked' => 'is_aktif')); ?>
                <label for="FormulaobatkronisMK_is_aktif">Aktif</label>
            </div>
        </div>  
     </div>
    <div class="col-sm-6">
       
        <div class="control-group">
        <?php echo CHtml::label('Jumlah Obat Minimal <br> (Ina-CBGs)', '', array('class' => 'control-label required')); ?>
            <div class="controls">
            <?php echo CHtml::activeTextField($model, 'jumlahobat_minimal', array('class'=>'span3 numbers-only','size'=>50,'maxlength'=>50)); ?>
            </div>
        </div>

        <div class="control-group">
        <?php echo CHtml::label('Jumlah Obat Maksimal <br> (fre for service)', '', array('class' => 'control-label required')); ?>
            <div class="controls">
            <?php echo CHtml::activeTextField($model, 'jumlahobat_maksimal', array('class'=>'span3 numbers-only','size'=>50,'maxlength'=>50)); ?>
        
            </div>
        </div>


    </div>
</div>


<div class="form-actions">
    <?php
       if ($model->isNewRecord) {
        echo CHtml::htmlButton(
            $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'onKeypress' => 'return formSubmit(this,event)')
        );
    } else {
        echo CHtml::htmlButton(
            $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'onKeypress' => 'return formSubmit(this,event)','disabled'=>true)
        );
    }
 
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/formulaObatKronis/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Formula Obat Kronis', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('formulaObatKronis/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    );
    ?>
    <?php
    $content = $this->renderPartial('farmasiApotek.views.tips.tipsaddedit3', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
