<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sadokrekammedis-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">

    <div class="col-sm-4">
        <?php
        echo $form->dropDownListRow($model, 'warnadokrm_id', CHtml::listData($model->getWarnaItems(), 'warnadokrm_id', 'warnadokrm_namawarna'), array('empty' => '-- Pilih Warna Dokumen RM --', 'style' => 'width:180px;', 'onkeypress' => "return $(this).focusNextInputField(event)"));
        echo $form->dropDownListRow($model, 'subrak_id', CHtml::listData($model->getSubrakItems(), 'subrak_id', 'subrak_nama'), array('empty' => '-- Pilih Subrak --', 'style' => 'width:180px;', 'onkeypress' => "return $(this).focusNextInputField(event)"));
        echo $form->dropDownListRow($model, 'lokasirak_id', CHtml::listData($model->getLokasirakItems(), 'lokasirak_id', 'lokasirak_nama'), array('empty' => '-- Pilih Lokasi Rak --', 'style' => 'width:180px;', 'onkeypress' => "return $(this).focusNextInputField(event)"));
        echo $form->labelEx($model, 'pasien_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'nama_pasien',
                'value' => $model->nama_pasien,
                'source' => 'js: function(request, response) {
												   $.ajax({
													   url: "' . $this->createUrl('AutocompleteNamaPasien') . '",
													   dataType: "json",
													   data: {
														   nama_pasien: request.term,
													   },
													   success: function (data) {
															   response(data);
													   }
												   })
												}',
                'options' => array(
                    'minLength' => 1,
                    'focus' => 'js:function( event, ui ) {
												 $(this).val("");
												 return false;
											 }',
                    'select' => 'js:function( event, ui ) {
												$(this).val(ui.item.value);
												$("#SADokrekammedisM_pasien_id").val(ui.item.pasien_id);
												return false;
											}',
                ),
                'tombolDialog' => array('idDialog' => 'dialogPasien'),
                'htmlOptions' => array(
                    'placeholder' => 'Nama Pasien', 'rel' => 'tooltip', 'title' => '"Ketik Nama Pasien" / klik icon untuk mencari data pasien', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    'onblur' => 'if(this.value===""){ $("#' . CHtml::activeId($model, 'pasien_id') . '").val(""); }'
                ),
            ));
            ?>
        </div>
        <?php
        echo $form->error($model, 'pasien_id');
        echo $form->hiddenField($model, 'pasien_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10));
        echo $form->textFieldRow($model, 'nodokumenrm', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'readonly' => true));
        ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tglrekammedis', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->tglrekammedis = (!empty($model->tglrekammedis) ? date("d/m/Y", strtotime($model->tglrekammedis)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglrekammedis',
                    'mode' => 'date',
                    'options' => array(
                        'showOn' => false,
                        'maxDate' => 'd',
                        'yearRange' => "-150:+0",
                    ),
                    'htmlOptions' => array(
                        'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'width:155px;'
                    ),
                )); ?>
                <?php echo $form->error($model, 'tglrekammedis'); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tglmasukrak', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->tglmasukrak = (!empty($model->tglmasukrak) ? date("d/m/Y", strtotime($model->tglmasukrak)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglmasukrak',
                    'mode' => 'date',
                    'options' => array(
                        'showOn' => false,
                        'maxDate' => 'd',
                        'yearRange' => "-150:+0",
                    ),
                    'htmlOptions' => array(
                        'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'width:155px;'
                    ),
                )); ?>
                <?php echo $form->error($model, 'tglmasukrak'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tglkeluarakhir', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->tglkeluarakhir = (!empty($model->tglkeluarakhir) ? date("d/m/Y", strtotime($model->tglkeluarakhir)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglkeluarakhir',
                    'mode' => 'date',
                    'options' => array(
                        'showOn' => false,
                        'maxDate' => 'd',
                        'yearRange' => "-150:+0",
                    ),
                    'htmlOptions' => array(
                        'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'width:155px;'
                    ),
                )); ?>
                <?php echo $form->error($model, 'tglkeluarakhir'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tglmasukakhir', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->tglmasukakhir = (!empty($model->tglmasukakhir) ? date("d/m/Y", strtotime($model->tglmasukakhir)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglmasukakhir',
                    'mode' => 'date',
                    'options' => array(
                        'showOn' => false,
                        'maxDate' => 'd',
                        'yearRange' => "-150:+0",
                    ),
                    'htmlOptions' => array(
                        'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'width:155px;'
                    ),
                )); ?>
                <?php echo $form->error($model, 'tglmasukakhir'); ?>
            </div>
        </div>
        <?php
        echo $form->textFieldRow($model, 'nomortertier', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 2));
        echo $form->textFieldRow($model, 'nomorsekunder', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 2));
        ?>
    </div>
    <div class="col-sm-4">
        <?php echo $form->textFieldRow($model, 'nomorprimer', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 2)); ?>
        <?php echo $form->textFieldRow($model, 'warnanorm_i', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'warnanorm_ii', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tgl_in_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->tgl_in_aktif = (!empty($model->tgl_in_aktif) ? date("d/m/Y", strtotime($model->tgl_in_aktif)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_in_aktif',
                    'mode' => 'date',
                    'options' => array(
                        'showOn' => false,
                        'maxDate' => 'd',
                        'yearRange' => "-150:+0",
                    ),
                    'htmlOptions' => array(
                        'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'width:155px;'
                    ),
                )); ?>
                <?php echo $form->error($model, 'tgl_in_aktif'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tglpemusnahan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->tglpemusnahan = (!empty($model->tglpemusnahan) ? date("d/m/Y", strtotime($model->tglpemusnahan)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglpemusnahan',
                    'mode' => 'date',
                    'options' => array(
                        'showOn' => false,
                        'maxDate' => 'd',
                        'yearRange' => "-150:+0",
                    ),
                    'htmlOptions' => array(
                        'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'width:155px;'
                    ),
                )); ?>
                <?php echo $form->error($model, 'tglpemusnahan'); ?>
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
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Dokumen Rekam Medis', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php $content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit5a', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
</div>

<?php $this->endWidget(); ?>

<?php
//========= Dialog buat data pasien  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Data Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
    ),
));
$this->renderPartial($this->path_view . '_dataPasien');

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end data pasien =============================
?>

<script type="text/javascript">
    function inputPasien(pasien_id, namaPasien) {
        $("#SADokrekammedisM_pasien_id").val(pasien_id);
        $("#SADokrekammedisM_nama_pasien").val(namaPasien);
        $("#dialogPasien").dialog('close');
    }
</script>