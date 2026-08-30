<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/ckeditor/ckeditor.js"></script><p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>


<div class="row-fluid">
    <div class="col-md-6">
        <?php echo $form->textFieldRow($model, 'bapenyerahanbarangjasa_nomor', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'nomor_beritaacara', array('readonly' => false, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Nomor BA')); ?>

    </div>
    <div class="col-md-6">
        <div class="control-group ">
            <?php echo CHtml::label("Tanggal Pembuatan BA", 'bapenyerahanbarangjasa_tanggal', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'bapenyerahanbarangjasa_tanggal',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span4 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                ));
                ?>
                <?php echo $form->error($model, 'bapenyerahanbarangjasa_tanggal'); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'terminke', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'termin_ke', array('class' => 'span1', 'readonly' => true)); ?>
            </div>
            <label class="control-label" style="width: 35px !important">Dari</label>
            <div class="controls">
                <?php echo $form->textField($model, 'total_termin', array('class' => 'span1', 'readonly' => true)); ?>
            </div>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'terminke', array('class' => 'span1', 'readonly' => true)); ?>
                <?php echo $form->hiddenField($model, 'termin_persen', array('class' => 'span1', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'dokumen_pendukung', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->fileField($model, 'dokumen_pendukung', array('class' => 'span3 ', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?> 
                <?php
                if (!empty($model->dokumen_pendukung)) {
                    echo CHtml::link("$model->dokumen_pendukung", $this->createUrl('Unduh', array('id' => $model->bapenyerahanbarangjasa_id)), array('title' => 'Unduh dokumen pendukung', 'rel' => 'tooltip', 'style' => 'color:blue;'));
                }
                ?> 
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row-fluid">
    <div class="col-md-6">
        <p><h4><b>PIHAK KESATU</b></h4></p>
        <div class="control-group ">
            <?php echo CHtml::label('Nama Pegawai', 'nomor_beritaacara', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegpihakkesatu_id'); ?>
                <?php echo $form->textField($model, 'pegpihakkesatu_nama', array('class' => 'span4', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('NIP', 'nomor_beritaacara', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'pegpihakkesatu_nip', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'placeholder' => 'NIP Pihak Kesatu')); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Alamat', 'nomor_beritaacara', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($model, 'pegpihakkesatu_alamat', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'placeholder' => 'Alamat Pihak Kesatu', 'rows' => 4)); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Jabatan <span class="required">*</span>', 'nomor_beritaacara', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'jabatan_pihakkesatu', array('class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => false, 'placeholder' => 'Alamat Pihak Kesatu', 'rows' => 4)); ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <p><h4><b>PIHAK KEDUA</b></h4></p>
        <div class="control-group ">
            <?php echo CHtml::label('Nama Pegawai <span class="required">*</span>', 'nomor_beritaacara', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegpihakkedua_id'); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'pegpihakkedua_nama',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('getPegawai') . '",
                            dataType: "json",
                            data: {
                                term: request.term,
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                     }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                            $(this).val( ui.item.nama_pegawai);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            $("#' . Chtml::activeId($model, 'pegpihakkedua_id') . '").val(ui.item.pegawai_id); 
                            $("#' . Chtml::activeId($model, 'pegpihakkedua_nip') . '").val(ui.item.nomorindukpegawai); 
                            $("#' . Chtml::activeId($model, 'pegpihakkedua_alamat') . '").val(ui.item.alamat_pegawai); 
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'class' => 'span4 namaPegawai required',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => 'Ketikan Nama Pihak Kedua',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPihak1', 'idTombol' => 'tombolPihak1'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('NIP', 'nomor_beritaacara', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'pegpihakkedua_nip', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'placeholder' => 'NIP Pihak Kedua')); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Alamat', 'nomor_beritaacara', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($model, 'pegpihakkedua_alamat', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'placeholder' => 'Alamat Pihak Kedua', 'rows' => 4)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Jabatan <span class="required">*</span>', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'jabatan_pihakkedua', LookupM::getItems("jabatanpenyerahanbarang"), array('class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --'));
                ?>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row-fluid">
    <div class="control-group">
        <?php echo CHtml::label('Dengan ini menyatakan', '', array('class' => 'control-label')); ?>
        <div class="controls" style="width:75%;">
            <?php echo $form->textArea($model, 'pernyataan', array('class' => 'form-control ckeditor')); ?>           
        </div>
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPihak1',
    'options' => array(
        'title' => 'Pencarian Pegawai Pihak Kesatu',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPihak1 = new PegawaiV('search');
$modPihak1->unsetAttributes();
$modPihak1->pegawai_aktif = true;
if (isset($_GET['PegawaiV'])) {
    $modPihak1->attributes = $_GET['PegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pihakkesatu-grid',
    'dataProvider' => $modPihak1->search(),
    'filter' => $modPihak1,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                "href"=>"",
                "id" => "selectObat",
                "onClick" => "
                    $(\"#' . CHtml::activeId($model, 'pegpihakkedua_id') . '\").val(\"$data->pegawai_id\");
                    $(\"#' . CHtml::activeId($model, 'pegpihakkedua_nama') . '\").val(\"$data->nama_pegawai\");
                    $(\"#' . CHtml::activeId($model, 'pegpihakkedua_nip') . '\").val(\"$data->nomorindukpegawai\");
                    $(\"#' . CHtml::activeId($model, 'pegpihakkedua_alamat') . '\").val(\"$data->alamat_pegawai\");
                    $(\"#dialogPihak1\").dialog(\"close\"); 
                    return false;
                "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPihak1, 'nama_pegawai'),
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modPihak1, 'jabatan_id', CHtml::listData(
                            JabatanM::model()->findAll('jabatan_aktif = true order by jabatan_nama'), 'jabatan_id', 'jabatan_nama'
                    ), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                if (empty($data->jabatan_id))
                    return "-";
                $jabatan = JabatanM::model()->findByPk($data->jabatan_id);
                return $jabatan->jabatan_nama;
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>

<script>
    $(".ckeditor").ckeditor();
</script>