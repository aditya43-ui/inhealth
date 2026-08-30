<?php echo $form->errorSummary($model); ?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'tglpemusnahan', array('readonly' => true, 'class' => 'span3 realtime', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php
        if (isset($_GET['pemusnahanobatalkes_id'])) {
            echo $form->textFieldRow($model, 'nopemusnahan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20));
        }
        ?>
        <div class="control-group">
            <?php echo CHtml::label('Instalasi Tujuan', 'instalasiasal_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList(
                    $model,
                    'instalasiasal_id',
                    $instalasiAsals,
                    array(
                        'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onchange' => 'refreshDialogObatAlkes();',
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($model))),
                            'update' => "#" . CHtml::activeId($model, 'ruanganasal_id'),
                        )
                    )
                ); ?>
            </div>
        </div>
        <?php echo $form->dropDownListRow($model, 'ruanganasal_id', $ruanganAsals, array('empty' => '-- Pilih --', 'onchange' => 'refreshDialogObatAlkes();', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'pegawaimengetahui_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegawaimengetahui_id', array('readonly' => true)); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'pegawaimengetahui_nama',
                    'source' => 'js: function(request, response) {
							$.ajax({
								url: "' . $this->createUrl('AutocompletePegawaiMengetahui') . '",
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
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                                $(this).val( ui.item.label);
                                return false;
                            }',
                        'select' => 'js:function( event, ui ) {
                                $("#' . CHtml::activeId($model, 'pegawaimengetahui_id') . '").val(ui.item.pegawai_id); 
                                return false;
                            }',
                    ),
                    'htmlOptions' => array(
                        'class' => 'span3',
                        'placeholder' => 'Pegawai Mengetahui',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#' . CHtml::activeId($model, 'pegawaimengetahui_id') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'pegawaimenyetujui_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegawaimenyetujui_id', array('readonly' => true)); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'pegawaimenyetujui_nama',
                    'source' => 'js: function(request, response) {
						$.ajax({
							url: "' . $this->createUrl('AutocompletePegawaiMenyetujui') . '",
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
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
							$(this).val( ui.item.label);
							return false;
						}',
                        'select' => 'js:function( event, ui ) {
							$("#' . CHtml::activeId($model, 'pegawaimenyetujui_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
                    ),
                    'htmlOptions' => array(
                        'class' => 'span3',
                        'placeholder' => 'Pegawai Menyetujui',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#' . CHtml::activeId($model, 'pegawaimenyetujui_id') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawaiMenyetujui'),
                ));
                ?>
            </div>
        </div>
        <?php echo $form->textAreaRow($model, 'keterangan', array('placeholder' => 'Keterangan', 'rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>

<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiMengetahui',
    'options' => array(
        'title' => 'Pencarian Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPegawaiMengetahui = new GFPegawaiV('search');
$modPegawaiMengetahui->unsetAttributes();
if (isset($_GET['GFPegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['GFPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimengetahui-grid',
    'dataProvider' => $modPegawaiMengetahui->search(),
    'filter' => $modPegawaiMengetahui,
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
                                                  $(\"#' . CHtml::activeId($model, 'pegawaimengetahui_id') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#' . CHtml::activeId($model, 'pegawaimengetahui_nama') . '\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Gelar Depan',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
            'value' => '$data->gelardepan',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Gelar Belakang',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'gelarbelakang_nama'),
            'value' => '$data->gelarbelakang_nama',
        ),
        array(
            'header' => 'Alamat Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'alamat_pegawai'),
            'value' => '$data->alamat_pegawai',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>

<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiMenyetujui',
    'options' => array(
        'title' => 'Pencarian Pegawai Menyetujui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPegawaiMenyetujui = new GFPegawaiV('search');
$modPegawaiMenyetujui->unsetAttributes();
if (isset($_GET['GFPegawaiV'])) {
    $modPegawaiMenyetujui->attributes = $_GET['GFPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimenyetujui-grid',
    'dataProvider' => $modPegawaiMenyetujui->search(),
    'filter' => $modPegawaiMenyetujui,
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
                                                  $(\"#' . CHtml::activeId($model, 'pegawaimenyetujui_id') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#' . CHtml::activeId($model, 'pegawaimenyetujui_nama') . '\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMenyetujui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'filter' =>  CHtml::activeTextField($modPegawaiMenyetujui, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Gelar Depan',
            'filter' =>  CHtml::activeTextField($modPegawaiMenyetujui, 'gelardepan'),
            'value' => '$data->gelardepan',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMenyetujui, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Gelar Belakang',
            'filter' =>  CHtml::activeTextField($modPegawaiMenyetujui, 'gelarbelakang_nama'),
            'value' => '$data->gelarbelakang_nama',
        ),
        array(
            'header' => 'Alamat Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMenyetujui, 'alamat_pegawai'),
            'value' => '$data->alamat_pegawai',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>