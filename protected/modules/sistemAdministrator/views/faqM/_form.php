<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'faq-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    // 'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    // 'focus' => '#' . CHtml::activeId($model, 'sumberdana_nama'),
)); ?>
<div class="row">
    <div class="col-sm-12">
    <!-- LookupM::getItems('jeniskelamin') -->
        <?php echo $form->dropDownListRow($model,'modul_id',CHtml::listData(ModulK::model()->findAll(array('order'=>'modul_nama ASC'),'modul_aktif = true'), 'modul_id', 'modul_nama'),array('empty' => '-- Pilih --')) ?>
        <?php echo $form->textFieldRow($model,'faq_urutan',array('class'=>'integer')); ?>
        <?php echo $form->textAreaRow($model,'faq_pertanyaan'); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'faq_jawaban', array('class' => 'control-label')); ?>
            <div class="controls" style="width: 70%">
                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'faq_jawaban', 'toolbar' => 'default', 'height' => '200px')) ?>
            </div>
        </div> 
        <div class="control-group">
            <?php echo CHtml::label('Aktif', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'faq_aktif', array('checked' => 'faq_aktif')); ?>
                <label for="SAFaqM_faq_aktif">Aktif</label>
            </div>
        </div>
    </div> 
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan FAQ', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('tips/tipsCreateUpdate', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function setModul(obj){
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('SetMenuByModul'); ?>',
            data: {modul_id:$(obj).val()},//
            dataType: "json",
            success:function(data){
            console.log(data)
            //    $("#KUTandabuktikeluarT_bank_id").html(data.option);
            
            $("#SAPetunjukpenggunaanM_menu_id").html(data.option);
            // $('#KUPengeluaranumumT_nopengeluaran').val(data.no)
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });

    }
</script>