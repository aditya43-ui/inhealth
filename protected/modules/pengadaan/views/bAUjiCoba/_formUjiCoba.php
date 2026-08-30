<div class="row-fluid">
    <div class="col-md-6">
        <?php echo $form->textFieldRow($model, 'baujifungsi_nomor', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'nomor_beritaacara', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Nomor BA')); ?>
    </div>
    <div class="col-md-6">
        <div class="control-group ">
            <label class="control-label"> Tanggal Pembuatan BA <span class="required">*</span> </label>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'baujifungsi_tanggal',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                    ));
                    ?>
                    <?php echo $form->error($model, 'baujifungsi_tanggal'); ?>
                </div>
            </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'Termin Ke', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'terminke', array('class'=>'span1','readonly'=>true)); ?>
            </div>
            <label class="control-label" style="width: 35px">Dari</label>
            <div class="controls">
                <?php echo $form->textField($model, 'jumlah_termin', array('class'=>'span1','readonly'=>true)); ?>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Dokumen Pendukung</label>
            <div class="controls">
            <?php
//                echo CHtml::link("Browse",'javascript:;',array('onclick'=>'fileLoad(this);','class'=>'btn btn-primary')).'&nbsp;'.CHtml::link("<u></u>",'javascript:;',array('onclick'=>'fileLoad(this);','class'=>'labelbrowse'));
//                echo CHtml::activeHiddenField($model, 'temp_file',array('readonly' => true, 'class'=>'temp_picture_nama'));
//                echo "<br/>".CHtml::link("<u>".$model->temp_file."</u>",$this->createUrl('unduh',array('id'=>$model->baujifungsi_id)),array('rel'=>'tooltip','data-original-title'=>'Klik untuk mengunduh file', 'style'=>'color:blue;', 'target'=>'_BLANK'));
//                echo "<div class='hide'>";
//                echo CHtml::activeFileField($model,'dokumen_pendukung',array( 'onchange'=>'cekFile(this);','accept'=>'application/pdf,.pdf',));
//                echo "</div>";                                   
//                echo '<br/><span style="color:red;font-size:10px;"><i>File berformat PDF dan maks 5mb</i></span>';
                    
                    echo $form->fileField($model, 'dokumen_pendukung', array('onchange'=>'cekFile(this);','accept'=>'application/pdf,.pdf','class' => 'span3 ', 'onkeyup' => "return $(this).focusNextInputField(event);"));

                   if (!empty($model->dokumen_pendukung)) {
                       echo CHtml::link("$model->dokumen_pendukung", $this->createUrl('Unduh', array('id' => $model->baujifungsi_id)), array('title' => 'Unduh dokumen pendukung', 'rel' => 'tooltip', 'style' => 'color:blue;'));
                   }            
            ?>    
            </div>
        </div>  
    </div>
</div>

    <hr>
<div class="row-fluid">
    <div class="col-md-6">
        <div class="control-group ">
            <label class="control-label"> Kepala Bidang / Bagian / Instalasi <span class="required">*</span> </label>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegawai_id'); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'pegawai_nama',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . Yii::app()->createUrl('ActionAutoComplete/getPegawaiKepalaBidang') . '",
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
                            $("#' . Chtml::activeId($model, 'pegawai_id') . '").val(ui.item.pegawai_id); 
                            $("#' . Chtml::activeId($model, 'pegawai_nama') . '").val(ui.item.nama_pegawai); 
                            $("#' . Chtml::activeId($model, 'nomorindukpegawai') . '").val(ui.item.nomorindukpegawai); 
                            $("#' . Chtml::activeId($model, 'pegawai_jabatan') . '").val(ui.item.jabatan_nama); 
                            $("#' . Chtml::activeId($model, 'pegawai_unitkerja') . '").val(ui.item.namaunitkerja); 
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'class' => 'span3 namaPegawai required',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => 'Ketikan Nama Pegawai',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogKepalaBidang', 'idTombol' => 'tombolKepalaBidang'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label"> NIP </label>
            <div class="controls">
                <?php echo $form->textField($model, 'nomorindukpegawai', array('disabled' => true, 'class' => 'span3')); ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="control-group ">
            <label class="control-label"> Jabatan <span class="required">*</span> </label>
            <div class="controls">
                <?php echo $form->textField($model, 'pegawai_jabatan', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label"> Unit Kerja <span class="required">*</span> </label>
            <div class="controls">
                <?php echo $form->textField($model, 'pegawai_unitkerja', array('readonly' => true, 'class' => 'span3')); ?>
            </div>
        </div>
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogKepalaBidang',
    'options' => array(
        'title' => 'Pencarian Pegawai Kepala Bidang / Bagian / Instalasi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPihak1 = new PegawaiM('search');
$modPihak1->unsetAttributes();
$modPihak1->pegawai_aktif = true;
if (isset($_GET['PegawaiM'])) {
    $modPihak1->attributes = $_GET['PegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialog-grid',
    'dataProvider' => $modPihak1->searchKepalaunit(),
    'filter' => $modPihak1,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                "href"=>"",
                "id" => "a",
                "onClick" => "
                    $(\"#' . CHtml::activeId($model, 'pegawai_id') . '\").val(\"$data->pegawai_id\");
                    $(\"#' . CHtml::activeId($model, 'pegawai_nama') . '\").val(\"$data->nama_pegawai\");
                    $(\"#' . CHtml::activeId($model, 'nomorindukpegawai') . '\").val(\"$data->nomorindukpegawai\");
                    $(\"#' . CHtml::activeId($model, 'pegawai_jabatan') . '\").val(\"$data->jabatan_nama\");
                    $(\"#' . CHtml::activeId($model, 'pegawai_unitkerja') . '\").val(\"$data->namaunitkerja\");
                    $(\"#dialogKepalaBidang\").dialog(\"close\"); 
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
        array(
            'header' => 'Unit Kerja',
            'name' => 'unitkerja_id',
            'filter' => CHtml::activeDropDownList($modPihak1, 'unitkerja_id', CHtml::listData(
                            UnitkerjaM::model()->findAll('unitkerja_aktif = true order by namaunitkerja'), 'unitkerja_id', 'namaunitkerja'
                    ), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                if (empty($data->unitkerja_id))
                    return "-";
                $unit = UnitkerjaM::model()->findByPk($data->unitkerja_id);
                return $unit->namaunitkerja;
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>