<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'laporanoperasipasien-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>
<?php echo $form->hiddenField($model, 'pasien_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pendaftaran_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pasienadmisi_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pasienmasukpenunjang_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php // echo $form->hiddenField($model,'rencanaoperasi_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
?>

<?php echo $this->renderPartial('_infoRiwayat', array(
    'model' => $model,
    
), true); ?>

<?php echo $this->renderPartial('_infoPasien', array(
    'model' => $penunjang
), true); ?>
<?php echo $this->renderPartial('_infoOperasi', array(
    'penunjang' => $penunjang,
    'rencana' => $rencana,
    'anestesi' => $anestesi,
    'model' => $model,
    'diagnosa' => $diagnosa,
), true); ?>
<?php
echo $this->renderPartial('_formJaringanHasil', array(
    'form' => $form,
    'model' => $model,
), true);
?>
<div class="col-sm-12">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-newspaper"></i> Laporan <b>(Prosedur, Temuan Intra Operasi, dan Komplikasi)</b>
            </div>
        </div>
        <div class="panel-body">
            <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'laporanoperasi', 'toolbar' => 'mini', 'height' => '200px')) ?>
            <?php // echo $form->textArea($model,'laporanoperasi',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
            ?>

        </div>
    </div>
</div>
                            
<div class="col-sm-12">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-newspaper"></i> Laporan <b>Laporan Pasca Operasi</b>
            </div>
        </div>
        <div class="panel-body">
            <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'laporanpascaoperasi', 'toolbar' => 'mini', 'height' => '200px')) ?>
            <?php // echo $form->textArea($model,'laporanoperasi',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
            ?>

        </div>
    </div>
</div>

<div class="col-sm-6">
    <div class="control-group">
        <?php echo $form->labelEx($model, 'tanggalpengisian_laporanop', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tanggalpengisian_laporanop',
                'mode' => 'date',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                ),
                'htmlOptions' => array('readonly' => true, 'class' => 'span2', 'onclick' => "return $(this).focusNextInputField(event)"),
            ));
            ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <?php

    $arr_peg = array();
    if (!empty($rencana->dokterpelaksana1_id)) {
        $arr_peg[] = $rencana->dokterpelaksana1_id;
    }
    if (!empty($rencana->dokterpelaksana2_id)) {
        $arr_peg[] = $rencana->dokterpelaksana2_id;
    }

    $listDokter = PegawaiM::model()->findAllByAttributes(array(
        'pegawai_id' => $arr_peg
    ), array('order' => 'nama_pegawai'));
    echo $form->dropDownListRow($model, 'dokterbedah_pengisilaporan_id', CHtml::listData($listDokter, 'pegawai_id', 'namaLengkap'), array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

</div>
<div class="clear"></div>



<?php //echo $form->textFieldRow($model,'tanggalpengisian_laporanop',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
?>
<?php // echo $form->textFieldRow($model,'create_time',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
?>
<?php // echo $form->textFieldRow($model,'update_time',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
?>
<?php // echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
?>
<?php // echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
?>
<?php // echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create', array('pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id)),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'onKeypress' => 'return formSubmit(this,event)', 'onclick' => 'print();', 'disabled' => $model->isNewRecord)); ?>
    <?php // echo CHtml::link(Yii::t('mds','{icon} Pengaturan LaporanoperasipasienT',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
    ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>

<?php $this->endWidget(); ?>

<script>
    function print() {
        window.open("<?php echo $this->createUrl('print', array(
                            'pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id
                        )); ?>&caraPrint=PRINT", "", 'location=_new, width=900px');
    }
    function print2(id) {
        window.open("<?php echo $this->createUrl('print'); ?>&id=" + id + "&caraPrint=PRINT", "", 'location=_new, width=900px');
    }
</script>