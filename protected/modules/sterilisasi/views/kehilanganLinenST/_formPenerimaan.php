<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Tgl. Kehilangan', 'Tanggal Kehilangan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->penerimaansterilisasi_tgl = !empty($model->penerimaansterilisasi_tgl) ? $format->formatDateTimeForUser($model->penerimaansterilisasi_tgl) : date('d M Y H:i:s');
                echo $form->textField($model, 'penerimaansterilisasi_tgl', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                $model->penerimaansterilisasi_tgl = !empty($model->penerimaansterilisasi_tgl) ? $format->formatDateTimeForDb($model->penerimaansterilisasi_tgl) : date('Y-m-d H:i:s');
                ?>
                <?php echo $form->error($model, 'penerimaansterilisasi_tgl'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('No. Kehilangan <span class="required">*</span>', 'No. Kehilangan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'penerimaansterilisasi_no', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Pegawai Pelapor', 'Pegawai Pelapor', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegmenerima_id'); ?>
                <?php echo $form->textField($model, 'pegawaipenerima_nama', array('readonly' => true, 'class' => 'span3 required')); ?>
                <?php // echo $form->hiddenField($model, 'pegmenerima_id',array('readonly'=>true)); 
                ?>
                <?php
                //				$this->widget('MyJuiAutoComplete', array(
                //					'model'=>$model,
                //					'attribute' => 'pegawaipenerima_nama',
                //					'source' => 'js: function(request, response) {
                //									   $.ajax({
                //										   url: "' . $this->createUrl('AutocompletePegawaiPenerima') . '",
                //										   dataType: "json",
                //										   data: {
                //											   term: request.term,
                //										   },
                //										   success: function (data) {
                //												   response(data);
                //										   }
                //									   })
                //									}',
                //					'options' => array(
                //						'showAnim' => 'fold',
                //						'minLength' => 3,
                //						'focus' => 'js:function( event, ui ) {
                //							$(this).val( ui.item.label);
                //							return false;
                //						}',
                //						'select' => 'js:function( event, ui ) {
                //							$("#'.Chtml::activeId($model, 'pegmenerima_id') . '").val(ui.item.pegawai_id); 
                //							return false;
                //						}',
                //					),
                //					'htmlOptions' => array(
                //						'class'=>'pegawaipenerima_nama',
                //						'onkeyup'=>"return $(this).focusNextInputField(event)",
                //						'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'pegmenerima_id') . '").val(""); '
                //					),
                //					'tombolDialog' => array('idDialog' => 'dialogPegawaiPenerima'),
                //				));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php // echo $form->labelEx($model, 'pegmengetahui_id', array('class' => 'control-label')); 
            ?>
            <?php echo CHtml::label('Pegawai Mengetahui', 'Pegawai Mengetahui', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegmengetahui_id', array('readonly' => true)); ?>
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
							$("#' . Chtml::activeId($model, 'pegmengetahui_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Nama Pegawai',
                        'class' => 'span3 pegawaimengetahui_nama',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'pegmengetahui_id') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'instalasi_id', $instalasiTujuans, array(
                    'class' => 'span3',
                    'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($model))),
                        'update' => "#" . CHtml::activeId($model, 'ruangan_id'),
                    )
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Ruangan <span class="required">*</span>', 'ruangan_id', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'ruangan_id', $ruanganTujuans, array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <?php echo $form->textAreaRow($model, 'penerimaansterilisasi_ket', array('placeholder' => 'Keterangan', 'rows' => 3, 'cols' => 100, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
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
        'width' => 700,
        'height' => 400,
        'zIndex' => 1002,
        'resizable' => true,
    ),
));

//$modPegawaiMengetahui = new STPegawaiV('searchPegawaiMengetahui');
//$modPegawaiMengetahui->unsetAttributes();

$modPegawaiMengetahui = new PegawairuanganV();
$modPegawaiMengetahui->unsetAttributes();
$modPegawaiMengetahui->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['PegawairuanganV'])) {
    $modPegawaiMengetahui->attributes = $_GET['PegawairuanganV'];

    //if(isset($_GET['STPegawaiV'])) {
    //    $modPegawaiMengetahui->attributes = $_GET['STPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimengetahui-grid',
    //	'dataProvider'=>$modPegawaiMengetahui->searchPegawaiMengetahui(),
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
                                                  $(\"#' . CHtml::activeId($model, 'pegmengetahui_id') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#' . CHtml::activeId($model, 'pegawaimengetahui_nama') . '\").val(\"$data->NamaLengkap\");
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
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
            'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
        ),
        array(
            'header' => 'Jabatan',
            'filter' => CHtml::activeTextField($modPegawaiMengetahui, 'jabatan_id'),
            'value' => '$data->getNamaJabatan($data->jabatan_id)',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>