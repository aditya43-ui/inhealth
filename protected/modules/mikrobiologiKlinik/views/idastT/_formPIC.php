<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'analis_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'analis_id'); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'analis_nama',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('autocompleteAnalis') . '",
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
                            $("#' . Chtml::activeId($model, 'analis_nim') . '").val(ui.item.nomorindukpegawai); 
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            $("#' . Chtml::activeId($model, 'analis_id') . '").val(ui.item.pegawai_id);
                            $("#' . Chtml::activeId($model, 'analis_nim') . '").val(ui.item.nomorindukpegawai); 
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'class' => 'span3 namaPegawai',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => 'Ketikan Nama Pegawai',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogAnalis', 'idTombol' => 'tombolPegpjphp'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('NIM/NIP', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'analis_nim', array('class'=>'span3','readonly'=>true)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'verifikator_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'verifikator_id'); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'verifikator_nama',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('autocompleteVerifikator') . '",
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
                            $("#' . Chtml::activeId($model, 'verifikator_nim') . '").val(ui.item.nomorindukpegawai); 
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            $("#' . Chtml::activeId($model, 'verifikator_id') . '").val(ui.item.pegawai_id); 
                            $("#' . Chtml::activeId($model, 'verifikator_nim') . '").val(ui.item.nomorindukpegawai); 
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'class' => 'span3 namaPegawai',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => 'Ketikan Nama Pegawai',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogVerifikator', 'idTombol' => 'tombolPegpjphp'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('NIM/NIP', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'verifikator_nim', array('class'=>'span3','readonly'=>true)); ?>
            </div>
        </div>
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAnalis',
    'options' => array(
        'title' => 'Pencarian Analis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modAnalis = new PegawairuanganV('searchDialogPegRuangan');
$modAnalis->unsetAttributes();
$modAnalis->pegawai_aktif = true;
if (isset($_GET['PegawairuanganV'])) {
    $modAnalis->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pihakkesatu-grid',
    'dataProvider' => $modAnalis->searchDialogPegRuangan(),
    'filter' => $modAnalis,
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
                    $(\"#' . CHtml::activeId($model, 'analis_id') . '\").val(\"$data->pegawai_id\");
                    $(\"#' . CHtml::activeId($model, 'analis_nama') . '\").val(\"$data->nama_pegawai\");
                    $(\"#' . CHtml::activeId($model, 'analis_nim') . '\").val(\"$data->nomorindukpegawai\");
                    $(\"#dialogAnalis\").dialog(\"close\"); 
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
            'filter' => CHtml::activeTextField($modAnalis, 'nama_pegawai'),
            'value' => '$data->namaLengkap',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogVerifikator',
    'options' => array(
        'title' => 'Pencarian Verifikator',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modVerifikator = new PegawairuanganV('searchDialogPegRuangan');
$modVerifikator->unsetAttributes();
$modVerifikator->pegawai_aktif = true;
$modVerifikator->kelompokpegawai_id = 1;
if (isset($_GET['PegawairuanganV'])) {
    $modVerifikator->attributes = $_GET['PegawairuanganV'];
    $modVerifikator->kelompokpegawai_id = 1;
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pihakkedua-grid',
    'dataProvider' => $modVerifikator->searchDialogPegRuangan(),
    'filter' => $modVerifikator,
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
                    $(\"#' . CHtml::activeId($model, 'verifikator_id') . '\").val(\"$data->pegawai_id\");
                    $(\"#' . CHtml::activeId($model, 'verifikator_nama') . '\").val(\"$data->nama_pegawai\");
                    $(\"#' . CHtml::activeId($model, 'verifikator_nim') . '\").val(\"$data->nomorindukpegawai\");
                    $(\"#dialogVerifikator\").dialog(\"close\"); 
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
            'filter' => CHtml::activeTextField($modVerifikator, 'nama_pegawai'),
            'value' => '$data->namaLengkap',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>