<div class="span6">
    <div class="control-group">
        <?php echo CHtml::label("Cari " . $model->getAttributeLabel('no_rekam_medik'), 'no_rekam_medik', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->hiddenField($model, 'pasien_id'); ?>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'no_rekam_medik',
                //                                'name'=>'no_rekam_medik',
                'value' => $model->no_rekam_medik,
                'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . $this->createUrl('AutocompletePasien') . '",
                                                   dataType: "json",
                                                   data: {
                                                       no_rekam_medik: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                'options' => array(
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                    'select' => 'js:function( event, ui ) {
                                            $(this).val( ui.item.value);                                            
                                            $("#' . CHtml::activeId($model, 'pasien_id') . '").val( ui.item.pasien_id);                                            
                                            return false;
                                        }',
                ),
                'tombolDialog' => array('idDialog' => 'dialogPasien'),
                'htmlOptions' => array(
                    'placeholder' => 'Ketik No. Rekam Medik', 'rel' => 'tooltip', 'title' => 'Ketik No. RM untuk mencari pasien',
                    'onkeyup' => "return $(this).focusNextInputField(event)",
                    'class' => 'numbers-only'
                ),
            ));
            ?>
            <?php echo $form->error($model, 'no_rekam_medik'); ?>
        </div>
    </div>
    <div class="control-group ">
        <?php echo $form->labelEx($model, 'Jenis Penjamin', array('class' => 'control-label refreshable')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('SetDropdownPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
                    //                                                        'update'=>'#'.CHtml::activeId($model, 'penjamin_id'),  //DIHIDE KARENA DIGANTIKAN DENGAN 'success'
                    'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data);}',
                ),
                'class' => 'span3',
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'Penjamin', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama'), array(
                'empty' => '-- Pilih --',
                'onkeyup' => "return $(this).focusNextInputField(event)",
                'class' => 'span3'
            )); ?>
        </div>
    </div>
</div>
<div class="span6"></div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Data Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1060,
        'height' => 480,
        'resizable' => false,
    ),
));
$modDataPasien = new ARPasienM('searchDialog');
$modDataPasien->unsetAttributes();
$format = new MyFormatter();
$modDataPasien->ispasienluar = FALSE;
if (isset($_GET['ARPasienM'])) {
    $modDataPasien->attributes = $_GET['ARPasienM'];
    //        $modDataPasien->tanggal_lahir =  isset($_GET['ARPasienM']['tanggal_lahir']) ? $format->formatDateTimeForDb($_GET['ARPasienM']['tanggal_lahir']) : null;
    $modDataPasien->cari_kelurahan_nama = $_GET['ARPasienM']['cari_kelurahan_nama'];
    $modDataPasien->cari_kecamatan_nama = $_GET['ARPasienM']['cari_kecamatan_nama'];
    if (isset($_GET['ARPasienM']['nomorindukpegawai'])) {
        $modDataPasien->nomorindukpegawai = $_GET['ARPasienM']['nomorindukpegawai'];
    }
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasien-m-grid',
    'dataProvider' => $modDataPasien->searchDialog(),
    'filter' => $modDataPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
								"id" => "selectPasien",
								"onClick" => "
//									$(\"#no_rekam_medik\").val(\"$data->no_rekam_medik\");
									$(\"#' . CHtml::activeId($model, 'no_rekam_medik') . '\").val(\"$data->no_rekam_medik\");
									$(\"#' . CHtml::activeId($model, 'pasien_id') . '\").val(\"$data->pasien_id\");
									$(\"#dialogPasien\").dialog(\"close\");
								"))',
        ),
        'no_rekam_medik',
        'nama_pasien',
        'nama_bin',
        array(
            'name' => 'jeniskelamin',
            'type' => 'raw',
            'filter' => LookupM::model()->getItems('jeniskelamin'),
            'value' => '$data->jeniskelamin'
        ),
        array(
            'name' => 'tanggal_lahir',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
            'filter' => $this->widget(
                'MyDateTimePicker',
                array(
                    'model' => $modDataPasien,
                    'attribute' => 'tanggal_lahir',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => false, 'class' => 'dtPicker3', 'id' => 'tanggal_lahir', 'placeholder' => '23 Jan 1993'),
                ),
                true
            ),
            'htmlOptions' => array('width' => '80', 'style' => 'text-align:center'),
        ),
        'alamat_pasien',
        'rw',
        'rt',
        array(
            'header' => 'Nama Kelurahan',
            'name' => 'cari_kelurahan_nama',
            'type' => 'raw',
            'value' => 'isset($data->kelurahan_id) ? $data->kelurahan->kelurahan_nama : ""'
        ),
        array(
            'header' => 'Nama Kecamatan',
            'name' => 'cari_kecamatan_nama',
            'type' => 'raw',
            'value' => '$data->kecamatan->kecamatan_nama'
        ),
        'norm_lama',
        array(
            'name' => 'statusrekammedis',
            'type' => 'raw',
            'filter' => LookupM::getItems('statusrekammedis'),
            'value' => '$data->statusrekammedis',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
			 jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
			 jQuery(\'#tanggal_lahir\').datepicker(jQuery.extend({
					showMonthAfterYear:false}, 
					jQuery.datepicker.regional[\'id\'], 
				   {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
				   \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
				   \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
			jQuery(\'#tanggal_lahir_date\').on(\'click\', function(){jQuery(\'#tanggal_lahir\').datepicker(\'show\');});


		}',
));
$this->endWidget();
?>