<?php echo $form->errorSummary($modPerawatanLinen); ?>
<div class="row form-horizontal">
    <div class="col-sm-6">
        <?php echo $form->hiddenField($modPerawatanLinen, 'perawatanlinen_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <div class="control-group">
            <?php echo $form->labelEx($modPerawatanLinen, 'tglperawatanlinen', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $modPerawatanLinen->tglperawatanlinen = (!empty($modPerawatanLinen->tglperawatanlinen) ? date("d/m/Y H:i:s", strtotime($modPerawatanLinen->tglperawatanlinen)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $modPerawatanLinen,
                    'attribute' => 'tglperawatanlinen',
                    'mode' => 'datetime',
                    'options' => array(
                        'showOn' => false,
                        //                                'maxDate' => 'd',
                        'yearRange' => "-150:+0",
                    ),
                    'htmlOptions' => array(
                        'placeholder' => '00/00/0000 00:00:00', 'class' => 'dtPicker2 datetimemask span3', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
            </div>
        </div>
        <?php
        echo $form->textFieldRow($modPerawatanLinen, 'noperawatan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'readonly' => true));
        ?>
        <?php echo $form->textAreaRow($modPerawatanLinen, 'keterangan_perawatan', array('rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Keterangan Perawatan')); ?>
        <div class="control-group">
            <?php echo $form->labelEx($modPerawatanLinen, 'pegmengetahui', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($modPerawatanLinen, 'pegmengetahui'); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modPerawatanLinen,
                    'attribute' => 'pegmengetahui_nama',
                    'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompletePegawai') . '",
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
							$("#' . Chtml::activeId($modPerawatanLinen, 'pegmengetahui') . '").val(ui.item.pegawai_id); 
							return false;
						}',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Pegawai Mengetahui',
                        'class' => 'pegmengetahui_nama span3',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modPerawatanLinen, 'pegmengetahui') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-body">
                <?php echo $form->checkBoxRow($modPerawatanLinen, 'iskirimkeluar', array('onkeyup' => "return $(this).focusNextInputField(event);", 'onchange' => 'checkbahanmakan();', 'title' => 'Pilih jika perawatan linen dilakukan diluar RS', 'rel' => 'tooltip')); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modPerawatanLinen, 'tglkirimkeluar', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $modPerawatanLinen->tglkirimkeluar = (!empty($modPerawatanLinen->tglkirimkeluar) ? date("d/m/Y H:i:s", strtotime($modPerawatanLinen->tglkirimkeluar)) : null);
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modPerawatanLinen,
                            'attribute' => 'tglkirimkeluar',
                            'mode' => 'date',
                            'options' => array(
                                'showOn' => false,
                                //                                'maxDate' => 'd',
                                'yearRange' => "-150:+0",
                            ),
                            'htmlOptions' => array(
                                'placeholder' => '00/00/0000', 'class' => 'span2 dtPicker2', 'onkeyup' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <?php echo $form->textAreaRow($modPerawatanLinen, 'alasankirimkeluar', array('placeholder' => 'Alasan Kirim Keluar', 'rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textAreaRow($modPerawatanLinen, 'ketkirimkeluar', array('placeholder' => 'Keterangan Kirim Keluar', 'rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
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
        'height' => 400,
        'resizable' => true,
    ),
));

$modPegawaiMengetahui = new LAPegawaiV('searchDialog');
$modPegawaiMengetahui->unsetAttributes();
if (isset($_GET['LAPegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['LAPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimengetahui-grid',
    'dataProvider' => $modPegawaiMengetahui->searchDialog(),
    'filter' => $modPegawaiMengetahui,
    'template' => "{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
							"href"=>"",
							"id" => "selectObat",
							"onClick" => "
										  $(\"#' . CHtml::activeId($modPerawatanLinen, 'pegmengetahui') . '\").val(\"$data->pegawai_id\");
										  $(\"#' . CHtml::activeId($modPerawatanLinen, 'pegmengetahui_nama') . '\").val(\"$data->NamaLengkap\");
										  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
										  return false;
								"))',
        ),
        array(
            'header' => 'NIP',
            'filter' => CHtml::activeTextField($modPegawaiMengetahui, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Gelar Depan',
            'filter' => CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
            'value' => '$data->gelardepan',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Gelar Belakang',
            'filter' => CHtml::activeTextField($modPegawaiMengetahui, 'gelarbelakang_nama'),
            'value' => '$data->gelarbelakang_nama',
        ),
        array(
            'header' => 'Alamat Pegawai',
            'filter' => CHtml::activeTextField($modPegawaiMengetahui, 'alamat_pegawai'),
            'value' => '$data->alamat_pegawai',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
	jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>