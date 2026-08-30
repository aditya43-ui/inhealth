<div class="row-fluid">
    <div class="col-sm-6">

        <?php echo $form->textFieldRow($model, 'bapembelianlangsung_nomor', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'nomor_beritaacara', array('readonly' => false, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Nomor BA')); ?>

    </div>
    <div class="col-sm-6">

        <div class="control-group ">
            <?php echo $form->labelEx($model, 'bapembelianlangsung_tanggal', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'bapembelianlangsung_tanggal',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span4 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                ));
                ?>
                <?php echo $form->error($model, 'bapembelianlangsung_tanggal'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'dokumen_pendukung', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->fileField($model, 'dokumen_pendukung', array('class' => 'span3 ', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?> 
                <?php
                if (!empty($model->dokumen_pendukung)) {
                    echo CHtml::link("$model->dokumen_pendukung", $this->createUrl('Unduh', array('id' => $model->bapembelianlangsung_id)), array('title' => 'Unduh dokumen pendukung', 'rel' => 'tooltip', 'style' => 'color:blue;'));
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
                <?php
                    echo $form->textField($model, 'pegpihakkesatu_nama', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true));
                    /*if(!empty($model->pegpihakkesatu_id)){
                        echo $form->textField($model, 'pegpihakkesatu_nama', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true));
                    }else{
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'pegpihakkesatu_nama',
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
                                    $("#' . Chtml::activeId($model, 'pegpihakkesatu_id') . '").val(ui.item.pegawai_id); 
                                    $("#' . Chtml::activeId($model, 'pegpihakkesatu_nip') . '").val(ui.item.nomorindukpegawai); 
                                    $("#' . Chtml::activeId($model, 'pegpihakkesatu_alamat') . '").val(ui.item.alamat_pegawai); 
                                    return false;
                                }',
                            ),
                            'htmlOptions' => array(
                                'class' => 'span4 namaPegawai',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'placeholder' => 'Ketikan nama pihak kesatu',
                            ),
                            'tombolDialog'=>array('idDialog'=>'dialogPihak1','idTombol'=>'tombolPihak1'),
                        ));
                    }*/                 
                ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'NIP', array('class' => 'control-label','label'=>'NIP')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'pegpihakkesatu_nip', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'placeholder' => 'NIP Pihak Kesatu')); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'Alamat', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($model, 'pegpihakkesatu_alamat', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'placeholder' => 'Alamat Pihak Kesatu')); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'pihakkesatu_jabatan', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'placeholder' => 'Jabatan Pihak Kesatu')); ?>
    
    </div>
    <div class="col-sm-6">
        <p><h4><b>PIHAK KEDUA</b></h4></p>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'pegpihakkedua_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegpihakkedua_id'); ?>
                <?php echo $form->textField($model, 'pegpihakkedua_nama', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'placeholder' => 'Nama Pihak Kedua')); ?>
                <?php
//                    $this->widget('MyJuiAutoComplete', array(
//                    'model' => $model,
//                    'attribute' => 'pegpihakkedua_nama',
//                    'source' => 'js: function(request, response) {
//                        $.ajax({
//                            url: "' . $this->createUrl('getPegawai') . '",
//                            dataType: "json",
//                            data: {
//                                term: request.term,
//                            },
//                            success: function (data) {
//                                response(data);
//                            }
//                        })
//                     }',
//                    'options' => array(
//                        'showAnim' => 'fold',
//                        'minLength' => 2,
//                        'focus' => 'js:function( event, ui ) {
//                            $(this).val( ui.item.nama_pegawai);
//                            return false;
//                        }',
//                        'select' => 'js:function( event, ui ) {
//                            $("#' . Chtml::activeId($model, 'pegpihakkedua_id') . '").val(ui.item.pegawai_id); 
//                            $("#' . Chtml::activeId($model, 'pegpihakkedua_nip') . '").val(ui.item.nomorindukpegawai); 
//                            $("#' . Chtml::activeId($model, 'pegpihakkedua_alamat') . '").val(ui.item.alamat_pegawai); 
//                            return false;
//                        }',
//                    ),
//                    'htmlOptions' => array(
//                        'class' => 'span4 namaPegawai',
//                        'onkeypress' => "return $(this).focusNextInputField(event)",
//                        'placeholder' => 'Ketikan nama pihak kedua',
//                    ),
//                    'tombolDialog'=>array('idDialog'=>'dialogPihak2','idTombol'=>'tombolPihak2'),
//                ));
                ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'NIP', array('class' => 'control-label','label'=>'NIP')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'pegpihakkedua_nip', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'placeholder' => 'NIP Pihak Kedua')); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'Alamat', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($model, 'pegpihakkedua_alamat', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'placeholder' => 'Alamat Pihak Kedua')); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'pihakkedua_jabatan', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'placeholder' => 'Jabatan Pihak Kedua')); ?>
    
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
                    $(\"#' . CHtml::activeId($model, 'pegpihakkesatu_id') . '\").val(\"$data->pegawai_id\");
                    $(\"#' . CHtml::activeId($model, 'pegpihakkesatu_nama') . '\").val(\"$data->nama_pegawai\");
                    $(\"#' . CHtml::activeId($model, 'pegpihakkesatu_nip') . '\").val(\"$data->nomorindukpegawai\");
                    $(\"#' . CHtml::activeId($model, 'pegpihakkesatu_alamat') . '\").val(\"$data->alamat_pegawai\");
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
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPihak2',
    'options' => array(
        'title' => 'Pencarian Pegawai Pihak Kedua',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPihak2 = new PegawaiV('search');
$modPihak2->unsetAttributes();
$modPihak2->pegawai_aktif = true;
if (isset($_GET['PegawaiV'])) {
    $modPihak2->attributes = $_GET['PegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pihakkeduau-grid',
    'dataProvider' => $modPihak2->search(),
    'filter' => $modPihak2,
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
                    $(\"#dialogPihak2\").dialog(\"close\"); 
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
            'filter' => CHtml::activeTextField($modPihak2, 'nama_pegawai'),
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modPihak2, 'jabatan_id', CHtml::listData(
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