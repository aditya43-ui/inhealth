<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'bapemnelianlangsung-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>
<style>
    .form-horizontal .control-label{
        width: 135px !important;
    }
</style>
<div style="min-height: 950px !important">
    <div class="panel panel-success"> 
        <div class="panel-body" style="background-color: #fff">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title"><span class='judul'>Berita Acara Kemajuan Hasil Pekerjaan</span></div>
                </div>
                <div class="panel-body">
                    <div class="row-fluid">
                        <div class="col-sm-6">
                            <?php echo $form->textFieldRow($model, 'bakemajuanhasilpekerjaan_nomor', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->textFieldRow($model, 'nomor_beritaacara', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Nomor BA')); ?>
                            <div class="control-group">
                                <?php echo $form->labelEx($model, 'terminke', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'termin_terminke', array('readonly' => true, 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Nomor BA')); ?>
                                    <?php echo $form->hiddenField($model, 'terminke', array('readonly' => true, 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Nomor BA')); ?>
                                    <label> Dari </label>
                                    <?php echo $form->textField($model, 'termin_jumlah', array('readonly' => true, 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Nomor BA')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="control-group ">
                                <?php echo $form->labelEx($model, 'bakemajuanhasilpekerjaan_tanggal', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $model,
                                        'attribute' => 'bakemajuanhasilpekerjaan_tanggal',
                                        'mode' => 'datetime',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            'maxDate' => 'd',
                                        ),
                                        'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker4', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                                    ));
                                    ?>
                                    <?php echo $form->error($model, 'bakemajuanhasilpekerjaan_tanggal'); ?>
                                </div>
                            </div>
                            <?php echo $form->textFieldRow($model, 'tahap_pekerjaan', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                            <div class="control-group">
                                <?php echo $form->labelEx($model, 'dokumen_pendukung', array('class' => 'control-label')) ?>
                                <div class="controls" style="padding-top:6px">
                                    <?php
                                    if (!empty($model->dokumen_pendukung)) {
                                        echo CHtml::link("$model->dokumen_pendukung", $this->createUrl('Unduh', array('id' => $model->bakemajuanhasilpekerjaan_id)), array('title' => 'Unduh dokumen pendukung', 'rel' => 'tooltip', 'style' => 'color:blue;'));
                                    }
                                    ?> 
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <hr>
                        <div class="col-sm-6">

                            <p><h4><b>PIHAK KESATU</b></h4></p>
                            <div class="control-group ">
                                <?php echo $form->labelEx($model, 'pegpihakkesatu_id', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->hiddenField($model, 'pegpihakkesatu_id'); ?>
                                    <?php echo $form->textField($model, 'pegpihakkesatu_nama', array('class' => 'span4', 'readonly' => true,)); ?>
                                </div>
                            </div>
                            <div class="control-group ">
                                <?php echo $form->labelEx($model, 'NIP', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'pegpihakkesatu_nip', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'placeholder' => 'NIP Pihak Kesatu')); ?>
                                </div>
                            </div>
                            <div class="control-group ">
                                <?php echo $form->labelEx($model, 'Alamat', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textArea($model, 'pegpihakkesatu_alamat', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'placeholder' => 'Alamat Pihak Kesatu', 'rows' => 4)); ?>
                                </div>
                            </div>
                            <?php echo $form->textFieldRow($model, 'pihakkesatu_jabatan', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'placeholder' => 'Jabatan Pihak Kesatu')); ?>
                        </div>
                        <div class="col-sm-6">
                            <p><h4><b>PIHAK KEDUA</b></h4></p>
                            <div class="control-group ">
                                <?php echo $form->labelEx($model, 'supplier_id', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php
                                    echo $form->hiddenField($model, 'supplier_id', array('class' => 'supplier_id'));

                                    $supplier_nama = "";
                                    if (!empty($model->supplier_id)) {
                                        $sup = SupplierM::model()->findByPk($model->supplier_id);
                                        $supplier_nama = $sup->supplier_nama;
                                    }
                                    echo $form->textField($model, 'supplier_nama', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'placeholder' => 'Nama Supplier'));
                                    ?>
                                </div>
                            </div>
                            <div class="control-group ">
                                <?php echo $form->labelEx($model, 'Direktur', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'direktur', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'placeholder' => 'Direktur Penyedia')); ?>
                                </div>
                            </div>
                            <div class="control-group ">
                                <?php echo $form->labelEx($model, 'Alamat', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textArea($model, 'alamat_penyedia', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'placeholder' => 'Alamat Penyedia', 'rows' => 4)); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title"><span class='judul'>Lampiran</span></div>
                </div>
                <div class="panel-body">
                    <?php $this->renderPartial('_formLampiran2', array('model' => $model, 'modSPK' => $modSPK, 'modelDetail' => $modelDetail, 'modSPKRincian' => $modSPKRincian, 'form' => $form)); ?>
                </div>
            </div>
            <br>

        </div> 
    </div> 
</div> 

<?php
$this->endWidget();

$urlGetKHP = $this->createUrl('GetKHP');
$suratperjanjiankerja_id = $_GET['suratperjanjiankerja_id'];
?>