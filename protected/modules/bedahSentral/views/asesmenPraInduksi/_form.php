<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'asesmenprainduksi-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
));
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>
<?php echo $form->hiddenField($model, 'pasien_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pendaftaran_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pasienadmisi_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pasienmasukpenunjang_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php //echo $form->textFieldRow($model,'rencanaoperasi_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);"));  
?>
<?php echo $form->hiddenField($model, 'jenisanastesi_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

<div class="col-sm-6">
    <?php echo $form->radioButtonListRow($model, 'statusfisik_asa', array("1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5", "E" => "E"), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textFieldRow($model, 'beratbadan', array('class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    <div class="control-group">
        <label class="control-label">Tekanan Darah</label>
        <div class="controls">
            <?php echo $form->textField($model, 'td_sitolik', array('class' => 'span1  numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <label> /</label>
            <?php echo $form->textField($model, 'td_diastolik', array('class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'detaknadi', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'detaknadi', array('class' => 'span1  numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <label> x/menit</label>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'suhutubuh', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'suhutubuh', array('class' => 'span1  float2', 'onkeyup' => 'validDesimal(this)')); ?>
            <label> &deg;C</label>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'hb_pasien', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'hb_pasien', array('class' => 'span1  numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <label> g/dl</label>
        </div>
    </div>
    <br>
    <div class="panel panel-dark">
        <span class="group-title">
            Pramedikasi
        </span>
        <div class="panel-body">
            <?php
            echo $this->renderPartial($this->path_view . "_premedikasi", array(
                'form' => $form, 'model' => $model,
            ));
            ?>

        </div>
    </div>
</div>
<div class="col-sm-6">
    <?php
    $jenis = JenisAnastesiM::model()->findByPk($model->jenisanastesi_id);
    $jenis_nama = "";

    if (!empty($jenis)) {
        $jenis_nama = $jenis->jenisanastesi_nama;
    }
    ?>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'jenisanastesi_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            echo CHtml::textField('jenisanestesi_nama', $jenis_nama, array(
                'class' => 'span3', 'readonly' => true,
            ));
            ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($model, 'teknikanastesi', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->radioButtonListRow($model, 'resiko_anastesi', array("1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5"), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    <div class="control-group">
        <label class="control-label">Rencana Operasi</label>
        <div class="controls">
            <?php
            $listRencana = RencanaoperasiT::model()->findAllByAttributes(array(
                'pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id,
            ));

            $str_rencana = "";
            foreach ($listRencana as $item) {
                if (!empty($item->operasi)) {
                    $str_rencana .= "- " . $item->operasi->operasi_nama . "\n";
                }
            }

            echo CHtml::textArea('list_operasi', $str_rencana, array(
                'class' => 'span3', 'readonly' => true,
            ));
            ?>
        </div>
    </div>
    <?php echo $form->textAreaRow($model, 'spesimen_diambil', array('rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    <?php
    echo $form->radioButtonListRow($model, 'posisi_pasien', array(
        "Terlentang" => "Terlentang",
        "Tengkurap" => "Tengkurap",
        "Lototomi" => "Litotomi",
        "Miring" => "Miring",
        "Duduk" => "Duduk",
    ), array('uncheckValue' => null, 'onkeyup' => "return $(this).focusNextInputField(event);"));
    ?>
    <?php
    echo $form->radioButtonListRow($model, 'hasil_asesmen', array(
        "Toleransi baik, dilakukan induksi anestesia" => "Toleransi baik, dilakukan induksi anestesia",
        "Toleransi kurang, dicoba terapi dulu, perbaikan terjadi, dilakukan induksi anestesi" => "Toleransi kurang, dicoba terapi dulu, perbaikan terjadi, dilakukan induksi anestesi",
        "Tidak ada perbaikan dalam 15 menit, operasi ditunda" => "Tidak ada perbaikan dalam 15 menit, operasi ditunda"
    ), array('uncheckValue' => null, 'onkeyup' => "return $(this).focusNextInputField(event);"));
    ?>

</div>
<div class="clear"></div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang', 
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    );
    ?>
    <?php // echo CHtml::link(Yii::t('mds','{icon} Pengaturan AsesmenprainduksiT',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));  
    ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
        array('class' => 'btn btn-info', 'onKeypress' => 'return formSubmit(this,event)', 'onclick' => 'print();', 'disabled' => $model->isNewRecord)
    ); ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>
<?php $this->endWidget(); ?>

<?php
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.integer',
    'config' => array(
        'defaultZero' => true,
        'allowZero' => true,
        'allowDecimal' => true,
        'decimal' => '.',
        'thousands' => '',
        'precision' => 0,
    )
));
?>

<script>
    function print() {
        window.open("<?php
                        echo $this->createUrl('print', array(
                            'pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id
                        ));
                        ?>&caraPrint=PRINT", "", 'location=_new, width=900px');
    }

    // untuk validasi agar inputan tidak lebih dari 100
    function validDesimal(obj) {
        //console.log($(obj).val());
        var data = $(obj).val().replace('.', '');
        data = data.replace(',', '.')
        //console.log(parseFloat(100));
        //console.log(parseFloat(data));

        if (parseFloat(data) > parseFloat(99.99)) {
            //alert("Data tidak bisa lebih dari 100,00");
            $(obj).val(0);
        }

    }
</script>