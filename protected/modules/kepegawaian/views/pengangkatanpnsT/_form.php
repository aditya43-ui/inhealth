<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); 
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'kppengangkatanpns-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
)); ?>
<fieldset class="box">
    <?php
    $this->widget('application.extensions.moneymask.MMask', array(
        'element' => '.currency',
        'currency' => 'PHP',
        'config' => array(
            'symbol' => 'Rp ',
            //        'showSymbol'=>true,
            //        'symbolStay'=>true,
            'defaultZero' => true,
            'allowZero' => true,
            'precision' => 0,
        )
    ));
    ?>

    <?php echo $this->renderPartial('_pegawai', array('model' => $modPegawai, 'form' => $form,  'data' => $model)); ?>

    <?php echo $form->errorSummary($model); ?>
    <?php echo $form->errorSummary($modUsulan); ?>
    <?php echo $form->errorSummary($modPers); ?>
    <?php echo $form->errorSummary($modRealisasi); ?>

    <?php echo $form->hiddenField($model, 'jabatan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
    <?php echo $form->hiddenField($model, 'pangkat', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
    <?php echo $form->hiddenField($model, 'pendidikan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
</fieldset>
<fieldset class="box">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                Pengangkatan
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <?php echo $form->textAreaRow($model, 'keterangan', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
                <div class="col-sm-6">
                    <?php $this->renderPartial('_usulan', array('model' => $modUsulan, 'form' => $form)); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo $form->checkBox($model, 'cekPersetujuan', array("onclick" => "slide('persetujuan');")); ?>Persetujuan Pengangkatan Pegawai Negeri Sipil</div>
                </div>
                <div class="panel-body">
                    <fieldset class="box">
                        <div class="<?php echo (empty($model->cekPersetujuan)) ? "hide" : ""; ?> persetujuan">
                            <?php $this->renderPartial('_persetujuan', array('model' => $modPers, 'form' => $form)); ?>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo $form->checkBox($model, 'cekRealisasi', array("onclick" => "slide('realisasi');")); ?>Realisasi Pengangkatan Pegawai Negeri Sipil</div>
                </div>
                <div class="panel-body">
                    <fieldset class="box">
                        <div class="<?php echo (empty($model->cekRealisasi)) ? "hide" : ""; ?> realisasi">
                            <?php $this->renderPartial('_realisasi', array('model' => $modRealisasi, 'form' => $form)); ?>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <?php if ($model->isNewRecord) { ?>
            <?php echo CHtml::htmlButton(
                $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
            ); ?>
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
                array('class' => 'btn btn-info disabled', 'type' => 'button', 'onKeypress' => 'print("PRINT");', 'onclick' => 'print("PRINT");', 'disabled' => true)
            ); ?>
        <?php } else { ?>
            <?php echo CHtml::htmlButton(
                $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true)
            ); ?>
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
                array('class' => 'btn btn-info', 'type' => 'button', 'onKeypress' => 'print("PRINT");', 'onclick' => 'print("PRINT");')
            ); ?>
        <?php } ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl('index', array('modul_id' => Yii::app()->session['modul_id'])),
            array(
                'class' => 'btn btn-default',
                'onclick' => 'return refreshForm(this);'
            )
        ); ?>
        <?php
        $content = $this->renderPartial('../tips/transaksi', array(), true);
        $this->widget('UserTips', array('type' => 'create', 'content' => $content)); ?>
    </div>
</fieldset>
<?php $this->endWidget(); ?>


<?php
$urlPrint = Yii::app()->createUrl($this->module->id . '/' . $this->id . '/print&id=' . $model->pengangkatanpns_id);
Yii::app()->clientScript->registerScript('onheadfunction', '
function slide(data){
    $("."+data).slideToggle();
}

function print(string){
    window.open("' . $urlPrint . '/&caraPrint=PRINT","","location=_new, width=900px");
}
', CClientScript::POS_HEAD); ?>